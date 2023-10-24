<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrdersControllerTest extends WebTestCase
{
    private function login($client)
    {
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Me connecter')->form();
        $form['email'] = 'user@email.com';
        $form['password'] = 'azerty';

        $client->submit($form);
        $client->followRedirects();
    }

    public function testIndex(): void
    {
        // test de l'accès à la page des commandes
        $client = static::createClient();
        $this->login($client);
     
        $crawler = $client->request('GET', '/commandes');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAdd(): void
    {
        // test de l'accès à la page de créaion d'une commande
        $client = static::createClient();
        $this->login($client);

        $crawler = $client->request('GET', '/commandes/ajout');

        // $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDetail(): void
    {
        // test de l'accès à la page de détails d'une commande
        $client = static::createClient();
        $this->login($client);

        $crawler = $client->request('GET', '/commandes/33');

        // $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}