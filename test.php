<?php
require('autoload.php');
use Oauthconnect\GuoOauth;
$config = [
    'BAIDU' => [
        'BAIDU_ID' => '',
        'BAIDU_API_KEY' => '',
        'BAIDU_SECRET_KEY' => '',
        'BAIDU_REDIRECT_URI' => '',
    ],
];
$obj = new GuoOauth($config);
$obj->setPlatForm('baidu');
$userindex = $obj->authCode();
