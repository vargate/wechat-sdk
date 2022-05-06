<?php

namespace Vargate\WechatSDK\Common\Providers;

use GuzzleHttp\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class HttpClientServiceProvider implements ServiceProviderInterface
{
    /**
     * 注册到容器
     *
     * @param \Pimple\Container
     */
    public function register(Container $container)
    {
        $container->httpClient = $container->httpClient ?? function ($app) {
            return new Client;
        };
    }
}
