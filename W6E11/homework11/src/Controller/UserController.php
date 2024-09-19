<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPasswordRequestFormType;
use App\Form\UserForgottenPasswordFormType;
use App\Form\UserFormType;
use App\Form\UserResetPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class UserController extends AbstractController
{
    private $em;
    private $userRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->userRepository = $em->getRepository(User::class);
    }

    #[Route('/forgotten_password', name: 'app_forgotten_password')]
    public function forgottenPassword(Request $request): Response
    {
        $form = $this->createForm(UserForgottenPasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userEmail = $form->getData()->getEmail();
            $user = $this->userRepository->findOneBy(['email' => $userEmail]);
            if (!$user) {
                $this->addFlash('error', 'User with this email does not exist.');
                return $this->redirectToRoute('app_forgotten_password');
            } else {
                $newToken = $user->generateToken();
                $user->setToken($newToken);
                $this->em->flush();

                return $this->redirectToRoute('app_reset_password', ['token' => $newToken]);
            }
        }

        return $this->render('user/edit_password.html.twig', [
            'form' => $form->createView(),
            'title' => 'Forgotten Password',
        ]);
    }

    #[Route('/reset_password/{token}', name: 'app_reset_password')]
    public function resetPassword(Request $request, ?string $token = null, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(UserResetPasswordFormType::class);
        $user = $this->userRepository->findOneBy(['token' => $token]);
        if (!$user) {
            $this->addFlash('error', 'Invalid token.');
            return $this->redirectToRoute('app_forgotten_password');
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);

            $user->setPassword($hashedPassword);
            $this->em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/edit_password.html.twig', [
            'form' => $form->createView(),
            'title' => 'Reset Password',
        ]);
    }
}
