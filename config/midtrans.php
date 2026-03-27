<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-TOq1a2AVuiyhhOjvfs3U_KeO'),
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-nKsqvar5cn60u2Lv'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),
];
