<?php

namespace Rabcreatives\Oppwa\Brands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class Transaction
 *
 * @package Rabcreatives\Oppwa\Brands
 */
class BrandTransaction
{
    /**
     * @var string
     */
    protected $checkoutId;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var array
     */
    protected $clientConfig = [];

    /**
     * @var string
     */
    protected $authorization;

    /**
     * Transaction constructor.
     *
     * @param string $checkoutId
     */
    public function __construct(string $checkoutId, string $entityId, string $token)
    {
        $this->setCheckoutId($checkoutId);
        $this->setEntityId($entityId);
        $this->setAuthorizationToken($token);

        if (config('oppwa.mode') === 'test') {
            $this->clientConfig = [
                'verify' => false,
            ];
        }
        $this->endpoint = config('oppwa.oppwa_url') . config('oppwa.version') . '/';
    }

    /**
     * @return string
     */
    public function getCheckoutId(): string
    {
        return $this->checkoutId;
    }

    /**
     * @param mixed $checkoutId
     */
    public function setCheckoutId($checkoutId): void
    {
        $this->checkoutId = $checkoutId;
    }

    /**
     * @return string
     */
    public function getAuthorizationToken(): string
    {
        return 'Bearer '.$this->authorization;
    }

    /**
     * @param string $authorization
     */
    public function setAuthorizationToken(string $authorization): void
    {
        $this->authorization = $authorization;
    }

    /**
     * @return string
     */
    public function getEntityId(): string
    {
        return $this->entityId;
    }

    /**
     * @param mixed $checkoutId
     */
    public function setEntityId($entityId): void
    {
        $this->entityId = $entityId;
    }


    /**
     * Get status payment
     *
     * @return object
     */
    public function status(): object
    {
        $data = (object)null;

        try {
            $client = new Client($this->clientConfig);

            $response = $client->get($this->endpoint . "checkouts/{$this->getCheckoutId()}/payment?entityId=" . $this->getEntityId(),
                [
                    'headers' => [
                        'Authorization' => $this->getAuthorizationToken(),
                    ],
                ]);

            $data->status = $response->getStatusCode();
            $data->response = json_decode($response->getBody()->getContents());

            return $data;
        } catch (ClientException $e) {
            $response = $e->getResponse();

            $data->status = $response->getStatusCode();
            $data->response = json_decode($response->getBody()->getContents());

            return $data;
        }
    }
}
