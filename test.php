<?php
require('autoload.php');
use Oauthconnect\GuoOauth;
$obj = new GuoOauth();
$msg = $obj->test();
var_dump($msg);
