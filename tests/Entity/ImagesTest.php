<?php

namespace App\Tests\Entity;

use App\Entity\Images;
use App\Entity\Products;
use PHPUnit\Framework\TestCase;

class ImagesTest extends TestCase
{
    public function testCreateImage()
    {
        $product = new Products();
        $image = new Images();
        $image->setProducts($product);
        $image->setName('name');

        $this->assertSame($product, $image->getProducts());
        $this->assertSame('name', $image->getName());
    }
}