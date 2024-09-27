<?php

namespace App\Entity;

use App\Repository\BooksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BooksRepository::class)]
class Books
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    private ?string $ISBN = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $YearOfPublishing = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Authors $Author = null;

    /**
     * @var Collection<int, Editors>
     */
    #[ORM\ManyToMany(targetEntity: Editors::class, inversedBy: 'books')]
    private Collection $Editors;

    /**
     * @var Collection<int, Genres>
     */
    #[ORM\ManyToMany(targetEntity: Genres::class, inversedBy: 'books')]
    private Collection $Genres;

    public function __construct()
    {
        $this->Editors = new ArrayCollection();
        $this->Genres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getISBN(): ?string
    {
        return $this->ISBN;
    }

    public function setISBN(string $ISBN): static
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getYearOfPublishing(): ?\DateTimeInterface
    {
        return $this->YearOfPublishing;
    }

    public function setYearOfPublishing(\DateTimeInterface $YearOfPublishing): static
    {
        $this->YearOfPublishing = $YearOfPublishing;

        return $this;
    }

    public function getAuthor(): ?Authors
    {
        return $this->Author;
    }

    public function setAuthor(?Authors $Author): static
    {
        $this->Author = $Author;

        return $this;
    }

    /**
     * @return Collection<int, Editors>
     */
    public function getEditors(): Collection
    {
        return $this->Editors;
    }

    public function addEditor(Editors $editor): static
    {
        if (!$this->Editors->contains($editor)) {
            $this->Editors->add($editor);
        }

        return $this;
    }

    public function removeEditor(Editors $editor): static
    {
        $this->Editors->removeElement($editor);

        return $this;
    }

    /**
     * @return Collection<int, Genres>
     */
    public function getGenres(): Collection
    {
        return $this->Genres;
    }

    public function addGenre(Genres $genre): static
    {
        if (!$this->Genres->contains($genre)) {
            $this->Genres->add($genre);
        }

        return $this;
    }

    public function removeGenre(Genres $genre): static
    {
        $this->Genres->removeElement($genre);

        return $this;
    }
}
