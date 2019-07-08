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
    public $platform;

    public function __construct ($setConfig=[])
    {
        if(empty($setConfig) || $setConfig==null){
            $this->config = require_once('Config.php');
        }else{
            $this->config = $setConfig;
        }
    }

    //public function testConnect()
    //{
    //    return 'hello world!';
    //}

    public function setPlatForm($platform='')
    {
        $this->platform = $platform;
    }

    public function authCode()
    {
        $platform = $this->platform;
        switch ($platform){
            case 'baidu':
                $this->baidu();
                break;
        }
    }

    public function userinfo()
    {
        $platform = $this->platform;
        switch ($platform){
            case 'baidu':
                $userinfo = $this->baiduUserinfo();
                break;
        }
        return $userinfo;
    }

    public function setConfig($setConfig=[])
    {
        $this->config = $setConfig;
    }

    public function baidu()
    {
        $clientId = $this->config['BAIDU']['BAIDU_API_KEY'];
        $redirectUri = $this->config['BAIDU']['BAIDU_REDIRECT_URI'];
        header("location:https://openapi.baidu.com/oauth/2.0/authorize?response_type=code&client_id=$clientId&redirect_uri=$redirectUri&display=popup");
    }

    public function getCode()
    {
        return $_GET['code'];
    }

    public function baiduAccessToken()
    {
        try{
            $code = $this->getCode();
            $redirect_uri  = $this->config['BAIDU']['BAIDU_REDIRECT_URI'];
            $client_secret = $this->config['BAIDU']['BAIDU_SECRET_KEY'];
            $client_id     = $this->config['BAIDU']['BAIDU_API_KEY'];
            $url           = "https://openapi.baidu.com/oauth/2.0/token?grant_type=authorization_code&code=$code&client_id=$client_id&client_secret=$client_secret&redirect_uri=$redirect_uri";
            $res           = $this->https_request($url);
            $data          = json_decode($res, true);
            return $data['access_token'];
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function baiduUserinfo()
    {
        try{
            $accessToken = $this->baiduAccessToken();
            $url  = 'https://openapi.baidu.com/rest/2.0/passport/users/getLoggedInUser?access_token='.$accessToken;
            $res  = $this->https_request($url);
            $userinfo = json_decode($res, true);
            return $userinfo;
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }


    public static function https_request($url, $data = null,$ua=null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        if($ua){
            $useragent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11";
            curl_setopt($curl, CURLOPT_USERAGENT, $useragent);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

}