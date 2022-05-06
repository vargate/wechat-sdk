<?php

namespace Vargate\WechatSDK\Common\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EventDispatcherServiceProvider implements ServiceProviderInterface
{
    /**
     * 注册到容器
     *
     * @param \Pimple\Container
     */
    public function register(Container $container)
    {
        $container->eventDispatcher = $container->eventDispatcher ?? function ($app) {
            return new EventDispatcher;
        };
    }
}
