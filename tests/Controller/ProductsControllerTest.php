<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductsControllerTest extends WebTestCase
{    
    public function testIndex(): void
    {
        // test de l'accès à la page des produits
        $client = static::createClient();
        $client->request('GET', '/produits/?page=1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDetails(): void
    {
        // test de l'accès à la page des produits
        $client = static::createClient();
        $client->request('GET', '/produits/Erable-du-Japon');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
