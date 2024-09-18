<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class TokenGenerator
{
    public static function getUserPasswordReset(): string
    {
        while (true) {
            $token    = \Ramsey\Uuid\Uuid::uuid4()->toString();
            $existing = \DoEveryApp\Entity\Worker::getRepository()->findOneByPasswordResetToken($token);
            if (false === $existing instanceof \DoEveryApp\Entity\Worker) {
                return $token;
            }
        }
    }


    public static function getUserPasswordResetValidUntil(): \DateTime
    {
        return \Carbon\Carbon::now()
                             ->addDays(30)
                             ->setHour(23)
                             ->setMinute(59)
                             ->setSecond(59)
                             ->toDate()
        ;
    }
}
