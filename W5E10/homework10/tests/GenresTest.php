<?php

namespace App\Tests;

use App\Entity\Books;
use App\Entity\Genres;
use PHPUnit\Framework\TestCase;

class GenresTest extends TestCase
{
    public function testGenreEntity(): void
    {
        $genre = new Genres();
        $book = new Books();
        $book->setTitle("New Book");

        $genre->setName("technology");
        $this->assertEquals("technology", $genre->getName());

        $genre->setDescription("description");
        $this->assertEquals("description", $genre->getDescription());

        $genre->addBook($book);
        $this->assertCount(1, $genre->getBooks());
        $this->assertEquals($book, $genre->getBooks()[0]);

        $genre->removeBook($book);
        $this->assertCount(0, $genre->getBooks());
    }
}
