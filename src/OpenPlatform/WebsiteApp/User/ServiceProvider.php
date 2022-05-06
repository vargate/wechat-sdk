<?php

namespace Vargate\WechatSDK\OpenPlatform\WebsiteApp\User;

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
        $container->user = $container->user ?? function ($app) {
            return new User($app);
        };
    }
}
