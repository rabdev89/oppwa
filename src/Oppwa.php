<?php

namespace Rabcreatives\Oppwa;

use Rabcreatives\Oppwa\Brands\Card;
use Rabcreatives\Oppwa\Brands\Checkout;
use Rabcreatives\Oppwa\Brands\PaymentWithCard;
use Rabcreatives\Oppwa\Brands\PaymentWithMBWay;
use Rabcreatives\Oppwa\Brands\BrandTransaction;
use Rabcreatives\Oppwa\Components\Interfaces\PaymentInterface;

class Oppwa
{
    protected $client;

    const URL_CHECKOUTS = 'checkouts';
    const URL_PAYMENTS = 'payments';
    const URL_REGISTRATIONS = 'registrations';
    const URL_PAYMENTWIDGET = 'paymentWidgets.js';
    const URL_3DSECURE = 'threeDSecure';

    /**
     * Check if Press config file has been published and set.
     *
     * @return bool
     */
    public function configNotPublished()
    {
        return is_null(config('oppwa'));
    }

    public function setClient(OppwaClient $client)
    {
        $this->client = $client;
        return $this;
    }

    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param array $request
     *
     * @return PaymentInterface
     * @throws Exception
     */
    public function checkout(array $request): PaymentInterface
    {
        switch (strtoupper($request['brand'])) {
            case 'MASTER':
            case 'AMEX':
            case 'VPAY':
            case 'MAESTRO':
            case 'VISADEBIT':
            case 'VISAELECTRON':
            case 'VISA':
                $payment = new PaymentWithCard(
                    $request['amount'],
                    strtoupper($request['currency']),
                    strtoupper($request['brand']),
                    strtoupper($request['type']),
                    $request['optionalParameters'],
                    new Card(
                        $request['number'],
                        $request['holder'],
                        $request['expiry_month'],
                        $request['expiry_year'],
                        $request['cvv']
                    )
                );
                break;
            case 'CHECKOUT':
                $payment = new Checkout(
                    $request['amount'],
                    $request['currency'],
                    $request['type'],
                    $request['optionalParameters'],
                    $request['entityId'],
                    $request['userId'],
                    $request['password'],
                    $request['authorization']
                );
                break;
            case 'MBWAY':
                $payment = new PaymentWithMBWay(
                    $request['amount'],
                    strtoupper($request['currency']),
                    strtoupper($request['brand']),
                    strtoupper($request['type']),
                    $request['accountId'],
                    $request['optionalParameters']
                );
                break;
            default:
                throw new \RuntimeException('Service Payment not found.', 404);
        }

        return $payment;
    }

    /**
     * Get payment status
     *
     * @param string $checkoutId
     *
     * @return object
     */
    public function status(string $checkoutId, string $entityId, string $token): object
    {
        return (new BrandTransaction($checkoutId, $entityId, $token))->status();
    }

}
