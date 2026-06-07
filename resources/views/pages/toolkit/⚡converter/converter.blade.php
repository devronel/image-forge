<div x-data="converterData()" class="min-h-screen bg-slate-50 font-sans">

    @section('title', 'Image Forge | Converter')

    {{-- Hero Section --}}
    <section class="relative -mt-[73px] overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 pt-[73px]">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSA2MCAwIEwgMCAwIDAgNjAiIGZpbGw9Im5vbmUiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-40"></div>
        <div class="absolute -left-32 -top-32 h-96 w-96 rounded-full bg-indigo-500/10 blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 h-96 w-96 rounded-full bg-violet-500/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-20 sm:px-6 sm:pb-28 sm:pt-28 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Convert your images
                    <span class="bg-gradient-to-r from-amber-300 to-orange-400 bg-clip-text text-transparent">instantly</span>
                </h1>
                <p class="mt-4 text-lg leading-relaxed text-slate-300">
                    Drop any image and pick the format you need. Fast, secure, and right in your browser.
                </p>
            </div>

            {{-- Converter Card --}}
            <div class="mx-auto mt-12 max-w-2xl">
                <div class="overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-black/5">
                    <div class="p-6 sm:p-8">
                        {{-- Drop Zone --}}
                        <div
                            @dragover.prevent="dragOver = true"
                            @dragleave.prevent="dragOver = false"
                            @drop.prevent="handleDrop($event)"
                            :class="{
                                'relative flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed p-8 transition-all duration-200': true,
                                'border-indigo-300 bg-indigo-50/50': files.length === 0 && !dragOver,
                                'border-indigo-400 bg-indigo-100/70': dragOver,
                                'border-emerald-300 bg-emerald-50/50': files.length > 0 && !dragOver,
                            }"
                        >
                            <div @click="document.getElementById('fileInput').click()" class="flex flex-col items-center gap-3">
                                <span class="flex h-14 w-14 items-center justify-center rounded-full bg-indigo-100 text-indigo-600">
                                    <span class="icon-[mdi--file-image-outline] text-2xl"></span>
                                </span>
                                <div class="text-center">
                                    <p class="text-sm font-medium text-slate-700">
                                        <span class="text-indigo-600 underline underline-offset-2">Click to upload</span>
                                        <span class="text-slate-500"> or drag and drop</span>
                                    </p>
                                    <p class="mt-1 text-xs text-slate-400">PNG, JPEG, JPG, WebP — up to 50 MB each</p>
                                </div>
                            </div>
                            <input id="fileInput" type="file" accept=".jpeg,.jpg,.png,.webp" multiple @change="handleFileSelect($event)" class="hidden">
                        </div>

                        {{-- File List --}}
                        @if (!empty($convertedImages))
                            <div class="mt-6 space-y-3">
                                <p class="text-xs font-medium text-emerald-600">
                                    <span class="icon-[mdi--check-circle] mr-1 text-xs"></span>
                                    {{ count($convertedImages) }} converted file{{ count($convertedImages) !== 1 ? 's' : '' }}
                                </p>
                                @foreach ($convertedImages as $index => $converted)
                                    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                                        <div class="flex items-start gap-4 p-4">
                                            <div class="h-20 w-20 shrink-0 overflow-hidden rounded-lg bg-slate-100">
                                                <img src="{{ asset('storage/temp/' . $converted) }}" alt="" class="h-full w-full object-cover">
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="truncate text-sm font-medium text-slate-900">{{ $converted }}</p>
                                                @php
                                                    $fullPath = storage_path('app/public/temp/' . $converted);
                                                    $size = file_exists($fullPath) ? filesize($fullPath) : 0;
                                                @endphp
                                                <p class="mt-0.5 text-xs text-slate-500">{{ $size > 0 ? round($size / 1024, 1) . ' KB' : '' }}</p>
                                                <div class="mt-2">
                                                    <button
                                                        wire:click="downloadConverted({{ $index }})"
                                                        class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-indigo-700"
                                                    >
                                                        <span class="icon-[mdi--download] text-sm"></span>
                                                        Download
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <template x-if="files.length > 0">
                                <div class="mt-6">
                                    <div class="mb-3 flex items-center justify-between">
                                        <p class="text-xs font-medium text-slate-500">
                                            <span x-text="files.length"></span> file<span x-show="files.length !== 1">s</span> selected
                                        </p>
                                        <button @click="files = []; converted = false" class="text-xs font-medium text-red-500 transition hover:text-red-600">Remove all</button>
                                    </div>
                                    <div class="space-y-2">
                                        <template x-for="(entry, index) in files" :key="entry.id">
                                            <div class="flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50/50 px-3 py-2.5">
                                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-indigo-100 text-indigo-600">
                                                    <span class="icon-[mdi--file-image-outline] text-sm"></span>
                                                </span>
                                                <div class="min-w-0 flex-1">
                                                    <p class="truncate text-sm font-medium text-slate-900" x-text="entry.name"></p>
                                                    <p class="text-xs text-slate-400" x-text="formatSize(entry.size)"></p>
                                                </div>

                                                {{-- From format (auto-detected, disabled) --}}
                                                <span class="flex shrink-0 items-center gap-1 rounded-md border border-slate-200 bg-slate-100 px-2 py-1 text-[11px] font-semibold uppercase text-slate-500">
                                                    <span x-text="entry.fromFormat"></span>
                                                </span>

                                                <span class="text-slate-300">
                                                    <span class="icon-[mdi--arrow-right] text-lg"></span>
                                                </span>

                                                {{-- To format dropdown --}}
                                                <div class="relative shrink-0" x-data="{ open: false }" x-on:click.outside="open = false">
                                                    <button
                                                        x-on:click="open = !open"
                                                        class="flex items-center gap-1.5 rounded-md border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-900 transition hover:border-slate-300"
                                                    >
                                                        <span x-text="entry.toFormat.toUpperCase()"></span>
                                                        <span class="icon-[mdi--chevron-down] text-slate-400 text-[14px]" x-bind:class="{ 'rotate-180': open }"></span>
                                                    </button>
                                                    <div
                                                        x-show="open"
                                                        x-cloak
                                                        x-transition:enter="transition duration-100 ease-out"
                                                        x-transition:enter-start="translate-y-0.5 opacity-0"
                                                        x-transition:enter-end="translate-y-0 opacity-100"
                                                        class="absolute right-0 top-full z-20 mt-1 w-40 overflow-auto rounded-lg border border-slate-200 bg-white py-1 shadow-lg"
                                                    >
                                                        <template x-for="fmt in formats" :key="fmt.value">
                                                            <button
                                                                x-on:click="selectToFormat(index, fmt.value); open = false"
                                                                class="flex w-full items-center gap-2 px-3 py-1.5 text-left text-xs transition hover:bg-slate-50"
                                                                x-bind:class="{ 'bg-indigo-50 text-indigo-700': fmt.value === entry.toFormat }"
                                                            >
                                                                <span class="flex h-5 w-5 items-center justify-center rounded bg-slate-100 text-[9px] font-bold uppercase text-slate-500" x-text="fmt.value"></span>
                                                                <span class="font-medium" x-text="fmt.label"></span>
                                                                <span x-show="fmt.value === entry.toFormat" class="ml-auto text-indigo-500">
                                                                    <span class="icon-[mdi--check-bold] text-[11px]"></span>
                                                                </span>
                                                            </button>
                                                        </template>
                                                    </div>
                                                </div>

                                                {{-- Remove --}}
                                                <button @click="removeFile(index)" class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md text-slate-400 transition hover:bg-slate-100 hover:text-slate-600">
                                                    <span class="icon-[mdi--close] text-sm"></span>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        @endif

                        {{-- Convert Button --}}
                        <div class="mt-6">
                            <button
                                wire:click='forge()'
                                :disabled="files.length === 0 || converting"
                                class="flex w-full items-center justify-center gap-2.5 rounded-xl px-6 py-3.5 text-sm font-semibold text-white transition-all duration-200 disabled:cursor-not-allowed disabled:opacity-50"
                                :class="converting ? 'bg-indigo-500' : files.length > 0 ? 'bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98]' : 'bg-slate-300'"
                            >
                                <template x-if="!converting && !converted">
                                    <>
                                        <span class="icon-[mdi--upload-outline] text-lg"></span>
                                        Convert <span x-show="files.length > 0" x-text="'(' + files.length + ')'"></span>
                                    </>
                                </template>
                                <template x-if="converting">
                                    <>
                                        <span class="inline-block h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white"></span>
                                        Converting...
                                    </>
                                </template>
                                <template x-if="converted && !converting">
                                    <>
                                        <span class="icon-[mdi--check-circle] text-lg"></span>
                                        Conversion Complete
                                    </>
                                </template>
                            </button>
                        </div>

                        {{-- Trust Bar --}}
                        <div class="mt-5 flex items-center justify-center gap-6 text-xs text-slate-400">
                            <span class="flex items-center gap-1.5">
                                <span class="icon-[mdi--lock-outline] text-sm"></span>
                                Secure
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="icon-[mdi--lightning-bolt-outline] text-sm"></span>
                                Fast
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="icon-[mdi--cloud-off-outline] text-sm"></span>
                                No upload required
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Section --}}
    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-8 sm:grid-cols-4">
                <div class="text-center">
                    <p class="text-2xl font-bold text-slate-900 sm:text-3xl">200+</p>
                    <p class="mt-1 text-xs font-medium text-slate-500">Formats Supported</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-slate-900 sm:text-3xl">99.9%</p>
                    <p class="mt-1 text-xs font-medium text-slate-500">Uptime</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-slate-900 sm:text-3xl">Free</p>
                    <p class="mt-1 text-xs font-medium text-slate-500">No hidden costs</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-slate-900 sm:text-3xl">256-bit</p>
                    <p class="mt-1 text-xs font-medium text-slate-500">Encryption</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="bg-white py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                    Why Image Forge?
                </h2>
                <p class="mt-3 text-base leading-relaxed text-slate-500">
                    Fast, secure, and simple image conversion. Convert your images in seconds with support for the most common web formats.
                </p>
            </div>

            <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

                <div class="group rounded-xl border border-slate-200 bg-white p-6 transition hover:border-indigo-200 hover:shadow-md">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 transition group-hover:bg-indigo-200">
                        <span class="icon-[mdi--lightning-bolt-outline] text-xl"></span>
                    </span>
                    <h3 class="mt-4 text-base font-semibold text-slate-900">
                        Fast Conversion
                    </h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">
                        Convert images quickly with an optimized processing pipeline designed for speed.
                    </p>
                </div>

                <div class="group rounded-xl border border-slate-200 bg-white p-6 transition hover:border-indigo-200 hover:shadow-md">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 transition group-hover:bg-indigo-200">
                        <span class="icon-[mdi--shield-check-outline] text-xl"></span>
                    </span>
                    <h3 class="mt-4 text-base font-semibold text-slate-900">
                        Secure Processing
                    </h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">
                        Files are processed temporarily and automatically cleaned up to help protect your privacy.
                    </p>
                </div>

                <div class="group rounded-xl border border-slate-200 bg-white p-6 transition hover:border-indigo-200 hover:shadow-md">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 transition group-hover:bg-indigo-200">
                        <span class="icon-[mdi--image-outline] text-xl"></span>
                    </span>
                    <h3 class="mt-4 text-base font-semibold text-slate-900">
                        High Quality Output
                    </h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">
                        Convert images while maintaining clear and reliable image quality.
                    </p>
                </div>

                <div class="group rounded-xl border border-slate-200 bg-white p-6 transition hover:border-indigo-200 hover:shadow-md">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 transition group-hover:bg-indigo-200">
                        <span class="icon-[mdi--file-image-outline] text-xl"></span>
                    </span>
                    <h3 class="mt-4 text-base font-semibold text-slate-900">
                        Popular Formats
                    </h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">
                        Easily convert between JPG, PNG, and WebP image formats.
                    </p>
                </div>

                <div class="group rounded-xl border border-slate-200 bg-white p-6 transition hover:border-indigo-200 hover:shadow-md">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 transition group-hover:bg-indigo-200">
                        <span class="icon-[mdi--responsive] text-xl"></span>
                    </span>
                    <h3 class="mt-4 text-base font-semibold text-slate-900">
                        Works Everywhere
                    </h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">
                        Use Image Forge on desktop, tablet, or mobile with a responsive experience.
                    </p>
                </div>

                <div class="group rounded-xl border border-slate-200 bg-white p-6 transition hover:border-indigo-200 hover:shadow-md">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 transition group-hover:bg-indigo-200">
                        <span class="icon-[mdi--infinity] text-xl"></span>
                    </span>
                    <h3 class="mt-4 text-base font-semibold text-slate-900">
                        Free to Use
                    </h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">
                        Convert as many images as you need without subscriptions or hidden limits.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- Supported Formats Section --}}
    <section class="border-t border-slate-200 bg-slate-50 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Supported Formats</h2>
                <p class="mt-3 text-base leading-relaxed text-slate-500">
                    Every image format you'll ever need, all in one place.
                </p>
            </div>
            <div class="mt-12">
                <template x-for="category in formatCategories" :key="category.name">
                    <div class="mb-8 last:mb-0">
                        <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-slate-400" x-text="category.name"></h3>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="fmt in category.formats" :key="fmt">
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:border-indigo-200 hover:text-indigo-600"
                                    x-text="fmt"
                                ></span>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>
