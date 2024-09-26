<?php

namespace App\Tests\Panther;

use Symfony\Component\Panther\PantherTestCase;

class CustomersTest extends PantherTestCase
{
    public function testCustomersPageLoads(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/customers_display');

        $this->assertSelectorTextContains('h1', 'Customers');
    }

    public function testCustomersTableIsPresent(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/customers_display');

        $this->assertCount(1, $crawler->filter('table'), 'The customers table should exist on the page.');
    }

    public function testCustomersCreateFormIsPresent(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/customer_create');

        $this->assertCount(1, $crawler->filter('form'), 'The create customer form should be present on the page.');
        $this->assertCount(1, $crawler->filter('input[name="customer_create_form[name]"]'), 'The form should contain a name input field.');
        $this->assertCount(1, $crawler->filter('input[name="customer_create_form[email]"]'), 'The form should contain an email input field.');
        $this->assertCount(1, $crawler->filter('input[name="customer_create_form[address]"]'), 'The form should contain an address input field.');
        $this->assertCount(1, $crawler->filter('button[type="submit"]'), 'The form should have a submit button.');
    }

}
