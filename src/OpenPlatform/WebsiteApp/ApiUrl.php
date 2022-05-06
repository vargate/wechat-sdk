<?php

namespace Vargate\WechatSDK\OpenPlatform\WebsiteApp;

class ApiUrl
{
    /**
     * 授权
     *
     * @see https://developers.weixin.qq.com/doc/oplatform/Website_App/WeChat_Login/Wechat_Login.html
     */
    public const OAUTH = 'https://open.weixin.qq.com/connect/qrconnect';

    /**
     * 登录
     *
     * @see https://developers.weixin.qq.com/doc/oplatform/Website_App/WeChat_Login/Wechat_Login.html
     */
    public const FETCH_ACCESS_TOKEN = 'https://api.weixin.qq.com/sns/oauth2/access_token';

    /**
     * 获取用户信息
     *
     * @see https://developers.weixin.qq.com/doc/oplatform/Website_App/WeChat_Login/Authorized_Interface_Calling_UnionID.html
     */
    public const FETCH_USER_INFO = 'https://api.weixin.qq.com/sns/userinfo';
}
