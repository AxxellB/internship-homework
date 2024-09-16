<?php

namespace App\Entity;

use App\Repository\EditorsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EditorsRepository::class)]
class Editors
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $EditorNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Specialty = null;

    /**
     * @var Collection<int, Books>
     */
    #[ORM\ManyToMany(targetEntity: Books::class, mappedBy: 'Editors')]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getEditorNumber(): ?string
    {
        return $this->EditorNumber;
    }

    public function setEditorNumber(string $EditorNumber): static
    {
        $this->EditorNumber = $EditorNumber;

        return $this;
    }

    public function getSpecialty(): ?string
    {
        return $this->Specialty;
    }

    public function setSpecialty(?string $Specialty): static
    {
        $this->Specialty = $Specialty;

        return $this;
    }

    /**
     * @return Collection<int, Books>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Books $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->addEditor($this);
        }

        return $this;
    }

    public function removeBook(Books $book): static
    {
        if ($this->books->removeElement($book)) {
            $book->removeEditor($this);
        }

        return $this;
    }
}
