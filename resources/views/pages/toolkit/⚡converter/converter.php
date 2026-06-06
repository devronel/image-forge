<?php

use App\Services\ImageProcessingService;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public array $images;
    public array $imagesData;

    public function forge()
    {
        foreach ($this->imagesData as $key => $image) {
            // dd($this->images[$image['id']], $image['toFormat']);
            $converted = app(ImageProcessingService::class)->convert($this->images[$image['id']], $image['toFormat']);
            dd($converted);
        }
    }
};
