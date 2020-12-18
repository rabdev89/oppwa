<?php

namespace Rabcreatives\Oppwa\Components\Credential;
use Illuminate\Database\Eloquent\Model;
use Rabcreatives\Oppwa\Components\Configuration\Configuration;

class Credential extends Model
{

    protected $table = 'credential';

    /**
     * The attributes that are mass assignable.
     * zoho_account = (zoho: organization_id)
     * @var array
     */
    protected $fillable = [
        'credentialid',
        'configurationid',
        'server',
        'set',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function configuration() {
        return $this->belongsTo(Configuration::class, 'configurationid', 'configurationid');
    }
}

