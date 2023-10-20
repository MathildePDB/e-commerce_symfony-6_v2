<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfileControllerTest extends WebTestCase
{
    private function login($client)
    {
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Me connecter')->form();
        $form['email'] = 'HaiducBanks@teleworm.us';
        $form['password'] = 'eCh9ohrai3ah';

        $client->submit($form);
        $client->followRedirects();
    }

    public function testIndex(): void
    {
        // test de l'accès à la page de profil
        $client = static::createClient();
        $this->login($client);
        
        $crawler = $client->request('GET', '/profile');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
