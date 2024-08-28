<?php

declare(strict_types=1);

namespace DoEveryApp\Util\User;

class Current
{
    public const string LANGUAGE_GERMAN  = 'de';

    public const string LANGUAGE_ENGLISH = 'en';

    public const string LANGUAGE_FRENCH  = 'fr';


    private static function getAuthSession(): \MyDMS\Util\Session
    {
        return \MyDMS\Util\Session::Factory(\MyDMS\Util\Session::NAMESPACE_APPLICATION);
    }


    public static function get(): ?\MyDMS\Model\User
    {
        $session = static::getAuthSession()->get(\MyDMS\Util\Session::NAMESPACE_AUTH);
        if (null === $session) {
            return null;
        }
        if (true === $session instanceof \MyDMS\Model\User) {
            return \MyDMS\Model\User::getRepository()->find($session->getId());
        }

        return \MyDMS\Model\User::getRepository()->find($session->user->id);
    }


    public static function logout(): void
    {
        static::getAuthSession()->clear(\MyDMS\Util\Session::NAMESPACE_AUTH);
    }


    public static function login(\MyDMS\Model\User $user): void
    {
        $userToStore           = new \stdClass();
        $userToStore->user     = new \stdClass();
        $userToStore->user->id = $user->getId();
        static::getAuthSession()->write(\MyDMS\Util\Session::NAMESPACE_AUTH, $userToStore);
    }


    public static function isAuthenticated(): bool
    {
        return true === static::get() instanceof \MyDMS\Model\User;
    }


    public static function getLanguage(): string
    {
        $currentUser = static::get();
        if (null !== $currentUser && null !== $currentUser->getLanguage()) {
            return $currentUser->getLanguage();
        }

        return 'de';
    }
}