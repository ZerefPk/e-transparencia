<?php

return [
    'cookie_key' => '__cookie_consent',
    'cookie_value_analytics' => '2',
    'cookie_value_marketing' => '3',
    'cookie_value_both' => 'true',
    'cookie_value_none' => 'false',
    'cookie_expiration_days' => '360',
    'gtm_event' => 'cookie_refresh',
    'ignored_paths' => [

    ],
    'policy_url_pt-br' => env('COOKIE_POLICY_URL_PT_BR', config('application.police.cookies')),
    'policy_url_en' => env('COOKIE_POLICY_URL_EN', null),
    'policy_url_fr' => env('COOKIE_POLICY_URL_FR', null),
    'policy_url_nl' => env('COOKIE_POLICY_URL_NL', null),
];
