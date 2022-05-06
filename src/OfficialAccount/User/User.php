<?php

namespace Vargate\WechatSDK\OfficialAccount\User;

use Vargate\WechatSDK\Common\Exceptions\HttpException;
use Vargate\WechatSDK\OfficialAccount\ApiUrl;
use Vargate\WechatSDK\OfficialAccount\Application;

class User
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
     * 获取用户信息
     *
     * @param  string $accessToken
     * @param  string $openId
     * @param  string $lang
     * @param  string $apiUrl
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Vargate\WechatSDK\Common\Exceptions\HttpException
     */
    public function fetchUserInfo(string $accessToken, string $openId, string $lang = 'zh_CN', string $apiUrl = '')
    {
        try {
            return $this->app->httpClient->get(($apiUrl ?: ApiUrl::FETCH_USER_INFO), [
                'query' => [
                    'access_token' => $accessToken,
                    'openid' => $openId,
                    'lang' => $lang,
                ]
            ]);
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage());
        }
    }
}
