<header x-data="{ mobileOpen: false }" class="relative z-30 border-b border-white/10 bg-transparent">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="/" class="flex items-center gap-2.5" aria-label="Image Forge home">
            <x-shared.logo class="text-white" />
        </a>
        <nav aria-label="Main navigation" class="hidden items-center gap-8 sm:flex">
            <a href="{{ route('converter.index') }}" @class(['text-sm font-medium transition', 'text-white' => request()->routeIs('converter.index'), 'text-white/70 hover:text-white' => !request()->routeIs('converter.index')]) aria-current="{{ request()->routeIs('converter.index') ? 'page' : 'false' }}">Converter</a>
            <a href="{{ route('resizer.index') }}" @class(['text-sm font-medium transition', 'text-white' => request()->routeIs('resizer.index'), 'text-white/70 hover:text-white' => !request()->routeIs('resizer.index')]) aria-current="{{ request()->routeIs('resizer.index') ? 'page' : 'false' }}">Resize</a>
            <a href="{{ route('compressor.index') }}" @class(['text-sm font-medium transition', 'text-white' => request()->routeIs('compressor.index'), 'text-white/70 hover:text-white' => !request()->routeIs('compressor.index')]) aria-current="{{ request()->routeIs('compressor.index') ? 'page' : 'false' }}">Compress</a>
         </nav>
        <button
            @click="mobileOpen = !mobileOpen"
            :aria-expanded="mobileOpen"
            aria-controls="mobile-menu"
            aria-label="Toggle navigation"
            class="flex h-9 w-9 items-center justify-center rounded-lg text-white/70 sm:hidden"
        >
            <span class="icon-[mdi--menu] text-xl"></span>
        </button>
    </div>
    <div
        id="mobile-menu"
        x-show="mobileOpen"
        x-cloak
        @click.outside="mobileOpen = false"
        @keydown.escape.window="mobileOpen = false"
        role="dialog"
        aria-label="Mobile navigation"
        class="border-t border-white/10 bg-slate-900 px-4 py-3 sm:hidden"
    >
        <nav aria-label="Mobile navigation" class="flex flex-col gap-2">
            <a href="{{ route('converter.index') }}" @class(['rounded-lg px-3 py-2 text-sm font-medium transition', 'bg-white/10 text-white' => request()->routeIs('converter.index'), 'text-white/70 hover:bg-white/10 hover:text-white' => !request()->routeIs('converter.index')]) aria-current="{{ request()->routeIs('converter.index') ? 'page' : 'false' }}">Converter</a>
            <a href="{{ route('resizer.index') }}" @class(['rounded-lg px-3 py-2 text-sm font-medium transition', 'bg-white/10 text-white' => request()->routeIs('resizer.index'), 'text-white/70 hover:bg-white/10 hover:text-white' => !request()->routeIs('resizer.index')]) aria-current="{{ request()->routeIs('resizer.index') ? 'page' : 'false' }}">Resize</a>
            <a href="{{ route('compressor.index') }}" @class(['rounded-lg px-3 py-2 text-sm font-medium transition', 'bg-white/10 text-white' => request()->routeIs('compressor.index'), 'text-white/70 hover:bg-white/10 hover:text-white' => !request()->routeIs('compressor.index')]) aria-current="{{ request()->routeIs('compressor.index') ? 'page' : 'false' }}">Compress</a>
        </nav>
    </div>
</header>
