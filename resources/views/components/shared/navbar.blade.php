<header x-data="{ mobileOpen: false }" class="relative z-30 border-b border-white/10 bg-transparent">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="/" class="flex items-center gap-2.5">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-white backdrop-blur-sm">
                <span class="icon-[mdi--image-outline] text-lg"></span>
            </span>
            <span class="text-lg font-semibold tracking-tight text-white">Image Forge</span>
        </a>
        <nav class="hidden items-center gap-8 sm:flex">
            <a href="#" class="text-sm font-medium text-white/70 transition hover:text-white">Converter</a>
            <a href="#" class="text-sm font-medium text-white/70 transition hover:text-white">Resize</a>
            <a href="#" class="text-sm font-medium text-white/70 transition hover:text-white">Compress</a>
            <a href="#" class="text-sm font-medium text-white/70 transition hover:text-white">API</a>
        </nav>
        <button @click="mobileOpen = !mobileOpen" class="flex h-9 w-9 items-center justify-center rounded-lg text-white/70 sm:hidden">
            <span class="icon-[mdi--menu] text-xl"></span>
        </button>
    </div>
    <div x-show="mobileOpen" x-cloak @click.outside="mobileOpen = false" class="border-t border-white/10 bg-slate-900 px-4 py-3 sm:hidden">
        <div class="flex flex-col gap-2">
            <a href="#" class="rounded-lg px-3 py-2 text-sm font-medium text-white/70 transition hover:bg-white/10 hover:text-white">Converter</a>
            <a href="#" class="rounded-lg px-3 py-2 text-sm font-medium text-white/70 transition hover:bg-white/10 hover:text-white">Resize</a>
            <a href="#" class="rounded-lg px-3 py-2 text-sm font-medium text-white/70 transition hover:bg-white/10 hover:text-white">Compress</a>
            <a href="#" class="rounded-lg px-3 py-2 text-sm font-medium text-white/70 transition hover:bg-white/10 hover:text-white">API</a>
        </div>
    </div>
</header>
