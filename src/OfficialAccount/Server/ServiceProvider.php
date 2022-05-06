<?php

namespace Vargate\WechatSDK\OfficialAccount\Server;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Vargate\WechatSDK\OfficialAccount\Server\Cipher\Encoder;
use Vargate\WechatSDK\OfficialAccount\Server\Cipher\Cipher;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * 注册到容器
     *
     * @param \Pimple\Container
     */
    public function register(Container $container)
    {
        $container->cipherEncoder = $container->cipherEncoder ?? function ($app) {
            return new Encoder;
        };

        $container->cipher = $container->cipher ?? function ($app) {
            return new Cipher(
                $app->appId,
                $app->token,
                $app->aesKey,
                $app->cipherEncoder
            );
        };

        $container->msgServer = $container->msgServer ?? function ($app) {
            return new Server($app);
        };
    }
}
