<?php

namespace Vargate\WechatSDK\MiniProgram\OAuth;

use Vargate\WechatSDK\Common\Exceptions\HttpException;
use Vargate\WechatSDK\MiniProgram\Application;

class OAuth
{
    /**
     * App容器
     *
     * @var \Vargate\WechatSDK\MiniProgram\Application
     */
    protected $app;

    /**
     * __construct
     *
     * @param \Vargate\WechatSDK\MiniProgram\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * 登录
     *
     * @param  string $code
     * @param  string $apiUrl
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Vargate\WechatSDK\Common\Exceptions\HttpException
     */
    public function fetchSession(string $code, string $apiUrl = '')
    {
        try {
            return $this->app->httpClient->get(($apiUrl ?: ApiUrl::CODE_TO_SESSION), [
                'query' => [
                    'grant_type' => 'authorization_code',
                    'appid' => $this->app->appId,
                    'secret' => $this->app->secret,
                    'js_code' => $code,

                ]
            ]);
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage());
        }
    }
}
