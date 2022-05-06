<?php

namespace Vargate\WechatSDK\OfficialAccount\Server\Cipher;

class Pkcs7
{
    /**
     * 位填充
     *
     * @param  string $text
     * @param  int    $blockSize
     * @return string
     */
    public static function encode(string $text, int $blockSize)
    {
        $pad = $blockSize - (strlen($text) % $blockSize);

        $padChr = chr($pad);

        return $text . str_repeat($padChr, $pad);
    }

    /**
     * 位删除
     *
     * @param  string $text
     * @param  int    $blockSize
     * @return string
     */
    public static function decode(string $text, int $blockSize)
    {
        $pad = ord(substr($text, -1));

        if ($pad < 1 || $pad > $blockSize) {
            $pad = 0;
        }

        return substr($text, 0, (strlen($text) - $pad));
    }
}
