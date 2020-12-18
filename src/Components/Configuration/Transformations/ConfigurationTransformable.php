<?php

namespace Rabcreatives\Oppwa\Components\Configuration\Transformations;

use Rabcreatives\Oppwa\Components\Configuration\Configuration;
use Illuminate\Support\Facades\Storage;

trait ConfigurationTransformable
{
    /**
     * Transform the configuration
     *
     * @param Configuration $configuration
     * @return Configuration
     */
    protected function transformSimple(Configuration $configuration)
    {
        $config = new Configuration;
        $config->id = (int) $configuration->configurationid;
        $config->zoho_account = $configuration->zoho_account;
        $config->zoho_apn_account = $configuration->zoho_apn_account;
        $config->merchant_name = $configuration->merchant_name;
        $config->merchant_logo = $configuration->merchant_logo;

        return $config;
    }
}
