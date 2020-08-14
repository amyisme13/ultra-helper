<?php

namespace Amyisme13\UltraHelper;

class Encryption
{
    public static function encrypt(string $plainText, $customEncKey = null, $customIV = null)
    {
        $encKey = $customEncKey ?: config('ultra-helper.encryption_key');

        $encIV = $customIV ?: config('ultra-helper.encryption_iv');

        $e = openssl_encrypt($plainText, "AES-256-CBC", hex2bin($encKey), 0, hex2bin($encIV));
        return bin2hex(base64_decode($e));
    }

    public static function decrypt(string $encryptedString, $customEncKey = null, $customIV = null)
    {
        $encKey = $customEncKey ?: config('ultra-helper.encryption_key');
        $encIV = $customIV ?: config('ultra-helper.encryption_iv');

        $encText = base64_encode(hex2bin($encryptedString));

        $decrypted = openssl_decrypt(
            $encText,
            "AES-256-CBC",
            hex2bin($encKey),
            0,
            hex2bin($encIV)
        );

        return $decrypted;
    }
}
