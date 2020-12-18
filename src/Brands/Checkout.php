<?php

namespace Rabcreatives\Oppwa\Brands;

use Rabcreatives\Oppwa\Components\Interfaces\PaymentInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class Checkout
 *
 * @package Rabcreatives\Oppwa\Brands
 */
class Checkout implements PaymentInterface
{
    /**
     * @var float
     */
    protected $amount;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $entityId;

    /**
     * @var string
     */
    protected $userId;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $authorization;

    /**
     * @var string
     */
    protected $paymentType = 'DB';

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var array
     */
    protected $clientConfig = [];

    /**
     * @var array
     */
    protected $optionalParameters = [];

    /**
     * Checkout constructor.
     *
     * @param float  $amount
     * @param string $currency
     * @param string $paymentType
     * @param array  $optionalParameters
     */
    public function __construct(float $amount, string $currency, string $paymentType, array $optionalParameters,
                                string $entityId,
                                string $userId,
                                string $password,
                                string $authorization)
    {
        $this->setAmount($amount);
        $this->setCurrency($currency);
        $this->setPaymentType($paymentType);
        $this->setOptionalParameters($optionalParameters);
        $this->setEntityId($entityId);
        $this->setUserId($userId);
        $this->setPassword($password);
        $this->setAuthorizationToken($authorization);

        if (config('oppwa.mode') === 'test') {
            $this->clientConfig = [
                'verify' => false,
            ];
        }
        $this->endpoint = config('oppwa.oppwa_url') . config('oppwa.version') . '/';
    }

    /**
     * @return array
     */
    public function getOptionalParameters(): array
    {
        return $this->optionalParameters;
    }

    /**
     * @param array $optionalParameters
     */
    public function setOptionalParameters(array $optionalParameters): void
    {
        $this->optionalParameters = $optionalParameters;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getEntityId(): string
    {
        return $this->entityId;
    }

    /**
     * @param string $entityId
     */
    public function setEntityId(string $entityId): void
    {
        $this->entityId = $entityId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getAuthorizationToken(): string
    {
        return $this->authorization;
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
    public function getPaymentType(): string
    {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     */
    public function setPaymentType(string $paymentType): void
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @return object
     */
    public function pay(): object
    {
        $data = (object)null;

        try {
            $client = new Client($this->clientConfig);

            $payload = [
                'entityId' => $this->entityId,
                'amount' => number_format($this->amount, 2),
                'currency' => $this->currency,
                'paymentType' => $this->paymentType,
            ];
            if (config('oppwa.mode') === 'test') {
                $payload = array_merge($payload,
                    [
                        'customParameters[OPPWA_ENV]' => 'QLY',
                        'testMode' => 'EXTERNAL',
                    ]);
            }

            $response = $client->post($this->endpoint . 'checkouts', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Content-Length' => ob_get_length(),
                    'Authorization' => 'Bearer '.$this->authorization,
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
