<?php

namespace App\Services;

use App\Enums\ImageFormat;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

class ImageProcessingService
{
    public function __construct(
        protected ImageManager $manager
    )
    {}

    public function convert(UploadedFile $file, string $format): string 
    {

        $path = $this->generatePath($format);

        $imageFormat = ImageFormat::from($format);

        $image = $this->manager->decode($file);

        if (
            in_array(
                $file->extension(),
                ['png', 'webp']
            ) &&
            in_array($format, ['jpg', 'jpeg'])
        ) {
            $image = $image->fill('#ffffff');
        }

        $image
            ->encodeUsingFormat($imageFormat->interventionFormat())
            ->save($path);

        return $path;
    }

    private function generatePath(string $extension): string 
    {

        $fileName = uniqid() . '.' . $extension;

        return storage_path(
            "app/temp/{$fileName}"
        );
    }
}
