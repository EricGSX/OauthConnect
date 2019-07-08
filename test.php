<?php
require('autoload.php');
use Oauthconnect\GuoOauth;
$config = [
    'GITHUB'=> [
        'GITHUB_ID' => '',
        'GITHUB_CLIENTID' => '',
        'GITHUB_SECRET_KEY' => '',
        'GITHUB_REDIRECT_URI' => '',
    ],
];
$obj = new GuoOauth($config);
$obj->setPlatForm('github');
$userindex = $obj->authCode('baidu');
