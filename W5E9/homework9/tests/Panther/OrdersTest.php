<?php

namespace App\Tests\Panther;

use Symfony\Component\Panther\PantherTestCase;

class OrdersTest extends PantherTestCase
{
    public function testOrdersPageLoads(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/orders_display');

        $this->assertSelectorTextContains('h1', 'Orders');
    }

    public function testOrdersTableIsPresent(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/orders_display');

        $this->assertCount(1, $crawler->filter('table'), 'The orders table should exist on the page.');
    }

    public function testOrdersCreateFormIsPresent(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/order_create');

        $this->assertCount(1, $crawler->filter('form'), 'The create order form should be present on the page.');
        $this->assertCount(1, $crawler->filter('input[name="order_create_form[order_date]"]'), 'The form should contain an order date input field.');
        $this->assertCount(1, $crawler->filter('input[name="order_create_form[total]"]'), 'The form should contain a total input field.');
        $this->assertCount(1, $crawler->filter('select[name="order_create_form[status]"]'), 'The form should contain a status select field.');
        $this->assertCount(1, $crawler->filter('select[name="order_create_form[customer]"]'), 'The form should contain a customer select field.');
        $this->assertCount(1, $crawler->filter('button[type="submit"]'), 'The form should have a submit button.');
    }

}