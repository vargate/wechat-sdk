<?php

namespace Vargate\WechatSDK\OpenPlatform\WebsiteApp;

use Pimple\Container;

class Application extends Container
{
    /**
     * __construct
     *
     * @param string $appId  网站应用AppID
     * @param string $secret 网站应用Secret
     */
    public function __construct(string $appId, string $secret)
    {
        $this->bindProperties($appId, $secret);

        $this->registerServiceProviders();
    }

    /**
     * 绑定属性
     *
     * @param  string $appId  公众号AppID
     * @param  string $secret 公众号Secret
     * @return void
     */
    protected function bindProperties(string $appId, string $secret)
    {
        $this->offsetSet('appId', $appId);
        $this->offsetSet('secret', $secret);
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
            \Vargate\WechatSDK\OpenPlatform\WebsiteApp\OAuth\ServiceProvider::class,
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
