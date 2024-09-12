<?php

namespace App\Tests\Controllers;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    private $client;
    public function setUp(): void{
        $this->client = static::createClient();
    }

    public function testCreateProduct(): void
    {
        $this->client->request('POST', 'api/products', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'name' => 'New Test',
            'price' => '30',
            'quantity' => '45',
            'category' => 'New Category'
        ]));

        $responseData = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
        $this->assertArrayHasKey('name', $responseData);
        $this->assertEquals('New Test', $responseData['name']);
        $this->assertArrayHasKey('price', $responseData);
        $this->assertEquals('30', $responseData['price']);
        $this->assertArrayHasKey('quantity', $responseData);
        $this->assertEquals('45', $responseData['quantity']);
        $this->assertArrayHasKey('category', $responseData);
        $this->assertEquals('New Category', $responseData['category']['name']);
    }

    public function testListProducts(): void
    {
        $this->client->request('GET', '/api/products');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testGetProduct(): void
    {
        $this->client->request('GET', '/api/products/1');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testUpdateProduct(): void
    {
        $this->client->request('PUT', '/api/products/2', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'name' => 'Update Test',
            'price' => '50',
            'quantity' => '60',
            'category' => 'New Category'
        ]));

        $responseData = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
        $this->assertArrayHasKey('name', $responseData);
        $this->assertEquals('Update Test', $responseData['name']);
        $this->assertArrayHasKey('price', $responseData);
        $this->assertEquals('50', $responseData['price']);
        $this->assertArrayHasKey('quantity', $responseData);
        $this->assertEquals('60', $responseData['quantity']);
        $this->assertArrayHasKey('category', $responseData);
        $this->assertEquals('New Category', $responseData['category']['name']);
    }

    public function testDeleteProduct()
    {
        $this->client->request('DELETE', '/api/products/5');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', '/api/products/5');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateProductFailsWithBadData(): void
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

    public function testGetProductFailsWithWrongId(): void
    {
        $this->client->request('GET', '/api/products/876');

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('No product found', $responseData['message']);
    }

    public function testDeleteProductFailsWithWrongId(): void
    {
        $this->client->request('DELETE', '/api/products/876');

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('No product found', $responseData['message']);
    }

    public function testUpdateProductFailsWithWrongId(): void
    {
        $this->client->request('PUT', '/api/products/988', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'name' => 'Updated Category',
            'description' => 'Updated description',
        ]));

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('No product found', $responseData['message']);
    }

    public function testUpdateProductFailsWithWrongData(): void
    {
        $this->client->request('PUT', '/api/products/2', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'name' => '',
        ]));

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
        $this->assertArrayHasKey('error', $responseData);
        $this->assertEquals('Name must be at least 2 characters long', $responseData['error']);
    }
}