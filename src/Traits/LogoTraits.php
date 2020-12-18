<?php

namespace Rabcreatives\Oppwa\Traits;

trait LogoTraits
{
    public function getCardImages()
    {
        return [
            'VISA' => 'https://src.tlpe.io/static/img/logo-po/logo-po-visa-white.png',
            'MASTER' => 'https://src.tlpe.io/static/img/logo-po/logo-po-master-white.png',
            'AMEX' => 'https://src.tlpe.io/static/img/logo-po/logo-po-amex-white.png',
            'DINERS' => 'https://src.tlpe.io/static/img/logo-po/logo-po-diners-white.png',
            'DISCOVER' => 'https://src.tlpe.io/static/img/logo-po/logo-po-discover-white.png',
        ];
    }

    public function getCardImage($card = 'VISA')
    {
        $card_img = $this->getCardImages();
        return $card_img[$card];
    }
}





