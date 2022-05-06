<?php

namespace Vargate\WechatSDK\OfficialAccount\OAuth;

use Vargate\WechatSDK\Common\Exceptions\HttpException;
use Vargate\WechatSDK\OfficialAccount\ApiUrl;
use Vargate\WechatSDK\OfficialAccount\Application;

class OAuth
{
    /**
     * App容器
     *
     * @var \Vargate\WechatSDK\OfficialAccount\Application
     */
    protected $app;

    /**
     * __construct
     *
     * @param \Vargate\WechatSDK\OfficialAccount\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * 登录
     *
     * @param  string $apiUrl
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Vargate\WechatSDK\Common\Exceptions\HttpException
     */
    public function fetchAccessToken(string $apiUrl = '')
    {
        try {
            return $this->app->httpClient->get(($apiUrl ?: ApiUrl::FETCH_ACCESS_TOKEN), [
                'query' => [
                    'grant_type' => 'client_credential',
                    'appid' => $this->app->appId,
                    'secret' => $this->app->secret,
                ]
            ]);
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage());
        }
    }
}
