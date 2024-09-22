<?php

namespace App\Tests\Entity;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    public function testCommentEntity()
    {
        $comment = new Comment();
        $user = new User();
        $post = new Post();

        $user->setName("Angel");
        $post->setName("Post");
        $comment->setContent('test comment');
        $comment->setRating(2);
        $comment->setDate_Added(new \DateTime());

        $this->assertInstanceOf(\Datetime::class, $comment->getDate_Added());
        $this->assertEquals('test comment', $comment->getContent());
        $this->assertEquals(2, $comment->getRating());

        $comment->setAuthor($user);
        $comment->setPost($post);
        $this->assertSame($user, $comment->getAuthor());
        $this->assertSame($post, $comment->getPost());

    }

}
