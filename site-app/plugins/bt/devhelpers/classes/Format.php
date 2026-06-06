<?php

namespace Bt\DevHelpers\Classes;

class Format
{
    /**
     *
     */
    public static function weight($weight, bool $displayUnit = true, string $unit = 'KG'): string
    {
        return number_format($weight, 2, '.', ',') . ($displayUnit ? ' ' . $unit : '');
    }

    /**
     *
     */
    public static function length($length, bool $displayUnit = true, string $unit = 'KG'): string
    {
        return $length;
    }

    /**
     *
     */
    public static function price($price, bool $displayUnit = true, string $unit = 'R'): string
    {
        return ($displayUnit ? $unit . ' ' : '') . number_format($price, 2, '.', ',');
    }

    /**
     *
     */
    public static function quantity($quantity): string
    {
        return $quantity;
    }
}
