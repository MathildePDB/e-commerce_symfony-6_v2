<?php

namespace App\Tests\Entity;

use App\Entity\Users;
use PHPUnit\Framework\TestCase;

class UsersTest extends TestCase
{
    public function testCreateUser()
    {
        $user = new Users();
        $user->setEmail('user@email.com');
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword('azerty');
        $user->setLastname('lastname');
        $user->setFirstname('firstname');
        $user->setAddress('address');
        $user->setZipcode('12345');
        $user->setCity('city');

        $this->assertSame('user@email.com', $user->getEmail());
        $this->assertSame(["ROLE_USER"], $user->getRoles());
        $this->assertSame('azerty', $user->getPassword());
        $this->assertSame('lastname', $user->getLastname());
        $this->assertSame('firstname', $user->getFirstname());
        $this->assertSame('address', $user->getAddress());
        $this->assertSame('12345', $user->getZipcode());
        $this->assertSame('city', $user->getCity());
    }

}