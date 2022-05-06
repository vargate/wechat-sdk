<?php

namespace Vargate\WechatSDK\OpenPlatform\WebsiteApp\User;

use Vargate\WechatSDK\Common\Exceptions\HttpException;
use Vargate\WechatSDK\OpenPlatform\WebsiteApp\ApiUrl;
use Vargate\WechatSDK\OpenPlatform\WebsiteApp\Application;

class User
{
    /**
     * App容器
     *
     * @var \Vargate\WechatSDK\OpenPlatform\WebsiteApp\Application
     */
    protected $app;

    /**
     * __construct
     *
     * @param \Vargate\WechatSDK\OpenPlatform\WebsiteApp\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * 用户管理.获取用户基本信息（UnionId）
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
