<?php

declare(strict_types=1);

namespace DoEveryApp\Util\User;

class Current
{
    public const string LANGUAGE_GERMAN  = 'de';

    public const string LANGUAGE_ENGLISH = 'en';

    public const string LANGUAGE_FRENCH  = 'fr';

    public static ?\DoEveryApp\Entity\Worker $forcedLoggedInUser = null;


    private static function getAuthSession(): \DoEveryApp\Util\Session
    {
        return \DoEveryApp\Util\Session::Factory(\DoEveryApp\Util\Session::NAMESPACE_APPLICATION);
    }


    public static function get(): ?\DoEveryApp\Entity\Worker
    {
        if (null !== static::$forcedLoggedInUser) {
            return static::$forcedLoggedInUser;
        }
        $session = static::getAuthSession()->get(\DoEveryApp\Util\Session::NAMESPACE_AUTH);
        if (null === $session) {
            return null;
        }
        if (true === $session instanceof \DoEveryApp\Entity\Worker) {
            return \DoEveryApp\Entity\Worker::getRepository()->find($session->getId());
        }

        return \DoEveryApp\Entity\Worker::getRepository()->find($session->user->id);
    }


    public static function logout(): void
    {
        static::getAuthSession()->clear(\DoEveryApp\Util\Session::NAMESPACE_AUTH);
    }


    public static function login(\DoEveryApp\Entity\Worker $user): void
    {
        $userToStore           = new \stdClass();
        $userToStore->user     = new \stdClass();
        $userToStore->user->id = $user->getId();
        static::getAuthSession()->write(\DoEveryApp\Util\Session::NAMESPACE_AUTH, $userToStore);

        if (true === $user->doNotifyLogin()) {
            \DoEveryApp\Util\Mailing\Login::send($user);
        }
        $user->setLastLogin(\Carbon\Carbon::now());
        $user::getRepository()->update($user);
        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getEntityManager()
                                            ->flush()
        ;

        \DoEveryApp\Util\FlashMessenger::addSuccess('welcome, ' . \DoEveryApp\Util\View\Worker::get($user));
    }


    public static function isAuthenticated(): bool
    {
        return true === static::get() instanceof \DoEveryApp\Entity\Worker;
    }


    public static function getLanguage(): string
    {
        return $_COOKIE['lang'] ?? \DoEveryApp\Util\Translator::LANGUAGE_GERMAN;
    }


    public static function setLanguage(?string $language): void
    {
        $_COOKIE['lang'] = $language;
    }


    public static function getLocale(): string
    {
        return match (static::getLanguage()) {
            \DoEveryApp\Util\Translator::LANGUAGE_FRENCH  => 'fr_FR',
            \DoEveryApp\Util\Translator::LANGUAGE_ENGLISH => 'en_US',
            \DoEveryApp\Util\Translator::LANGUAGE_POLISH  => 'pl_PL',
            \DoEveryApp\Util\Translator::LANGUAGE_MAORI   => 'mi_NZ',
            default                                       => 'de_DE',
        };
    }
}