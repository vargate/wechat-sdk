<?php

namespace Vargate\WechatSDK\OfficialAccount\Server;

use GuzzleHttp\Psr7\ServerRequest as HttpRequest;
use GuzzleHttp\Psr7\Response as HttpResponse;
use Vargate\WechatSDK\Common\Support\Arr;
use Vargate\WechatSDK\OfficialAccount\Application;
use Vargate\WechatSDK\OfficialAccount\Exceptions\ServerException;

class Server
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
     * 启动服务
     *
     * @return \GuzzleHttp\Psr7\Response
     */
    public function launch()
    {
        $request = HttpRequest::fromGlobals();

        if ($echostr = $request->getQueryParams()['echostr'] ?? '') {
            return new HttpResponse(200, [], $echostr);
        }

        $message = $this->decrypt($request);

        $event = $this->app->eventDispatcher->dispatch(
            new Event($this->app, $message, new Reply),
            $this->eventName($message->MsgType, $message->Event)
        );

        return $this->response($message, $event->getReply());
    }

    /**
     * 注册消息监听
     *
     * @param  string      $eventName
     * @param  callable    $listener
     * @param  int|integer $priority
     * @return void
     */
    public function addMessageListener(string $eventName, callable $listener, int $priority = 0)
    {
        $this->app->eventDispatcher->addListener($this->eventName($eventName), $listener, $priority);
    }

    /**
     * 注册事件监听
     *
     * @param  string      $eventName
     * @param  callable    $listener
     * @param  int|integer $priority
     * @return void
     */
    public function addEventListener(string $eventName, callable $listener, int $priority = 0)
    {
        $this->app->eventDispatcher->addListener($this->eventName('event', $eventName), $listener, $priority);
    }

    /**
     * 事件名称
     *
     * @param  string      $msgType
     * @param  string|null $event
     * @return string
     */
    protected function eventName(string $msgType, string $event = null)
    {
        return 'event' === $msgType
                ? 'event.' . strtolower($event)
                : 'message.' . strtolower($msgType);
    }

    /**
     * 解密
     *
     * @param  \GuzzleHttp\Psr7\ServerRequest $request
     * @return \Vargate\WechatSDK\OfficialAccount\Server\Message
     */
    protected function decrypt(HttpRequest $request)
    {
        $query = $request->getQueryParams();

        return (new Message)->merge(
            $this->app->cipherEncoder->decode(
                $this->app->cipher->decipher(
                    $request->getBody()->getContents(),
                    Arr::get($query, 'msg_signature', ''),
                    Arr::get($query, 'timestamp', ''),
                    Arr::get($query, 'nonce', '')
                )
            )
        );
    }

    /**
     * 响应
     *
     * @param  \Vargate\WechatSDK\OfficialAccount\Server\Message $message
     * @param  \Vargate\WechatSDK\OfficialAccount\Server\Reply   $reply
     * @return \GuzzleHttp\Psr7\Response
     *
     * @throws \Vargate\WechatSDK\OfficialAccount\Exceptions\ServerException
     */
    protected function response(Message $message, Reply $reply)
    {
        if (empty($reply->all())) {
            return new HttpResponse(200, [], 'success');
        }

        if (! Arr::get($reply, 'MsgType')) {
            throw new ServerException('MsgType should be set to Reply');
        }

        $plaintext = $this->app->cipherEncoder->encode(
            array_filter(
                $reply->merge([
                    'ToUserName' => $message->FromUserName,
                    'FromUserName' => $message->ToUserName,
                    'CreateTime' => time(),
                ])->all()
            )
        );

        return new HttpResponse(
            200,
            ['Content-Type' => 'application/xml'],
            $this->app->cipher->encipher($plaintext)
        );
    }
}
