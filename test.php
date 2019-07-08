<?php
require('autoload.php');
use Oauthconnect\GuoOauth;
$config = [
    'BAIDU' => [
        'BAIDU_ID' => '123',
        'BAIDU_API_KEY' => '123',
        'BAIDU_SECRET_KEY' => '123',
        'BAIDU_REDIRECT_URI' => '33333333',
    ]
];
$obj = new GuoOauth($config);
$test = $obj->config;
var_dump($test);
