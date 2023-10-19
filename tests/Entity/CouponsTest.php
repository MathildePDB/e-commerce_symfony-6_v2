<?php

namespace App\Tests\Entity;

use App\Entity\Coupons;
use DateTime;
use PHPUnit\Framework\TestCase;

class CouponsTest extends TestCase
{
    public function testCreateCoupon()
    {
        $coupon = new Coupons();
        $coupon->setCouponsTypes(null);
        $coupon->setCode('COUPON');
        $coupon->setDescription('ceci est un coupon');
        $coupon->setDiscount(1);
        $coupon->setMaxUsage(20);

        $this->assertSame(null, $coupon->getCouponsTypes());
        $this->assertSame('COUPON', $coupon->getCode());
        $this->assertSame('ceci est un coupon', $coupon->getDescription());
        $this->assertSame(1, $coupon->getDiscount());
        $this->assertSame(20, $coupon->getMaxUsage());
    }
}