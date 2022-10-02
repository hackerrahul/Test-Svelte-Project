<?php

function encrypt($plaintext, $key, $cipher = "aes-256-gcm") {
    if (!in_array($cipher, openssl_get_cipher_methods())) {
        return false;
    }
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
    $tag = null;
    $ciphertext = openssl_encrypt(
        gzcompress($plaintext),
        $cipher,
        base64_decode($key),
        $options=0,
        $iv,
        $tag,
    );
    return base64_encode(json_encode(
        array(
            "ciphertext" => base64_encode($ciphertext),
            "cipher" => $cipher,
            "iv" => base64_encode($iv),
            "tag" => base64_encode($tag),
        )
    ));
}

function decrypt($cipherjson, $key) {
    try {
        $json = json_decode(base64_decode($cipherjson), true, 2,  JSON_THROW_ON_ERROR);
    } catch (Exception $e) {
        return false;
    }
    return gzuncompress(
        openssl_decrypt(
            base64_decode($json['ciphertext']),
            $json['cipher'],
            base64_decode($key),
            $options=0,
            base64_decode($json['iv']),
            base64_decode($json['tag'])
        )
    );
}

?>