<?php

namespace Vargate\WechatSDK\OfficialAccount\Server;

use Vargate\WechatSDK\OfficialAccount\Application;

final class Event
{
    /**
     * App容器
     *
     * @var \Vargate\WechatSDK\OfficialAccount\Application
     */
    protected $app;

    /**
     * 消息
     *
     * @var \Vargate\WechatSDK\OfficialAccount\Server\Message
     */
    protected $message;

    /**
     * 回复
     *
     * @var \Vargate\WechatSDK\OfficialAccount\Server\Reply
     */
    protected $reply;

    /**
     * __construct
     *
     * @param \Vargate\WechatSDK\OfficialAccount\Application    $app
     * @param \Vargate\WechatSDK\OfficialAccount\Server\Message $message
     * @param \Vargate\WechatSDK\OfficialAccount\Server\Reply   $reply
     */
    public function __construct(Application $app, Message $message, Reply $reply)
    {
        $this->app = $app;

        $this->message = $message;

        $this->reply = $reply;
    }

    /**
     * 获取App容器
     *
     * @return \Vargate\WechatSDK\OfficialAccount\Application
     */
    public function getApplication()
    {
        return $this->app;
    }

    /**
     * 获取消息
     *
     * @return \Vargate\WechatSDK\OfficialAccount\Server\Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * 获取回复
     *
     * @return \Vargate\WechatSDK\OfficialAccount\Server\Reply
     */
    public function getReply()
    {
        return $this->reply;
    }
}
