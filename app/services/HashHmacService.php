<?php

namespace App\Services;


class HashHmacService
{
    public function createSign(string $algo, string $string, string $key) : string
    {
        return hash_hmac(
            $algo,
            $string,
            $key
        );
    }
}
