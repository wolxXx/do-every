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


    private static function get(string $level, bool $reset = true): array
    {
        $session = Session::Factory(Session::NAMESPACE_APPLICATION);

        $messages = $session->get('messages_' . $level, []);
        if (true === $reset) {
            $session->write('messages_' . $level, []);
        }

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


    public static function getInfo(bool $reset = true): array
    {
        return static::get('info', $reset);
    }


    public static function getSuccess(bool $reset = true): array
    {
        return static::get('success', $reset);
    }


    public static function getDanger(bool $reset = true): array
    {
        return static::get('danger', $reset);
    }


    public static function getWarning(bool $reset = true): array
    {
        return static::get('warning', $reset);
    }


    public static function hasMessages(): bool
    {
        $data = [
            count(\array_keys(static::getInfo(false))),
            count(\array_keys(static::getSuccess(false))),
            count(\array_keys(static::getDanger(false))),
            count(\array_keys(static::getWarning(false))),
        ];

        return \array_sum($data) > 0;
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