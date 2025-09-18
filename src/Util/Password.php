<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class Password
{
    public static function hash(string $password): string
    {
        return \password_hash(password: $password, algo: PASSWORD_BCRYPT);
    }

    public static function verify(string $password, string $hash): bool
    {
        return \password_verify(password: $password, hash: $hash);
    }
}
