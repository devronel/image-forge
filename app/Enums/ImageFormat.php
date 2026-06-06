<?php

namespace App\Enums;

use Intervention\Image\Format;

enum ImageFormat: string
{
    case WEBP = 'webp';
    case PNG  = 'png';
    case JPG  = 'jpg';
    case JPEG = 'jpeg';

    public function interventionFormat(): Format
    {
        return match ($this) {
            self::WEBP => Format::WEBP,
            self::PNG  => Format::PNG,
            self::JPG, self::JPEG => Format::JPEG,
        };
    }

    public function extension(): string
    {
        return match ($this) {
            self::WEBP => 'webp',
            self::PNG  => 'png',
            self::JPG, self::JPEG => 'jpg',
        };
    }
}
