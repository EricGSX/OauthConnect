<?php
require('autoload.php');
use Oauthconnect\GuoOauth;
$obj = new GuoOauth();
$msg = $obj->testConnect();
var_dump($msg);
var_dump($obj->config);
