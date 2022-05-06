<?php

namespace Vargate\WechatSDK\OfficialAccount\TemplateMessage;

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
        $container->templateMessage = $container->templateMessage ?? function ($app) {
            return new TemplateMessage($app);
        };
    }
}
