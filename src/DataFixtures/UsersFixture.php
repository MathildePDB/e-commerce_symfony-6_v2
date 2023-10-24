<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UsersFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user1 = new Users();
        $user1->setEmail('user1@email.fr');
        $user1->setRoles(["ROLE_ADMIN"]);
        $user1->setPassword('azerty');
        $user1->setLastname('lastname');
        $user1->setFirstname('firstname');
        $user1->setAddress('address');
        $user1->setZipcode('12345');
        $user1->setCity('city');
        $user1->setResetToken('reset');
        $manager->persist($user1);

        $user2 = new Users();
        $user2->setEmail('user2@email.com');
        $user2->setRoles(["ROLE_PRODUCTS_ADMIN"]);
        $user2->setPassword('azerty');
        $user2->setLastname('lastname');
        $user2->setFirstname('firstname');
        $user2->setAddress('address');
        $user2->setZipcode('12345');
        $user2->setCity('city');
        $user2->setResetToken('reset2');
        $manager->persist($user2);

        $user3 = new Users();
        $user3->setEmail('user3@email.com');
        $user3->setRoles(["ROLE_USER"]);
        $user3->setPassword('azerty');
        $user3->setLastname('lastname');
        $user3->setFirstname('firstname');
        $user3->setAddress('address');
        $user3->setZipcode('12345');
        $user3->setCity('city');
        $user3->setResetToken('reset3');
        $manager->persist($user3);

        $user4 = new Users();
        $user4->setEmail('user4@email.com');
        $user4->setRoles(["ROLE_USER"]);
        $user4->setPassword('azerty');
        $user4->setLastname('lastname');
        $user4->setFirstname('firstname');
        $user4->setAddress('address');
        $user4->setZipcode('12345');
        $user4->setCity('city');
        $user4->setResetToken('reset4');
        $manager->persist($user4);

        $manager->flush();
    }
}
