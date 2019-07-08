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
    /**
     * Platform List:
     *   baidu
     *   github
     *   gitee
     *   qq
     *   weibo
     * 请严格按照以上平台名称进行初始化。
     */
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
            case 'github':
                $this->github();
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
            case 'github':
                $userinfo = $this->githubUserinfo();
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

    public function github()
    {
        $clientId =$this->config['GITHUB']['GITHUB_CLIENTID'];
        header("location:https://github.com/login/oauth/authorize?client_id=$clientId");
    }

    public function githubAccessToken()
    {
        try{
            $code = $this->getCode();
            $data = [
                'client_id'=>$this->config['GITHUB']['GITHUB_CLIENTID'],
                'client_secret'=>$this->config['GITHUB']['GITHUB_SECRET_KEY'],
                'code'=>$code,
                'redirect_uri'=>$this->config['GITHUB']['GITHUB_REDIRECT_URI'],
                'grant_type'=>'authorization_code',
            ];
            $url = "https://github.com/login/oauth/access_token";
            $res = $this->https_request($url,$data);
            return $res;
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function githubUserinfo()
    {
        try{
            $accessToken = $this->githubAccessToken();
            $url  = 'https://api.github.com/user?'.$accessToken;
            $res  = $this->https_request($url,null,true);
            $result = json_decode($res, true);
            return $result;
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

}