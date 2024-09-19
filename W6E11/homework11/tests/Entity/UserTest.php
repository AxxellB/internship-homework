<?php

namespace App\Tests\Entity;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserEntity()
    {
        $user = new User();

        $user->setEmail('test@test.com');
        $user->setPassword('test');
        $user->setRoles(['ROLE_AUTHOR']);
        $user->setToken("test");

        $this->assertEquals('test@test.com', $user->getEmail());
        $this->assertEquals('test', $user->getPassword());
        $this->assertContains('ROLE_AUTHOR', $user->getRoles());
        $this->assertEquals('test', $user->getToken());

        $comment = new Comment();
        $comment->setContent('test comment');
        $comment->setRating(5);

        $user->addComment($comment);
        $this->assertEquals(1, $user->getComments()->count());
        $this->assertEquals(5, $user->getComments()[0]->getRating());
        $this->assertEquals('test comment', $user->getComments()[0]->getContent());

        $user->removeComment($comment);
        $this->assertEquals(0, $user->getComments()->count());

        $post = new Post();
        $post->setName('test post');
        $post->setDescription('test description');

        $user->addPost($post);
        $this->assertEquals(1, $user->getPosts()->count());
        $this->assertEquals('test post', $user->getPosts()[0]->getName());
        $this->assertEquals('test description', $user->getPosts()[0]->getDescription());

        $user->removePost($post);
        $this->assertEquals(0, $user->getPosts()->count());
    }

}
