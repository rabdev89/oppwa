<?php

return [
    'mode' => 'test',

    'version' => 'v1',

    'oppwa_user_id' => env('OPPWA_USER_ID', 'gatewayparam123pw'),

    'oppwa_password' => env('OPPWA_PASSWORD', 'gatewayparam123pw'),

    'oppwa_url' => env('OPPWA_URL', 'https://test.oppwa.com/'),

    'oppwa_entity_id' => env('OPPWA_AUTH_ENTITYID', '8ac7a4c974d4b88b0174e71a5d533488'),

    'oppwa_token' => env('OPPWA_AUTH_TOKEN', 'Bearer OGFjN2E0Yzg3MWExOTRkYjAxNzFhNGY3N2JkZjExMjZ8M0NqNEtrOVlycQ=='),

    'webHook' => env('OPPWA_WEBHOOK_KEY', ''),

    /*
    * Payment Type options
    * PA = PREAUTH, RV = REVERSE, DB = DEBIT, CD = CREDIT, CP = PREAUTH, RF = PREAUTH
    *
    */
    'oppwa_payment_type' => 'DB',

    /*
    * Recurring options
    * INITIAL, REPEATED
    *
    */
    'oppwa_recurring_type' => 'INITIAL',

    /*
    * Payment options
    * 'VISA', 'MASTER', 'AMEX', 'DINERS'
    *
    */
    'oppwa_payment_options' => ['VISA', 'MASTER', 'AMEX', 'DINERS']

];
