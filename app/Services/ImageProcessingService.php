<?php

namespace App\Services;

use App\Enums\ImageFormat;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;

class ImageProcessingService
{
    public function __construct(
        protected ImageManager $manager
    )
    {}

    public function convert(UploadedFile $file, string $format): string 
    {
        $imageFormat = ImageFormat::from($format);

        $image = $this->manager->decode($file);

        if (in_array($file->extension(), ['png', 'webp']) && in_array($format, ['jpg', 'jpeg'])) {
            $image = $image->fill('#ffffff');
        }

        return $image->encodeUsingFormat($imageFormat->interventionFormat(), quality: 90)->toString();
    }
}
