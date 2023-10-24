<?php

namespace App\Tests\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AdminCategoriesControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        // test de l'accès à la page des categories
        $client = static::createClient();
        
        // On connecte un user qui a les droits products_admin
        $this->loginUser($client);

        $client->request('GET', '/admin/categories');

        $this->assertResponseIsSuccessful();
    }

    private function loginUser($client)
    {
        $container = $client->getContainer();
        $session = $container->get('session');

        $firewallName = 'main';
        $token = $container->get('security.token_storage')->getToken();
        $user = $token->getUser();

        if (!$container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new \RuntimeException('L\'utilisateur n\'est pas authentifié.');
        }

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }

}