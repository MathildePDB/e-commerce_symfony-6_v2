<?php

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Users;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin(): void
    {
        $client = static::createClient();

        $container = self::getContainer();
        $passwordHasher = $container->get(UserPasswordHasherInterface::class);

        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Se connecter');

        // on teste si un utilisateur existant peut se connecter et s'il est redirigé
        $form = $crawler->selectButton('Me connecter')->form([
            'email' => 'GerdaFairbairn@armyspy.com',
            'password' => 'aiP4aic1oo',

        ]);
        $client->submit($form);

        // on vérifie que l'utilisateur a pu se connecter
        $this->assertResponseRedirects('/');
    }

    public function testForgottenPasswordForm(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/oubli-pass');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Réinitialisation du mot de passe');

        $form = $crawler->filter('form[name=reset_password_request_form]')->form([
            'reset_password_request_form[email]' => 'CedivarBoffin@teleworm.us'
        ]);

        $client->submit($form);

        $this->assertResponseRedirects('/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testForgottenPasswordInvalidForm(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/oubli-pass');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Réinitialisation du mot de passe');

        $form = $crawler->filter('form[name=reset_password_request_form]')->form();
        $client->submit($form);

        $this->assertResponseRedirects('/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}
