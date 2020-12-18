<?php

namespace Rabcreatives\Oppwa\Tests\Feature;

use Rabcreatives\Oppwa\Facade\Oppwa;
use Rabcreatives\Oppwa\Tests\TestCase;

/**
 * Class CheckoutTest
 *
 * @package Rabcreatives\Oppwa\Tests\Feature
 */
class OppwaServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function it_can_verify_response_status_invalid_entity_id(): void
    {
        $request = [
            'brand' => 'CHECKOUT',
            'amount' => 100,
            'currency' => 'USD',
            'type' => 'DB',
            'optionalParameters' => [],
        ];

        $response = Oppwa::checkout($request)->pay();
        $response2 = Oppwa::status($response->response->id);

        $this->assertSame($response->status, 200);
        $this->assertSame($response2->status, 200);
    }
}
