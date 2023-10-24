<?php

namespace App\DataFixtures;

use App\Entity\Orders;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrdersFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new Users();
        $user->setEmail('user1@email.com');
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword('azerty');
        $user->setLastname('lastname');
        $user->setFirstname('firstname');
        $user->setAddress('address');
        $user->setZipcode('12345');
        $user->setCity('city');
        $user->setResetToken('reset');
        $manager->persist($user);
        
        $order1 = new Orders();
        $order1->setUsers($user);
        $order1->setReference('REF-CMD-001');
        $manager->persist($order1);

        $order2 = new Orders();
        $order2->setUsers($user);
        $order2->setReference('REF-CMD-002');
        $manager->persist($order2);

        $manager->flush();
    }
}
