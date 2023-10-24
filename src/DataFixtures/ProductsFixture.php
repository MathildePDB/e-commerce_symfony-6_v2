<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductsFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categorie = new Categories();
        $categorie->setParent(NULL);
        $categorie->setName('Categorie');
        $categorie->setCategoryOrder(1);
        $categorie->setSlug('categorie');
        $manager->persist($categorie);

        $product1 = new Products();
        $product1->setCategories($categorie);
        $product1->setName('Product 1');
        $product1->setDescription('description');
        $product1->setPrice('3.50');
        $product1->setStock('20');
        $product1->setSlug('product-1');
        $manager->persist($product1);

        $product2 = new Products();
        $product2->setCategories($categorie);
        $product2->setName('Product 2');
        $product2->setDescription('description');
        $product2->setPrice('2.50');
        $product2->setStock('20');
        $product2->setSlug('product-2');
        $manager->persist($product2);

        $product3 = new Products();
        $product3->setCategories($categorie);
        $product3->setName('Product 3');
        $product3->setDescription('description');
        $product3->setPrice('1.50');
        $product3->setStock('20');
        $product3->setSlug('product-3');
        $manager->persist($product3);

        $product4 = new Products();
        $product4->setCategories($categorie);
        $product4->setName('Product 4');
        $product4->setDescription('description');
        $product4->setPrice('4.50');
        $product4->setStock('10');
        $product4->setSlug('product-4');
        $manager->persist($product4);

        $manager->flush();
    }
}
