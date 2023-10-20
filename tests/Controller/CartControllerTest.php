<?php

namespace App\Tests\Controller;

use App\Entity\Categories;
use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        // test de l'accès à la page du panier
        $client = static::createClient();
        $crawler = $client->request('GET', '/cart');

        $client->followRedirect();

        $this->assertResponseIsSuccessful();
    }

    public function testAdd(): void
    {
        // test d'ajout d'un produit au panier
        $client = static::createClient();
        $crawler = $client->request('GET', '/cart/add/30');

        $client->followRedirect();

        $this->assertResponseIsSuccessful();
    }

    public function testRemove(): void
    {
        // test de suppression d'un produit du panier
        $client = static::createClient();
        $crawler = $client->request('GET', '/cart/remove/30');

        $client->followRedirect();

        $this->assertResponseIsSuccessful();
    }

    public function testDelete(): void
    {
        // test de suppression de tous les produits ayant le même id dans le panier
        $client = static::createClient();
        $crawler = $client->request('GET', '/cart/delete/30');

        $client->followRedirect();

        $this->assertResponseIsSuccessful();
    }

    public function testEmpty(): void
    {
        // test de suppression du panier
        $client = static::createClient();
        $crawler = $client->request('GET', '/cart/empty');

        $client->followRedirect();

        $this->assertResponseIsSuccessful();
    }

}
