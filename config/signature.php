<?php

return [

    // default signer
    'default' => env('SIGNATURE_DRIVER', 'hmac'),
    'hmac' => [
        'driver' => 'HMAC',
        'options' => [
            // default algo
            'algo' => env('SIGNATURE_HMAC_ALGO', 'sha1'),
            // default hmac key
            'key' => env('SIGNATURE_HMAC_KEY','default!_@123'),
        ],
    ],
    'rsa' => [
        'driver' => 'RSA',
        'options' => [
            //default algo
            'algo' => env('SIGNATURE_RSA_ALGO', 'sha1'),
            // default primary key (if file should be absolute address)
            'publicKey' => env('SIGNATURE_RSA_PUBLIC_KEY'),
            // default primary key (if file should be absolute address)
            'privateKey' => env('SIGNATURE_RSA_PRIVATE_KEY'),
        ],
    ],


    'app_id'=>[
        'mijia_iphone' => 'majiaheziiphone@iphone',
        'mijia_pc' => 'majiahezipc@pc',
        'mijia_ipad' => 'majiaheziipad@ipad',
        'default' => env('SIGNATURE_HMAC_KEY','default!_@123'),
    ],

    'timeout' => env('SIGNATURE_TIMEOUT',60),//签名过期时间（秒）
];
