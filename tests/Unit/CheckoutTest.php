<?php

namespace Rabcreatives\Oppwa\Tests\Unit;

use Rabcreatives\Oppwa\Brands\Checkout;
use Rabcreatives\Oppwa\Components\Interfaces\PaymentInterface;
use Rabcreatives\Oppwa\Tests\TestCase;
use Mockery as m;

/**
 * Class CheckoutTest
 *
 * @property m\MockInterface checkout
 * @package Rabcreatives\Oppwa\Tests\Unit
 */
class CheckoutTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->checkout = m::mock(Checkout::class);
    }

    /**
     * @test
     */
    public function checkoutImplementsPaymentInterfaceTest(): void
    {
        $this->assertInstanceOf(PaymentInterface::class, $this->checkout);
    }
}
