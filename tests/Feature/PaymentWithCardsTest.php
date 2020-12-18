<?php

namespace Rabcreatives\Oppwa\Tests\Feature;

use Rabcreatives\Oppwa\Facade\Oppwa;
use Rabcreatives\Oppwa\Tests\TestCase;

/**
 * Class PaymentWithCardsTest
 *
 * @package Rabcreatives\Oppwa\Tests\Feature
 */
class PaymentWithCardsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function it_can_verify_response_payment_payment_cards_success(): void
    {
        $request = [
            'brand' => 'VISA',
            'amount' => 100,
            'currency' => 'USD',
            'type' => 'DB',
            'number' => 4111111111111111,
            'holder' => 'Jane Jones',
            'expiry_month' => 12,
            'expiry_year' => 2025,
            'cvv' => 123,
            'optionalParameters' => [],
        ];

        $response = Oppwa::checkout($request)->pay();

        $this->assertSame($response->status, 200);
    }
}
