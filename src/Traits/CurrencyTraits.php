<?php

namespace Rabcreatives\Oppwa\Traits;

trait CurrencyTraits
{
    public static function getCurrencySymbols()
    {

        return $currency_symbol = [
            'USD' => '&#36;',
            'PHP' => '&#8369;',
            'EUR' => '&#8364;',
            'AUD' => '&#36;',
            'ILS' => '&#8362;',
            'GBP' => '&#163;'
            ];
         }
    public function getSymbols()
    {
        return [
            'PHP' => '₱',
        //    'AUD' => '$',
        //    'CAD' => '$',
            'CNY' => '¥',
            'EUR' => '€',
        //    'HKD' => '$',
            'IDR' => 'Rp',
            'INR' => '₹',
            'JPY' => '¥',
            'KRW' => '₩',
            'MYR' => 'RM',
        //    'NZD' => '$',
        //    'SGD' => '$',
            'THB' => '฿',
            'USD' => '$',
        ];
    }

    public function format($input)
    {
        // Round number and format to 2 decimal places
        return number_format(round($input, 2), 2);
    }

    public function round_format($input)
    {
        // Round number and format to 2 decimal places
        return round($input, 2);
    }

    public function formatReadable($currencyCode = 'USD', $toFormat = '0.00')
    {
        $currency_symbols = $this->getSymbols();
        return $currency_symbols[$currencyCode].' '.$toFormat;
    }
}
