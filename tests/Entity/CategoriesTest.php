<?php

namespace App\Tests\Entity;

use App\Entity\Categories;
use PHPUnit\Framework\TestCase;

class CategoriesTest extends TestCase
{
    public function testCreateCategorie()
    {
        $categorie = new Categories();
        $categorie->setParent(null);
        $categorie->setName('catégorie');
        $categorie->setSlug('categorie');
        $categorie->setCategoryOrder(2);

        $this->assertSame(null, $categorie->getParent());
        $this->assertSame('catégorie', $categorie->getName());
        $this->assertSame('categorie', $categorie->getSlug());
        $this->assertSame(2, $categorie->getCategoryOrder());
    }
}