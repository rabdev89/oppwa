<?php

namespace Rabcreatives\Oppwa\Tests\Unit;

use Rabcreatives\Oppwa\Brands\PaymentWithCard;
use Rabcreatives\Oppwa\Components\Interfaces\PaymentInterface;
use Rabcreatives\Oppwa\Tests\TestCase;
use Mockery as m;

/**
 * Class PaymentWithCardsTest
 *
 * @property PaymentWithCard|m\MockInterface paymentCards
 * @package Rabcreatives\Oppwa\Tests\Unit
 */
class PaymentWithCardsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->paymentCards = m::mock(PaymentWithCard::class);
    }

    /**
     * @test
     */
    public function paymentCardsImplementsPaymentInterface(): void
    {
        $this->assertInstanceOf(PaymentInterface::class, $this->paymentCards);
    }
}
