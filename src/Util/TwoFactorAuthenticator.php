<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class TwoFactorAuthenticator
{
    protected \PragmaRX\Google2FA\Google2FA $utility;


    public static function Factory(): static
    {
        $instance          = new self();
        $instance->utility = new \PragmaRX\Google2FA\Google2FA();
        $instance->utility->setOneTimePasswordLength(6);

        return $instance;
    }


    public function getQRCodeUrl(string $login, string $secret): string
    {
        return $this
            ->utility
            ->getQRCodeUrl(
                '*do every*',
                $login,
                $secret
            )
        ;
    }


    public function generateSecretKey(): string
    {
        return $this
            ->utility
            ->generateSecretKey()
        ;
    }


    public function verify(string $token, string $secret): bool|int
    {
        return false !== $this
                ->utility
                ->verify($token, $secret)
        ;
    }
}