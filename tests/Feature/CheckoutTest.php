<?php

namespace Rabcreatives\Oppwa\Tests\Feature;

use Rabcreatives\Oppwa\Facade\Oppwa;
use Rabcreatives\Oppwa\Tests\TestCase;

/**
 * Class CheckoutTest
 *
 * @package Rabcreatives\Oppwa\Tests\Feature
 */
class CheckoutTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function it_can_verify_response_checkout_success(): void
    {
        $request = [
            'brand' => 'CHECKOUT',
            'amount' => 100,
            'currency' => 'USD',
            'type' => 'DB',
            'optionalParameters' => [],
        ];

        $response = Oppwa::checkout($request)->pay();

        $this->assertSame($response->status, 200);
    }
}
