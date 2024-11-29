<?php

declare(strict_types = 1);

namespace DoEveryApp\Util\View;

class Icon
{
    public static function add(): string
    {
        return '<i class="fa fa-plus"></i>';
    }


    public static function check(): string
    {
        return '<i class="fa-solid fa-check"></i>';
    }


    public static function cross(): string
    {
        return '<i class="fa-solid fa-xmark"></i>';
    }


    public static function edit(): string
    {
        return '<i class="fa-solid fa-pencil"></i>';
    }


    public static function hand(): string
    {
        return '<i class="fa-solid fa-hand"></i>';
    }


    public static function off(): string
    {
        return '<i class="fa-solid fa-moon"></i>';
    }


    public static function on(): string
    {
        return '<i class="fa-solid fa-power-off"></i>';
    }


    public static function refresh(): string
    {
        return '<i class="fa-solid fa-arrows-rotate"></i>';
    }


    public static function show(): string
    {
        return '<i class="fa-solid fa-eye"></i>';
    }


    public static function trash(): string
    {
        return '<i class="fa-solid fa-trash"></i>';
    }


    public static function wrench(): string
    {
        return '<i class="fa-solid fa-wrench"></i>';
    }
}