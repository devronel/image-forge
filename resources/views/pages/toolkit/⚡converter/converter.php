<?php

use App\Enums\ImageFormat;
use App\Services\ImageProcessingService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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
            $rules["images.$id"] = ['required', 'file', 'image', 'max:16384'];
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
                $data = app(ImageProcessingService::class)->convert($validated['images'][$image['id']], $image['toFormat']);
                $name = now()->format('Ymd_His') . '_' . Str::ulid() . '.' . $image['toFormat'];
                $this->convertedImages[] = ['name' => $name, 'data' => base64_encode($data)];
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
        $item = $this->convertedImages[$index] ?? null;

        if (!$item) {
            abort(404);
        }

        return response()->streamDownload(function () use ($item) {
            echo base64_decode($item['data']);
        }, $item['name']);
    }
};
