<?php

namespace App\Tests\Entity;

use App\Entity\Coupons;
use App\Entity\Orders;
use App\Entity\Users;
use PHPUnit\Framework\TestCase;

class OrdersTest extends TestCase
{
    public function testCreateOrder()
    {
        $coupon = new Coupons();
        $user = new Users();
        $order = new Orders();
        $order->setCoupons($coupon);
        $order->setUsers($user);
        $order->setReference('CMD-123');

        $this->assertSame($coupon, $order->getCoupons());
        $this->assertSame($user, $order->getUsers());
        $this->assertSame('CMD-123', $order->getReference());
    }
}