# OauthConnect
QQ、微信、微博、Github、Gitee、百度等第三方登陆

### 使用
#### 安装composer包
1. composer require gsx/oauthconnect dev-master （推荐）
2. 下载源码 https://github.com/EricGSX/OauthConnect.git
#### 定义自动加载
1. composer下载不需要单独配置
2. 源码下载需要修改项目composer.json文件
~~~
        "files": [
            "vendor/OauthConnect/autoload.php"
        ]
~~~
#### 授权页面调用
~~~
use Oauthconnect\GuoOauth;
$obj = new GuoOauth($config);   # config配置可参照配置文件，不建议直接修改扩展，可动态配置
$obj->setPlatForm('github');
obj->authCode();
~~~
#### 回调页面调用
~~~
use Oauthconnect\GuoOauth;
$obj = new GuoOauth($config);  # 也可以使用$obj->setConfig($config);
$userinfo = $obj->userinfo();
~~~


