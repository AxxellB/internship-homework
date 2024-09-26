<?php

namespace App\Tests\Panther;

use Symfony\Component\Panther\PantherTestCase;

class CategoriesTest extends PantherTestCase
{

    public function testCategoriesPageLoads(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/categories_display');

        $this->assertSelectorTextContains('h1', 'Categories');
    }


    public function testCategoriesTableIsPresent(): void
    {
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/categories-display');

        $this->assertCount(2, $crawler->filter('table'), 'The table should exist on the page');
    }

    public function testCategoriesCreateFormIsPresent(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/category_create');

        $this->assertCount(1, $crawler->filter('form'), 'The create category form should be present on the page.');
    }
}
