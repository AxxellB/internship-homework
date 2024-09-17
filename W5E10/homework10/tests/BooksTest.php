<?php

namespace App\Tests;

use App\Entity\Authors;
use App\Entity\Books;
use App\Entity\Editors;
use App\Entity\Genres;
use PHPUnit\Framework\TestCase;
use DateTime;

class BooksTest extends TestCase
{
    public function testBookEntity(): void
    {
        $book = new Books();
        $author = new Authors();
        $editor = new Editors();
        $genre = new Genres();

        $book->setTitle('Test Book');
        $this->assertEquals('Test Book', $book->getTitle());

        $book->setISBN('1234567890');
        $this->assertEquals('1234567890', $book->getISBN());

        $date = new DateTime('2022-01-01');
        $book->setYearOfPublishing($date);
        $this->assertEquals($date, $book->getYearOfPublishing());

        $book->setAuthor($author);
        $this->assertSame($author, $book->getAuthor());

        $book->addEditor($editor);
        $this->assertCount(1, $book->getEditors());
        $book->removeEditor($editor);
        $this->assertCount(0, $book->getEditors());

        $book->addGenre($genre);
        $this->assertCount(1, $book->getGenres());
        $book->removeGenre($genre);
        $this->assertCount(0, $book->getGenres());
    }
}

