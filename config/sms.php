<?php

/**
 * Config file for SMS Class functionality
 */


return [
    'sms_value_nac' => env('SMS_VALUE_NAC', 0.04),
    'sms_value_int' => env('SMS_VALUE_INT', 0.02),

    'sms_nacional_route' => env('SMS_NACIONAL', ''),
    'sms_internacional_route' => env('SMS_INTERNACIONAL', ''),

    'sms_nacional_token' => env('SMS_NACIONAL_TOKEN', ''),
    'sms_internacional_token' => env('SMS_INTERNACIONAL_TOKEN', ''),

    'international_from_number' => env('INTERNATIONAL_FROM_NUMBER', '')
];
