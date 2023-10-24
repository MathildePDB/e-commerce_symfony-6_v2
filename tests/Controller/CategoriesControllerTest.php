<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoriesControllerTest extends WebTestCase
{
    public function testList(): void
    {
        // test de l'accès à la page des categories
        $client = static::createClient();
        $crawler = $client->request('GET', '/categories/categorie-2');
        $this->assertResponseIsSuccessful();
    }

}