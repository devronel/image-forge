<?php

use App\Services\ImageProcessingService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\StreamedResponse;

new class extends Component
{
    use WithFileUploads;

    public array $images;
    public array $imagesData;
    public array $convertedImages;

    public function forge()
    {
        try {
            foreach ($this->imagesData as $key => $image) {
                $converted = app(ImageProcessingService::class)->convert($this->images[$image['id']], $image['toFormat']);
                $this->convertedImages[] = $converted;
            }
    
            $this->reset('images', 'imagesData');
        } catch (\Throwable $th) {
            
        }
    }

    public function downloadConverted(int $index): StreamedResponse
    {
        $filename = $this->convertedImages[$index] ?? null;
        $path = storage_path('app/public/temp/' . $filename);

        if (!$filename || !file_exists($path)) {
            abort(404);
        }

        return response()->streamDownload(function () use ($path) {
            echo file_get_contents($path);
        }, $filename);
    }
};
