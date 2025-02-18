<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class FlashMessenger
{
    private static function add(string $level, string $message): void
    {
        $session    = Session::Factory(namespace: Session::NAMESPACE_APPLICATION);
        $existing   = $session->get(what: 'messages_' . $level, default: []);
        $existing[] = $message;
        $session->write(what: 'messages_' . $level, data: $existing);
    }

    private static function get(string $level, bool $reset = true): array
    {
        $session = Session::Factory(namespace: Session::NAMESPACE_APPLICATION);

        $messages = $session->get(what: 'messages_' . $level, default: []);
        if (true === $reset) {
            $session->write(what: 'messages_' . $level, data: []);
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
            count(value: \array_keys(array: static::getInfo(false))),
            count(value: \array_keys(array: static::getSuccess(false))),
            count(value: \array_keys(array: static::getDanger(false))),
            count(value: \array_keys(array: static::getWarning(false))),
        ];

        return \array_sum(array: $data) > 0;
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
