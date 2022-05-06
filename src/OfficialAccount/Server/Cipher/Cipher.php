<?php

namespace Vargate\WechatSDK\OfficialAccount\Server\Cipher;

use Vargate\WechatSDK\OfficialAccount\Exceptions\CipherException;
use Vargate\WechatSDK\Common\Support\Arr;
use Vargate\WechatSDK\Common\Support\Str;

class Cipher
{
    /**
     * 公众号AppID
     *
     * @var string
     */
    protected $appId;

    /**
     * 公众平台配置的token
     *
     * @var string
     */
    protected $token;

    /**
     * 公众平台配置的AES密钥
     *
     * @var string
     */
    protected $aesKey;

    /**
     * 编码器
     *
     * @var Encoder
     */
    protected $encoder;

    /**
     * __construct
     *
     * @param string  $appId   公众号AppID
     * @param string  $token   公众号配置的token
     * @param string  $aesKey  公众号配置的AES密钥
     * @param Encoder $encoder 编码器
     */
    public function __construct(string $appId, string $token, string $aesKey, Encoder $encoder)
    {
        $this->appId = $appId;

        $this->token = $token;

        $this->aesKey = base64_decode($aesKey . '=', true) ?: '';

        $this->encoder = $encoder;
    }

    /**
     * 加密
     *
     * @param  string $plaintext 明文
     * @return string            密文
     */
    public function encipher(string $plaintext)
    {
        $plaintext = Pkcs7::encode(random_bytes(16) . pack('N', strlen($plaintext)) . $plaintext . $this->appId, 32);

        $ciphertext = base64_encode(
            openssl_encrypt(
                $plaintext,
                'AES-256-CBC',
                $this->aesKey,
                OPENSSL_NO_PADDING,
                substr($this->aesKey, 0, 16)
            )
        );

        $timestamp = time();

        $nonce = Str::random();

        $signature = $this->signature($this->token, $timestamp, $nonce, $ciphertext);

        $ciphertext = $this->encoder->encode([
            'Encrypt' => $ciphertext,
            'MsgSignature' => $signature,
            'TimeStamp' => $timestamp,
            'Nonce' => $nonce,
        ]);

        return $ciphertext;
    }

    /**
     * 解密
     *
     * @param  string $ciphertext 密文
     * @param  string $signature  微信query参数.签名
     * @param  string $timestamp  微信query参数.时间戳
     * @param  string $nonce      微信query参数.随机字串
     * @return string             明文
     *
     * @throws \Vargate\WechatSDK\OfficialAccount\Exceptions\CipherException
     */
    public function decipher(string $ciphertext, string $signature, string $timestamp, string $nonce)
    {
        $ciphertext = Arr::get($this->encoder->decode($ciphertext), 'Encrypt', '');

        if ($signature !== $this->signature($this->token, $timestamp, $nonce, $ciphertext)) {
            throw new CipherException('Invalid signature');
        }

        $ciphertext = base64_decode($ciphertext, true) ?: '';

        $plaintext = Pkcs7::decode(
            openssl_decrypt(
                $ciphertext,
                'AES-256-CBC',
                $this->aesKey,
                OPENSSL_NO_PADDING,
                substr($this->aesKey, 0, 16)
            ) ?: '', 32
        );

        $plaintext = substr($plaintext, 16);

        $length = (unpack('N', substr($plaintext, 0, 4)) ?: [])[1];

        if (substr($plaintext, $length + 4) != $this->appId) {
            throw new CipherException('Invalid App ID');
        }

        $plaintext = substr($plaintext, 4, $length);

        return $plaintext;
    }

    /**
     * 生成签名
     *
     * @param  mixed $attributes
     * @return string
     */
    protected function signature(...$attributes)
    {
        sort($attributes, SORT_STRING);

        return sha1(implode($attributes));
    }
}
