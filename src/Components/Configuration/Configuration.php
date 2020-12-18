<?php

namespace Rabcreatives\Oppwa\Components\Configuration;
use Illuminate\Database\Eloquent\Model;
use Rabcreatives\Oppwa\Components\Integration\Integration;
use Rabcreatives\Oppwa\Components\Credential\Credential;

class Configuration extends Model
{
    protected $table = 'configuration';

    /**
     * The attributes that are mass assignable.
     * payment_type = (creditcard,debitcard,ach,online bank transfer)
     * payment_mode = (oppwa) (custom functions)
     * payment_brand = (visa,master,diners,discover)
     * @var array
     */
    protected $fillable = [
        'configurationid',
        'integrationid',
        'currency',
        'payment_type',
        'payment_mode',
        'payment_brand',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];


    public function integration() {
       return $this->belongsTo(Integration::class, 'integrationid', 'integrationid');
    }

    public function credential() {
       return $this->belongsTo(Credential::class, 'configurationid', 'configurationid');
    }

}
