<?php

namespace Vargate\WechatSDK\OfficialAccount;

class ApiUrl
{
    /**
     * 登录
     *
     * https://developers.weixin.qq.com/doc/offiaccount/Basic_Information/Get_access_token.html
     */
    public const FETCH_ACCESS_TOKEN = 'https://api.weixin.qq.com/cgi-bin/token';

    /**
     * 获取用户信息
     *
     * https://developers.weixin.qq.com/doc/offiaccount/User_Management/Get_users_basic_information_UnionID.html#UinonId
     */
    public const FETCH_USER_INFO = 'https://api.weixin.qq.com/cgi-bin/user/info';

    /**
     * 发送模板消息
     *
     * https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Template_Message_Interface.html#5
     */
    public const SEND_TEMPLATE_MESSAGE = 'https://api.weixin.qq.com/cgi-bin/message/template/send';
}
