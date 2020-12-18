<?php

namespace Rabcreatives\Oppwa\Brands;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class PaymentWithMBWay
 *
 * @package Rabcreatives\Oppwa\Brands
 */
class PaymentWithMBWay extends Payment
{
    /**
     * @var string
     */
    protected $accountId;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var array
     */
    protected $clientConfig = [];

    /**
     * PaymentWithMBWay constructor.
     *
     * @param float  $amount
     * @param string $currency
     * @param string $brand
     * @param string $type
     * @param string $accountId
     * @param array  $optionalParameters
     */
    public function __construct(
        float $amount,
        string $currency,
        string $brand,
        string $type,
        string $accountId,
        array $optionalParameters
    ) {
        parent::__construct($amount, $currency, $brand, $type, $optionalParameters);
        $this->accountId = $accountId;
        $this->endpoint = config('oppwa.oppwa_url') . config('oppwa.version') . '/';
    }

    /**
     * Execute the payment
     *
     * @return object
     */
    public function pay()
    {
        $data = (object)null;

        try {
            $client = new Client($this->clientConfig);

            $payload = [
                'entityId' => config('oppwa.oppwa_entity_id'),
                'amount' => number_format($this->amount, 2, '.', ''),
                'currency' => $this->currency,
                'paymentBrand' => $this->brand,
                'paymentType' => $this->type,
                'virtualAccount.accountId' => $this->accountId,
            ];
            if (config('oppwa.mode') === 'test') {
                $payload = array_merge($payload,
                    [
                        'customParameters[OPPWA_ENV]' => 'QLY',
                        'testMode' => 'EXTERNAL',
                    ]);
            }
            $response = $client->post($this->endpoint . 'payments', [
                'headers' => [
                    'Authorization' => config('oppwa.oppwa_token'),
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
