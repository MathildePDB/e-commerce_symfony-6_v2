<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Images;
use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImagesFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categorie = new Categories();
        $categorie->setParent(NULL);
        $categorie->setName('Categorie');
        $categorie->setCategoryOrder(1);
        $categorie->setSlug('categorie');
        $manager->persist($categorie);
        
        $product = new Products();
        $product->setCategories($categorie);
        $product->setName('Product');
        $product->setDescription('description');
        $product->setPrice('3.50');
        $product->setStock('20');
        $product->setSlug('product');
        $manager->persist($product);

        $image1 = new Images();
        $image1->setProducts($product);
        $image1->setName('img-test');
        $manager->persist($image1);

        $image2 = new Images();
        $image2->setProducts($product);
        $image2->setName('img-test');
        $manager->persist($image2);

        $image3 = new Images();
        $image3->setProducts($product);
        $image3->setName('img-test');
        $manager->persist($image3);

        $manager->flush();
    }
}
