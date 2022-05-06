<?php

namespace Vargate\WechatSDK\OfficialAccount\TemplateMessage;

use Vargate\WechatSDK\Common\Exceptions\HttpException;
use Vargate\WechatSDK\OfficialAccount\ApiUrl;
use Vargate\WechatSDK\OfficialAccount\Application;

class TemplateMessage
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
     * 发送模版消息
     *
     * @param  string $accessToken
     * @param  string $toUser              用户OpenID
     * @param  string $templateId          模版ID
     * @param  array  $data                模板数据
     * @param  string $url                 模板跳转链接
     * @param  string $miniProgramAppId    小程序AppID
     * @param  string $miniProgramPagePath 小程序页面路径，支持带参数
     * @param  string $apiUrl
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Vargate\WechatSDK\Common\Exceptions\HttpException
     */
    public function send(
        string $accessToken,
        string $toUser,
        string $templateId,
        array $data,
        string $url = '',
        string $miniProgramAppId = '',
        string $miniProgramPagePath = '',
        string $apiUrl = ''
    )
    {
        try {
            return $this->app->httpClient->post(($apiUrl ?: ApiUrl::SEND_TEMPLATE_MESSAGE), [
                'query' => [
                    'access_token' => $accessToken,
                ],
                'body' => json_encode([
                    'touser' => $toUser,
                    'template_id' => $templateId,
                    'data' => $data,
                    'url' => $url,
                    'miniprogram' => [
                        'appid' => $miniProgramAppId,
                        'pagepath' => $miniProgramPagePath,
                    ]
                ])
            ]);
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage());
        }
    }
}
