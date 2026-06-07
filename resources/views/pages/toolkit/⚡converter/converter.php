<?php

use App\Enums\ImageFormat;
use App\Services\ImageProcessingService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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
        $validFormats = array_map(fn($case) => $case->value, ImageFormat::cases());

        $rules = [
            'imagesData' => ['required', 'array', 'min:1'],
            'imagesData.*.id' => ['required', 'integer'],
            'imagesData.*.toFormat' => ['required', 'string', 'in:' . implode(',', $validFormats)],
        ];

        foreach ($this->imagesData ?? [] as $image) {
            $id = $image['id'] ?? null;
            $rules["images.$id"] = ['required', 'file', 'image', 'max:51200'];
        }

        $files = [];
        foreach ($this->imagesData ?? [] as $image) {
            $id = $image['id'] ?? null;
            if ($id !== null) {
                $files[$id] = $this->images[$id] ?? null;
            }
        }

        $validated = Validator::make([
            'imagesData' => $this->imagesData,
            'images' => $files,
        ], $rules)->validate();

        try {
            foreach ($validated['imagesData'] as $image) {
                $converted = app(ImageProcessingService::class)->convert($validated['images'][$image['id']], $image['toFormat']);
                $this->convertedImages[] = $converted;
            }
    
            $this->reset('images', 'imagesData');
        } catch (\Throwable $th) {
            Log::error('Convertion Error', [
                'message' => $th->getMessage(),
                'line' => $th->getLine()
            ]);
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
