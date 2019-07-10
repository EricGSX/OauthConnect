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
$obj = new GuoOauth();
$obj->setPlatForm('baidu');
$obj->setConfig($config);
$userindex = $obj->userinfo();
var_dump($userindex);
