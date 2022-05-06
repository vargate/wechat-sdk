<?php

namespace Vargate\WechatSDK\OpenPlatform\WebsiteApp\OAuth;

use Vargate\WechatSDK\Common\Exceptions\HttpException;
use Vargate\WechatSDK\OpenPlatform\WebsiteApp\ApiUrl;
use Vargate\WechatSDK\OpenPlatform\WebsiteApp\Application;

class OAuth
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
     * 授权
     *
     * @param  string $redirectUri
     * @param  string $state
     * @param  string $style
     * @param  string $apiUrl
     * @return string
     */
    public function genOAuthUrl(string $redirectUri, string $state = '', string $style = '', string $apiUrl = '')
    {
        $params = [
            'appid' => $this->app->appId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'snsapi_login',
            'state' => $state,
            'style' => $style,
        ];

        return ($apiUrl ?: ApiUrl::OAUTH)
                . '?'
                . http_build_query(array_filter($params))
                . '#wechat_redirect';
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
    public function fetchAccessToken(string $code, string $apiUrl = '')
    {
        try {
            return $this->app->httpClient->get(($apiUrl ?: ApiUrl::FETCH_ACCESS_TOKEN), [
                'query' => [
                    'grant_type' => 'authorization_code',
                    'appid' => $this->app->appId,
                    'secret' => $this->app->secret,
                    'code' => $code,
                ]
            ]);
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage());
        }
    }
}
