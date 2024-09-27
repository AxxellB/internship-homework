<?php

namespace App\Tests;

use App\Entity\Authors;
use PHPUnit\Framework\TestCase;

class AuthorsTest extends TestCase
{
    public function testAuthorEntity(): void
    {
        $author = new Authors();

        $author->setName("Angel");
        $this->assertEquals("Angel", $author->getName());

        $author->setNationality("Bulgarian");
        $this->assertEquals("Bulgarian", $author->getNationality());

        $yearOfBirth = new \DateTime('2000-08-24');
        $author->setYearOfBirth($yearOfBirth);
        $this->assertEquals($yearOfBirth, $author->getYearOfBirth());
    }
}
