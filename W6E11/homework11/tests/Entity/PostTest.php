<?php

namespace App\Tests\Entity;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testPostEntity()
    {
        $post = new Post();
        $user = new User();
        $user->setName("Angel");

        $post->setName('test');
        $post->setDescription('test description');
        $post->setDate_Added(new \DateTime());

        $this->assertEquals('test', $post->getName());
        $this->assertEquals('test description', $post->getDescription());
        $this->assertInstanceOf(\DateTime::class, $post->getDate_Added());

        $post->setAuthor($user);
        $this->assertSame($user, $post->getAuthor());
        $this->AssertEquals("Angel", $post->getAuthor()->getName());

        $comment = new Comment();
        $comment2 = new Comment();
        $comment->setContent("test comment");
        $comment->setRating(3);
        $post->addComment($comment);
        $post->addComment($comment2);

        $this->assertEquals(2, $post->getComments()->count());
        $this->assertEquals(3, $post->getComments()[0]->getRating());
        $this->assertEquals("test comment", $post->getComments()[0]->getContent());

        $post->removeComment($comment);
        $this->assertEquals(1, $post->getComments()->count());
    }

}
