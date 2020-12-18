<?php

namespace Rabcreatives\Oppwa\Components\Integration\Transformations;

use Rabcreatives\Oppwa\Components\Integration\Integration;
use Rabcreatives\Oppwa\Traits\LogoTraits;
use Illuminate\Support\Facades\Storage;

trait IntegrationTransformable
{
    use LogoTraits;
    /**
     * Transform the integration
     *
     * @param Integration $integration
     * @return Integration
     */
    protected function transformSimple(Integration $integration)
    {
        $integ = new Integration;
        $integ->id = (int) $integration->integrationid;
        $integ->zoho_account = $integration->zoho_account;
        $integ->zoho_apn_account = $integration->zoho_apn_account;
        $integ->merchant_name = $integration->merchant_name;
        $integ->merchant_logo = $integration->merchant_logo;

        $configuration = [];
        foreach ($integration->configuration->toArray() as $key => $config) {
            $configuration[$key] = $config;
            $configuration[$key]['logo'] = $this->getCardImage($config['payment_brand']);
        }
        $integ->configuration = $configuration;

        return $integ;
    }
}
