<?php

namespace App\Tests;

use App\Entity\Books;
use App\Entity\Editors;
use PHPUnit\Framework\TestCase;

class EditorsTest extends TestCase
{
    public function testEditorEntity(): void
    {
        $book  = new Books();
        $editor = new Editors();
        $editor->setName("Angel");
        $this->assertEquals("Angel", $editor->getName());

        $editor->setEditorNumber("1662");
        $this->assertEquals("1662", $editor->getEditorNumber());

        $editor->setSpecialty("Tech");
        $this->assertEquals("Tech", $editor->getSpecialty());

        $book->setTitle("Book Title");
        $editor->addBook($book);
        $this->assertCount(1, $editor->getBooks());
        $this->assertEquals($book, $editor->getBooks()[0]);

        $editor->removeBook($book);
        $this->assertCount(0, $editor->getBooks());
    }
}
