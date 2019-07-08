<?php
require('autoload.php');
use Oauthconnect\GuoOauth;
$obj = new GuoOauth();
$msg = $obj->testConnect();
var_dump($msg);
