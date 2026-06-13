<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>@yield('title', 'Image Forge — Free Image Converter, Resizer & Compressor')</title>

        <meta name="description" content="@yield('description', 'Image Forge is a free online image converter, resizer, and compressor. Convert images to JPG, PNG, WebP instantly — all in your browser, no installation needed.')">
        <meta name="keywords" content="@yield('keywords', 'image converter, free image converter, convert image to JPG, convert image to PNG, convert image to WebP, image resizer, image compressor, online image tool')">
        <meta name="robots" content="@yield('robots', 'index, follow')">

        {{-- Open Graph --}}
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="@yield('og:title', 'Image Forge')">
        <meta property="og:description" content="@yield('og:description', 'Image Forge is a free online image converter, resizer, and compressor.')">
        <meta property="og:image" content="@yield('og:image', asset('og-image.png'))">

        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="@yield('twitter:title', 'Image Forge')">
        <meta name="twitter:description" content="@yield('twitter:description', 'Image Forge is a free online image converter.')">
        <meta name="twitter:image" content="@yield('twitter:image', asset('og-image.png'))">

        {{-- Canonical --}}
        <link rel="canonical" href="@yield('canonical', url()->current())">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body>
        <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:inset-x-0 focus:top-0 focus:z-50 focus:bg-indigo-600 focus:p-3 focus:text-center focus:text-sm focus:font-semibold focus:text-white focus:outline-none">
            Skip to main content
        </a>

        <x-shared.navbar />

        <main id="main-content" tabindex="-1">
            {{ $slot }}
        </main>

        <x-shared.footer />

        @livewireScripts
    </body>
</html>
