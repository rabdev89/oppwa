<?php

namespace Rabcreatives\Oppwa\Components\Integration;
use Illuminate\Database\Eloquent\Model;
use Rabcreatives\Oppwa\Components\Configuration\Configuration;

class Integration extends Model
{

    protected $table = 'integration';

    /**
     * The attributes that are mass assignable.
     * zoho_account = (zoho: organization_id)
     * @var array
     */
    protected $fillable = [
        'integrationid',
        'zoho_account',
        'zoho_apn_account',
        'zoho_apn_credential',
        'merchant_name',
        'merchant_logo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function configuration() {
        return $this->hasMany(Configuration::class, 'integrationid', 'integrationid');
    }
}

