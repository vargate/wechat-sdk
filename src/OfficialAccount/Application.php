<?php

namespace Vargate\WechatSDK\OfficialAccount;

use Pimple\Container;

class Application extends Container
{
    /**
     * __construct
     *
     * @param string $appId  公众号AppID
     * @param string $secret 公众号Secret
     * @param string $token  公众平台配置的token
     * @param string $aesKey 公众平台配置的AES密钥
     */
    public function __construct(string $appId, string $secret, string $token, string $aesKey)
    {
        $this->bindProperties($appId, $secret, $token, $aesKey);

        $this->registerServiceProviders();
    }

    /**
     * 绑定属性
     *
     * @param  string $appId  公众号AppID
     * @param  string $secret 公众号Secret
     * @param  string $token  公众平台配置的token
     * @param  string $aesKey 公众平台配置的AES密钥
     * @return void
     */
    protected function bindProperties(string $appId, string $secret, string $token, string $aesKey)
    {
        $this->offsetSet('appId', $appId);
        $this->offsetSet('secret', $secret);
        $this->offsetSet('token', $token);
        $this->offsetSet('aesKey', $aesKey);
    }

    /**
     * 注册服务
     *
     * @return void
     */
    protected function registerServiceProviders()
    {
        $providers = array_merge(
            $this->baseServiceProviders(),
            $this->appServiceProviders()
        );

        foreach ($providers as $provider) {
            parent::register(new $provider);
        }
    }

    /**
     * 注册基础服务
     *
     * @return array
     */
    protected function baseServiceProviders()
    {
        return [
            \Vargate\WechatSDK\Common\Providers\EventDispatcherServiceProvider::class,
            \Vargate\WechatSDK\Common\Providers\HttpClientServiceProvider::class,
        ];
    }

    /**
     * 注册App服务
     *
     * @return array
     */
    protected function appServiceProviders()
    {
        return [
            \Vargate\WechatSDK\OfficialAccount\OAuth\ServiceProvider::class,
            \Vargate\WechatSDK\OfficialAccount\Server\ServiceProvider::class,
            \Vargate\WechatSDK\OfficialAccount\TemplateMessage\ServiceProvider::class,
            \Vargate\WechatSDK\OfficialAccount\User\ServiceProvider::class,
        ];
    }

    /**
     * __set
     *
     * @param  string $name
     * @param  mixed  $value
     * @return void
     */
    public function __set(string $name, $value)
    {
        $this->offsetSet($name, $value);
    }

    /**
     * __get
     *
     * @param  string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->offsetExists($name)
                ? $this->offsetGet($name)
                : null;
    }
}
