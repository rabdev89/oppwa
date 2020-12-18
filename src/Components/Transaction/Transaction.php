<?php

namespace Rabcreatives\Oppwa\Components\Transaction;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transactionid',
        'transaction_type',
        'credentialid',
        'datetime_request',
        'request',
        'datetime_response',
        'response_id',
        'response_status',
        'response',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];


}
