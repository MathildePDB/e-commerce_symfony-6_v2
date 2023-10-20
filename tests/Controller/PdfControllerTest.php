<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PdfControllerTest extends WebTestCase
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
    
    public function testOrder(): void
    {
        // test de la génération du pdf de la commande
        $client = static::createClient();
        $this->login($client);
        
        $crawler = $client->request('GET', '/pdf/commande/10');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
