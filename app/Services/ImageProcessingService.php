<?php

namespace App\Services;

use App\Enums\ImageFormat;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

class ImageProcessingService
{
    public function __construct(
        protected ImageManager $manager
    )
    {}

    public function convert(UploadedFile $file, string $format): string 
    {
        $filename = now()->format('Ymd_His') . '_' . Str::ulid() . '.' . $format;

        $path = $this->generatePath($filename);

        $imageFormat = ImageFormat::from($format);

        $image = $this->manager->decode($file);

        if (in_array($file->extension(), ['png', 'webp']) && in_array($format, ['jpg', 'jpeg'])) {
            $image = $image->fill('#ffffff');
        }

        $image->encodeUsingFormat($imageFormat->interventionFormat(), quality: 90)->save($path);

        return $filename;
    }

    private function generatePath(string $filename): string 
    {
        return storage_path(
            "app/public/temp/{$filename}"
        );
    }
}
