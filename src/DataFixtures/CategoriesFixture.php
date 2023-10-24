<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categorie1 = new Categories();
        $categorie1->setParent(NULL);
        $categorie1->setName('Categorie 1');
        $categorie1->setCategoryOrder(1);
        $categorie1->setSlug('categorie-1');
        $manager->persist($categorie1);

        $categorie2 = new Categories();
        $categorie2->setParent($categorie1);
        $categorie2->setName('Categorie 2');
        $categorie2->setCategoryOrder(2);
        $categorie2->setSlug('categorie-2');
        $manager->persist($categorie2);

        $categorie3 = new Categories();
        $categorie3->setParent($categorie1);
        $categorie3->setName('Categorie 3');
        $categorie3->setCategoryOrder(3);
        $categorie3->setSlug('categorie-3');
        $manager->persist($categorie3);

        $categorie4 = new Categories();
        $categorie4->setParent($categorie1);
        $categorie4->setName('Categorie 4');
        $categorie4->setCategoryOrder(4);
        $categorie4->setSlug('categorie-4');
        $manager->persist($categorie4);

        $manager->flush();
    }
}
