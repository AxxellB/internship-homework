<?php

namespace App\Tests\Panther;

use App\DataFixtures\ProductFixtures;
use Symfony\Component\Panther\PantherTestCase;

class ProductsTest extends PantherTestCase
{

    public function testProductsPageLoads(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/products_display');

        $this->assertSelectorTextContains('h1', 'Products');
    }

    public function testProductsTableIsPresent(): void
    {

        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/products_display');

        $this->assertCount(1, $crawler->filter('table'), 'The products table should exist on the page.');
    }

    public function testProductsCreateFormIsPresent(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/product_create');

        $this->assertCount(1, $crawler->filter('form'), 'The create product form should be present on the page.');
        $this->assertCount(1, $crawler->filter('input[name="product_create_form[name]"]'), 'The form should contain a name input field.');
        $this->assertCount(1, $crawler->filter('textarea[name="product_create_form[description]"]'), 'The form should contain a description textarea.');
        $this->assertCount(1, $crawler->filter('button[type="submit"]'), 'The form should have a submit button.');
    }
}
