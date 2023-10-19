<?php

namespace App\Tests\Entity;

use App\Entity\Orders;
use App\Entity\OrdersDetails;
use App\Entity\Products;
use PHPUnit\Framework\TestCase;

class OrdersDetailsTest extends TestCase
{
    public function testCreateOrderDetail()
    {
        $order = new Orders();
        $product = new Products();
        $orderDetail = new OrdersDetails();

        $orderDetail->setOrders($order);
        $orderDetail->setProducts($product);
        $orderDetail->setQuantity(20);
        $orderDetail->setPrice(10);

        $this->assertSame($order, $orderDetail->getOrders());
        $this->assertSame($product, $orderDetail->getProducts());
        $this->assertSame(20, $orderDetail->getQuantity());
        $this->assertSame(10, $orderDetail->getPrice());
    }
}