<?php

namespace App\Tests\Entity;

use App\Entity\Categories;
use App\Entity\Products;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ProductsTest extends TestCase
{
    public function testCreateProduct()
    {
        $categorie = new Categories();
        $product = new Products();
        $product->setCategories($categorie);
        $product->setName('name');
        $product->setDescription('description');
        $product->setPrice(10);
        $product->setStock(20);
        $date = new DateTimeImmutable('2020-10-20');
        $product->setCreatedAt($date);
        $product->setSlug('name');
        

        $this->assertSame($categorie, $product->getCategories());
        $this->assertSame('name', $product->getName());
        $this->assertSame('description', $product->getDescription());
        $this->assertSame(10, $product->getPrice());
        $this->assertSame(20, $product->getStock());
        $this->assertSame($date, $product->getCreatedAt());
        $this->assertSame('name', $product->getSlug());

    }
}