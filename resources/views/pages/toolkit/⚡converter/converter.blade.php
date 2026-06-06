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
                    {{-- Drop Zone --}}
                    <div class="p-6 sm:p-8">
                        <div
                            @@dragover.prevent="dragOver = true"
                            @@dragleave.prevent="dragOver = false"
                            @@drop.prevent="handleDrop($event)"
                            :class="{
                                'relative flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed p-8 transition-all duration-200': true,
                                'border-indigo-300 bg-indigo-50/50': !file && !dragOver,
                                'border-indigo-400 bg-indigo-100/70': dragOver && !file,
                                'border-emerald-300 bg-emerald-50/50': file,
                            }"
                        >
                            <template x-if="!file">
                                <div @@click="document.getElementById('fileInput').click()" class="flex flex-col items-center gap-3">
                                    <span class="flex h-14 w-14 items-center justify-center rounded-full bg-indigo-100 text-indigo-600">
                                        <span class="icon-[mdi--file-image-outline] text-2xl"></span>
                                    </span>
                                    <div class="text-center">
                                        <p class="text-sm font-medium text-slate-700">
                                            <span class="text-indigo-600 underline underline-offset-2">Click to upload</span>
                                            <span class="text-slate-500"> or drag and drop</span>
                                        </p>
                                        <p class="mt-1 text-xs text-slate-400">PNG, JPG, WebP, AVIF, GIF, SVG, BMP, TIFF — up to 50 MB</p>
                                    </div>
                                </div>
                            </template>
                            <template x-if="file">
                                <div class="flex w-full items-center gap-4">
                                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                                        <span class="icon-[mdi--check-circle] text-xl"></span>
                                    </span>
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-slate-900" x-text="fileName"></p>
                                        <p class="text-xs text-slate-500" x-text="formattedFileSize"></p>
                                    </div>
                                    <button @@click="removeFile()" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-600">
                                        <span class="icon-[mdi--close] text-lg"></span>
                                    </button>
                                </div>
                            </template>
                            <input id="fileInput" type="file" accept="image/*" @@change="handleFileSelect($event)" class="hidden">
                        </div>

                        {{-- Format Selectors --}}
                        <div class="mt-6 flex items-center gap-3">
                            <div class="flex-1">
                                <label class="mb-1.5 block text-xs font-medium text-slate-500">From</label>
                                <div class="relative" @@click.outside="showFromDropdown = false">
                                    <button
                                        @@click="showFromDropdown = !showFromDropdown"
                                        class="flex w-full items-center justify-between gap-2 rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-900 transition hover:border-slate-300"
                                    >
                                        <span class="flex items-center gap-2">
                                            <span class="flex h-5 w-5 items-center justify-center rounded bg-slate-100 text-[10px] font-bold uppercase text-slate-500" x-text="fromFormat"></span>
                                            <span x-text="fromFormatLabel"></span>
                                        </span>
                                        <span class="icon-[mdi--chevron-down] text-slate-400 transition" :class="{ 'rotate-180': showFromDropdown }"></span>
                                    </button>
                                    <div
                                        x-show="showFromDropdown"
                                        x-cloak
                                        x-transition:enter="transition duration-150 ease-out"
                                        x-transition:enter-start="translate-y-1 opacity-0"
                                        x-transition:enter-end="translate-y-0 opacity-100"
                                        class="absolute left-0 right-0 z-20 mt-1 max-h-60 overflow-auto rounded-lg border border-slate-200 bg-white py-1 shadow-lg"
                                    >
                                        <template x-for="fmt in formats" :key="fmt.value">
                                            <button
                                                @@click="selectFromFormat(fmt.value); showFromDropdown = false"
                                                class="flex w-full items-center gap-3 px-3.5 py-2 text-left text-sm transition hover:bg-slate-50"
                                                :class="{ 'bg-indigo-50 text-indigo-700': fmt.value === fromFormat }"
                                            >
                                                <span class="flex h-6 w-6 items-center justify-center rounded bg-slate-100 text-[10px] font-bold uppercase text-slate-500" x-text="fmt.value"></span>
                                                <div>
                                                    <p class="font-medium" x-text="fmt.label"></p>
                                                    <p class="text-xs text-slate-400" x-text="fmt.desc"></p>
                                                </div>
                                                <span x-show="fmt.value === fromFormat" class="ml-auto text-indigo-500">
                                                    <span class="icon-[mdi--check-bold] text-sm"></span>
                                                </span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            {{-- Swap Button --}}
                            <div class="pt-5">
                                <button
                                    @@click="swapFormats()"
                                    class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-400 transition hover:border-slate-300 hover:text-slate-600 active:scale-95"
                                    title="Swap formats"
                                >
                                    <span class="icon-[mdi--swap-horizontal-bold] text-lg"></span>
                                </button>
                            </div>

                            <div class="flex-1">
                                <label class="mb-1.5 block text-xs font-medium text-slate-500">To</label>
                                <div class="relative" @@click.outside="showToDropdown = false">
                                    <button
                                        @@click="showToDropdown = !showToDropdown"
                                        class="flex w-full items-center justify-between gap-2 rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-900 transition hover:border-slate-300"
                                    >
                                        <span class="flex items-center gap-2">
                                            <span class="flex h-5 w-5 items-center justify-center rounded bg-slate-100 text-[10px] font-bold uppercase text-slate-500" x-text="toFormat"></span>
                                            <span x-text="toFormatLabel"></span>
                                        </span>
                                        <span class="icon-[mdi--chevron-down] text-slate-400 transition" :class="{ 'rotate-180': showToDropdown }"></span>
                                    </button>
                                    <div
                                        x-show="showToDropdown"
                                        x-cloak
                                        x-transition:enter="transition duration-150 ease-out"
                                        x-transition:enter-start="translate-y-1 opacity-0"
                                        x-transition:enter-end="translate-y-0 opacity-100"
                                        class="absolute left-0 right-0 z-20 mt-1 max-h-60 overflow-auto rounded-lg border border-slate-200 bg-white py-1 shadow-lg"
                                    >
                                        <template x-for="fmt in formats" :key="fmt.value">
                                            <button
                                                @@click="selectToFormat(fmt.value); showToDropdown = false"
                                                class="flex w-full items-center gap-3 px-3.5 py-2 text-left text-sm transition hover:bg-slate-50"
                                                :class="{ 'bg-indigo-50 text-indigo-700': fmt.value === toFormat }"
                                            >
                                                <span class="flex h-6 w-6 items-center justify-center rounded bg-slate-100 text-[10px] font-bold uppercase text-slate-500" x-text="fmt.value"></span>
                                                <div>
                                                    <p class="font-medium" x-text="fmt.label"></p>
                                                    <p class="text-xs text-slate-400" x-text="fmt.desc"></p>
                                                </div>
                                                <span x-show="fmt.value === toFormat" class="ml-auto text-indigo-500">
                                                    <span class="icon-[mdi--check-bold] text-sm"></span>
                                                </span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Convert Button --}}
                        <div class="mt-6">
                            <button
                                @@click="convert()"
                                :disabled="!file || converting"
                                class="flex w-full items-center justify-center gap-2.5 rounded-xl px-6 py-3.5 text-sm font-semibold text-white transition-all duration-200 disabled:cursor-not-allowed disabled:opacity-50"
                                :class="converting ? 'bg-indigo-500' : file ? 'bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98]' : 'bg-slate-300'"
                            >
                                <template x-if="!converting && !converted">
                                    <>
                                        <span class="icon-[mdi--upload-outline] text-lg"></span>
                                        Convert
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
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Why Image Forge?</h2>
                <p class="mt-3 text-base leading-relaxed text-slate-500">
                    Built for speed and privacy. All processing happens locally — your files never leave your device.
                </p>
            </div>
            <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="group rounded-xl border border-slate-200 bg-white p-6 transition hover:border-indigo-200 hover:shadow-md">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 transition group-hover:bg-indigo-200">
                        <span class="icon-[mdi--lightning-bolt-outline] text-xl"></span>
                    </span>
                    <h3 class="mt-4 text-base font-semibold text-slate-900">Blazing Fast</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">
                        Optimized conversion pipelines deliver results in milliseconds. No queues, no waiting.
                    </p>
                </div>
                <div class="group rounded-xl border border-slate-200 bg-white p-6 transition hover:border-indigo-200 hover:shadow-md">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 transition group-hover:bg-indigo-200">
                        <span class="icon-[mdi--shield-check-outline] text-xl"></span>
                    </span>
                    <h3 class="mt-4 text-base font-semibold text-slate-900">Private by Design</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">
                        Files processed entirely in your browser. Nothing is ever stored on our servers.
                    </p>
                </div>
                <div class="group rounded-xl border border-slate-200 bg-white p-6 transition hover:border-indigo-200 hover:shadow-md">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 transition group-hover:bg-indigo-200">
                        <span class="icon-[mdi--cog-outline] text-xl"></span>
                    </span>
                    <h3 class="mt-4 text-base font-semibold text-slate-900">Lossless Quality</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">
                        Fine-tune compression and quality settings. Get the perfect balance every time.
                    </p>
                </div>
                <div class="group rounded-xl border border-slate-200 bg-white p-6 transition hover:border-indigo-200 hover:shadow-md">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 transition group-hover:bg-indigo-200">
                        <span class="icon-[mdi--file-image-outline] text-xl"></span>
                    </span>
                    <h3 class="mt-4 text-base font-semibold text-slate-900">All Formats</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">
                        From common formats to niche ones — we support everything you throw at us.
                    </p>
                </div>
                <div class="group rounded-xl border border-slate-200 bg-white p-6 transition hover:border-indigo-200 hover:shadow-md">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 transition group-hover:bg-indigo-200">
                        <span class="icon-[mdi--responsive] text-xl"></span>
                    </span>
                    <h3 class="mt-4 text-base font-semibold text-slate-900">Works Everywhere</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">
                        Desktop, tablet, or phone. The forge works on any device with a modern browser.
                    </p>
                </div>
                <div class="group rounded-xl border border-slate-200 bg-white p-6 transition hover:border-indigo-200 hover:shadow-md">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 transition group-hover:bg-indigo-200">
                        <span class="icon-[mdi--infinity] text-xl"></span>
                    </span>
                    <h3 class="mt-4 text-base font-semibold text-slate-900">Unlimited Use</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">
                        No daily limits, no premium tiers. Convert as many files as you need, completely free.
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
            // File State
            file: null,
            fileName: '',
            fileSize: 0,
            dragOver: false,

            // Format State
            fromFormat: 'png',
            toFormat: 'jpg',

            // Conversion State
            converting: false,
            converted: false,

            // UI State
            showFromDropdown: false,
            showToDropdown: false,

            // Format Data
            formats: [
                { value: 'png', label: 'PNG', desc: 'Lossless, transparency' },
                { value: 'jpg', label: 'JPG', desc: 'Lossy, small files' },
                { value: 'webp', label: 'WebP', desc: 'Modern, efficient' },
                { value: 'avif', label: 'AVIF', desc: 'Next-gen quality' },
                { value: 'gif', label: 'GIF', desc: 'Animation support' },
                { value: 'svg', label: 'SVG', desc: 'Vector graphics' },
                { value: 'bmp', label: 'BMP', desc: 'Uncompressed' },
                { value: 'tiff', label: 'TIFF', desc: 'Print ready' },
                { value: 'ico', label: 'ICO', desc: 'Icon files' },
                { value: 'heic', label: 'HEIC', desc: 'Apple format' },
            ],

            formatCategories: [
                {
                    name: 'Raster Images',
                    formats: ['PNG', 'JPG', 'WebP', 'AVIF', 'GIF', 'BMP', 'TIFF', 'ICO', 'HEIC'],
                },
                {
                    name: 'Vector Graphics',
                    formats: ['SVG'],
                },
            ],

            get formattedFileSize() {
                if (!this.fileSize) return ''
                const bytes = this.fileSize
                if (bytes < 1024) return bytes + ' B'
                if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB'
                return (bytes / 1048576).toFixed(1) + ' MB'
            },

            get fromFormatLabel() {
                const fmt = this.formats.find(f => f.value === this.fromFormat)
                return fmt ? fmt.label : this.fromFormat.toUpperCase()
            },

            get toFormatLabel() {
                const fmt = this.formats.find(f => f.value === this.toFormat)
                return fmt ? fmt.label : this.toFormat.toUpperCase()
            },

            handleFileSelect(event) {
                const files = event.target.files
                if (files.length > 0) this.setFile(files[0])
                event.target.value = ''
            },

            handleDrop(event) {
                this.dragOver = false
                const files = event.dataTransfer.files
                if (files.length > 0) this.setFile(files[0])
            },

            setFile(file) {
                if (!file.type.startsWith('image/')) return
                this.file = file
                this.fileName = file.name
                this.fileSize = file.size
                this.converted = false

                const ext = file.name.split('.').pop().toLowerCase()
                const match = this.formats.find(f => f.value === ext)
                if (match) this.fromFormat = ext
            },

            removeFile() {
                this.file = null
                this.fileName = ''
                this.fileSize = 0
                this.converted = false
            },

            swapFormats() {
                const temp = this.fromFormat
                this.fromFormat = this.toFormat
                this.toFormat = temp
            },

            selectFromFormat(value) {
                this.fromFormat = value
                this.converted = false
            },

            selectToFormat(value) {
                this.toFormat = value
                this.converted = false
            },

            convert() {
                if (!this.file || this.converting) return
                this.converting = true
                this.converted = false

                setTimeout(() => {
                    this.converting = false
                    this.converted = true
                }, 2000)
            },
        }))
    </script>
@endscript
