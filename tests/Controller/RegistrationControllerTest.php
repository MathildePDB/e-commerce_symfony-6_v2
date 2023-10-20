<?php

namespace App\Tests\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Service\JWTService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testRegister(): void
    {
        // on teste la création d'un nouvel utilisateur
        $client = static::createClient();

        $formData = [
            'registration_form' => [
                'firstname' => 'firstname',
                'lastname' => 'lastname',
                'email' => 'testuser@email.com',
                'address' => 'address',
                'zipcode' => '12345',
                'city' => 'city',
                'plainPassword' => 'azerty',
                'agreeTerms' => true,
            ]
        ];

        $client->request('POST', '/inscription', $formData);

        // $this->assertResponseRedirects('/');
    }

}