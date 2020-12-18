<?php

namespace Rabcreatives\Oppwa\Brands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class PaymentWithCard
 *
 * @package Rabcreatives\Oppwa\Brands
 */
class PaymentWithCard extends Payment
{
    /**
     * @var Card
     */
    protected $card;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var array
     */
    protected $clientConfig = [];

    /**
     * PaymentWithCard constructor.
     *
     * @param float  $amount
     * @param string $currency
     * @param string $brand
     * @param string $type
     * @param array  $optionalParameters
     * @param Card   $card
     */
    public function __construct(
        float $amount,
        string $currency,
        string $brand,
        string $type,
        array $optionalParameters,
        Card $card
    ) {
        parent::__construct($amount, $currency, $brand, $type, $optionalParameters);
        $this->card = $card;

        if (config('oppwa.mode') === 'test') {
            $this->clientConfig = [
                'verify' => false,
            ];
        }
        $this->endpoint = config('oppwa.oppwa_url') . config('oppwa.version') . '/';
    }

    /**
     * Execute the payment
     *
     * @return object
     */
    public function pay(): object
    {
        $data = (object)null;

        try {
            $client = new Client($this->clientConfig);

            $payload = [
                'authentication.userId' => config('oppwa.oppwa_user_id'),
                'authentication.password' => config('oppwa.oppwa_password'),
                'authentication.entityId' => config('oppwa.oppwa_entity_id'),
                'amount' => number_format($this->amount, 2, '.', ''),
                'currency' => $this->currency,
                'paymentBrand' => $this->brand,
                'paymentType' => $this->type,
                'card.number' => $this->card->getNumber(),
                'card.holder' => $this->card->getHolder(),
                'card.expiryMonth' => str_pad($this->card->getExpiryMonth(), 2, '0', STR_PAD_LEFT),
                'card.expiryYear' => $this->card->getExpiryYear(),
                'card.cvv' => $this->card->getCvv(),
            ];

            $response = $client->post($this->endpoint . 'payments', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => array_merge($payload, $this->getOptionalParameters()),
            ]);

            $data->status = $response->getStatusCode();
            $data->response = json_decode($response->getBody()->getContents(), false);

            return $data;
        } catch (ClientException $e) {
            $response = $e->getResponse();

            $data->status = $response->getStatusCode();
            $data->response = json_decode($response->getBody()->getContents(), false);

            return $data;
        }
    }
}
