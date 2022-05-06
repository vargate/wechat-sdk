<?php

namespace Vargate\WechatSDK\OfficialAccount\OAuth;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * 注册到容器
     *
     * @param \Pimple\Container
     */
    public function register(Container $container)
    {
        $container->oauth = $container->oauth ?? function ($app) {
            return new OAuth($app);
        };
    }
}
