<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::toolkit.converter')->name('converter.index');
Route::livewire('/resizer', 'pages::toolkit.resizer')->name('resizer.index');
Route::livewire('/compressor', 'pages::toolkit.compressor')->name('compressor.index');