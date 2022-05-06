# Wechat SDK

这是一个微信开发包，涉及到微信开放平台、微信公众号、微信小程序等。

## 安装

```sh
composer require vargate/wechat-sdk
```

## 使用

首先创建容器实例`new Application`，创建后容器内会自动注册相关服务，通过`$app->keys()`查看已注册的服务。

1. 微信开放平台.网站应用

```php
use Vargate\WechatSDK\OpenPlatform\WebsiteApp\Application;

/**
 * 引导用户到微信，请求OAuth授权登录
 */
public function redirect()
{
    $app = new Application($appId, $secret);

    $oAuthUrl = $app->oauth->genOAuthUrl($callbackUrl);

    return redirect()->to($oAuthUrl);
}

/**
 * 用户授权后微信重定向，并携带临时票据code
 */
public function callback($code)
{
    $app = new Application($appId, $secret);

    $response = $app->oauth->fetchAccessToken($code);

    $contents = json_decode($response->getBody()->getContents(), true);

    // ...
}
```

2. 微信小程序

```php
use Vargate\WechatSDK\MiniProgram\Application;

/**
 * 登录
 */
public function login(Request $request)
{
    $app = new Application($appId, $secret);

    $session = $app->oauth->fetchSession($request->code);

    // ...
}
```

3. 微信公众号

```php
use Vargate\WechatSDK\OfficialAccount\Application;

/**
 * 接收消息和回复
 */
public function serve()
{
    $app = new Application($appId, $secret, $token, $aeskey);

    $app->msgServer->addMessageListener('text', $callable1);

    $app->msgServer->addEventListener('subscribe', $callable2);

    $response = $app->msgServer->launch();

    return $response;
}

/**
 * 发送模版消息
 */
public function sendTemplateMessage()
{
    $app = new Application($appId, $secret, $token, $aeskey);

    $accessToken = $app->oauth->fetchAccessToken();

    $app->templateMessage->send(
        $accessToken,
        $toUser,
        $templateId,
        $data
    );
}
```
