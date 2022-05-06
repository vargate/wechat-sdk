<?php

namespace Vargate\WechatSDK\OfficialAccount\Server\Cipher;

use Symfony\Component\Serializer\Encoder\XmlEncoder;

class Encoder
{
    /**
     * 编码器
     *
     * @var \Symfony\Component\Serializer\Encoder\XmlEncoder
     */
    protected $encoder;

    /**
     * 运行时参数
     *
     * @var array
     */
    protected $defaultContext = [
        XmlEncoder::ROOT_NODE_NAME => 'xml',
        XmlEncoder::ENCODING => 'utf-8',
    ];

    /**
     * __construct
     */
    public function __construct()
    {
        $this->encoder = new XmlEncoder();
    }

    /**
     * 编码
     *
     * @param  array  $data
     * @param  array  $context
     * @return string
     */
    public function encode(array $data, array $context = [])
    {
        $context = array_merge($this->defaultContext, $context);

        return $this->encoder->encode($data, 'xml', $context);
    }

    /**
     * 解码
     *
     * @param  string $data
     * @param  array  $context
     * @return array
     */
    public function decode(string $data, array $context = [])
    {
        $context = array_merge($this->defaultContext, $context);

        return $this->encoder->decode($data, 'xml', $context);
    }
}
