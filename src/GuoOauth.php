<?php
/**
 * File: GuoOauth.php.
 * User: Eric.Guo
 * Date: 2019.07.08
 * Time: 15:14
 */
namespace Oauthconnect;
class GuoOauth
{
    public $config = [];

    public function __construct ()
    {
        $this->config = require_once('Config.php');
    }

    public function testConnect()
    {
        return 'hello world!';
    }


}