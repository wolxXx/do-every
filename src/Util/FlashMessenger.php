<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class FlashMessenger
{
    private static function add(string $level, string $message): void
    {
        $session    = Session::Factory(Session::NAMESPACE_APPLICATION);
        $existing   = $session->get('messages_' . $level, []);
        $existing[] = $message;
        $session->write('messages_' . $level, $existing);
    }


    private static function get($level): array
    {
        $session = Session::Factory(Session::NAMESPACE_APPLICATION);

        $messages = $session->get('messages_' . $level, []);
        $session->write('messages_' . $level, []);

        return $messages;
    }


    public static function addInfo(string $message): void
    {
        static::add('info', $message);
    }


    public static function addSuccess(string $message): void
    {
        static::add('success', $message);
    }


    public static function addDanger(string $message): void
    {
        static::add('danger', $message);
    }


    public static function addWarning(string $message): void
    {
        static::add('warning', $message);
    }


    public static function getInfo(): array
    {
        return static::get('info');
    }


    public static function getSuccess(): array
    {
        return static::get('success');
    }


    public static function getDanger(): array
    {
        return static::get('danger');
    }


    public static function getWarning(): array
    {
        return static::get('warning');
    }


    public static function getAll(): array
    {
        return [
            'info'    => static::getInfo(),
            'success' => static::getSuccess(),
            'danger'  => static::getDanger(),
            'warning' => static::getWarning(),
        ];
    }
}