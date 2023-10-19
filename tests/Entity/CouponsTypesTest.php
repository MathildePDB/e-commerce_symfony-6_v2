<?php

namespace App\Tests\Entity;

use App\Entity\CouponsTypes;
use PHPUnit\Framework\TestCase;

class CouponsTypesTest extends TestCase
{
    public function testCreateCouponType()
    {
        $couponType = new CouponsTypes();
        $couponType->setName('coupon type');

        $this->assertSame('coupon type', $couponType->getName());
    }
}