</div>

@script
    <script>
        Alpine.data('converterData', () => ({
            files: @entangle('imagesData'),
            convertedImages: @entangle('convertedImages'),
            dragOver: false,
            converting: false,
            converted: false,
            idCounter: 0,

            formats: [
                { value: 'png', label: 'PNG', desc: 'Lossless, transparency' },
                { value: 'jpg', label: 'JPG', desc: 'Lossy, small files' },
                { value: 'webp', label: 'WebP', desc: 'Modern, efficient' }
            ],

            formatCategories: [
                {
                    name: 'Raster Images',
                    formats: ['PNG', 'JPG', 'WebP'],
                }
            ],

            formatSize(bytes) {
                if (!bytes) return ''
                if (bytes < 1024) return bytes + ' B'
                if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB'
                return (bytes / 1048576).toFixed(1) + ' MB'
            },

            handleFileSelect(event) {
                this.addFiles(event.target.files)
                event.target.value = ''
            },

            handleDrop(event) {
                this.dragOver = false
                this.addFiles(event.dataTransfer.files)
            },

            addFiles(fileList) {
                this.convertedImages = []
                for (const file of fileList) {
                    console.log(file)
                    if (!file.type.startsWith('image/')) continue
                    const ext = file.name.split('.').pop().toLowerCase()
                    const match = this.formats.find(f => f.value === ext)
                    let id = this.idCounter++
                    this.files.push({
                        id: id,
                        name: file.name,
                        size: file.size,
                        fromFormat: match ? ext : 'png',
                        toFormat: ext === 'png' ? 'jpg' : 'png',
                    })

                    this.$wire.upload(
                        `images.${id}`,
                        file,
                        (uploadedFilename) => {
                            console.log(uploadedFilename)
                        }
                    )
                }
                this.converted = false
            },

            removeFile(index) {
                this.files.splice(index, 1)
                if (this.files.length === 0) this.converted = false
            },

            selectToFormat(index, value) {
                this.files[index].toFormat = value
                this.converted = false
            },

            convert() {
                // if (this.files.length === 0 || this.converting) return
                // this.converting = true
                // this.converted = false

                // setTimeout(() => {
                //     this.converting = false
                //     this.converted = true
                // }, 2000)
            },
        }))
    </script>
@endscript
