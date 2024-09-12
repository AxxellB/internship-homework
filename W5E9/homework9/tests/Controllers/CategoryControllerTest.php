<?php

namespace App\Tests\Controllers;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    private $client;
    public function setUp(): void{
        $this->client = static::createClient();
    }

    public function testCreateCategory(): void
    {
        $this->client->request('POST', 'api/categories', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'name' => 'New Category',
            'description' => 'Category description',
        ]));

        $responseData = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
        $this->assertArrayHasKey('name', $responseData);
        $this->assertEquals('New Category', $responseData['name']);
        $this->assertArrayHasKey('description', $responseData);
        $this->assertEquals('Category description', $responseData['description']);
    }

    public function testListCategories(): void
    {
        $this->client->request('GET', '/api/categories');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testGetCategory(): void
    {
        $this->client->request('GET', '/api/categories/2');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testUpdateCategory(): void
    {
        $this->client->request('PUT', '/api/categories/2', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'name' => 'Updated Category',
            'description' => 'Updated description',
        ]));

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testDeleteCategory()
    {
        $this->client->request('DELETE', '/api/categories/2');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', '/api/categories/2');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateCategoryFailsWithBadData(): void
    {
        $this->client->request('POST', 'api/categories', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'name' => 'N',
        ]));

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Name and description must be at least 2 characters long', $responseData['message']);
    }

    public function testGetCategoryFailsWithWrongId(): void
    {
        $this->client->request('GET', '/api/categories/876');

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Category not found', $responseData['message']);
    }

    public function testDeleteCategoryFailsWithWrongId(): void
    {
        $this->client->request('DELETE', '/api/categories/876');

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Category not found', $responseData['message']);
    }

    public function testUpdateCategoryFailsWithWrongId(): void
    {
        $this->client->request('PUT', '/api/categories/988', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'name' => 'Updated Category',
            'description' => 'Updated description',
        ]));

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Category not found', $responseData['message']);
    }

    public function testUpdateCategoryFailsWithWrongData(): void
    {
        $this->client->request('PUT', '/api/categories/4', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'name' => 'Updated Category',
        ]));

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Name and description must be at least 2 characters long', $responseData['message']);
    }
}