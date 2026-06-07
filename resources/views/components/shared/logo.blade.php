<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5']) }}>
    <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 shrink-0">
        <rect width="32" height="32" rx="7" fill="url(--logo-bg)"/>
        <path d="M5 24 L11 13 L15 18 L19 10 L27 24Z" fill="white" fill-opacity="0.92"/>
        <path d="M19 10 L21 7 L23 10Z" fill="url(--logo-spark)"/>
        <path d="M21 4.5 C21 4.5 23 7 23 8.5 C23 10 21 10.8 21 10.8 C21 10.8 19 10 19 8.5 C19 7 21 4.5 21 4.5Z" fill="url(--logo-spark)"/>
        <defs>
            <linearGradient id="--logo-bg" x1="0" y1="0" x2="32" y2="32">
                <stop stop-color="#4338CA"/>
                <stop offset="1" stop-color="#312E81"/>
            </linearGradient>
            <linearGradient id="--logo-spark" x1="19" y1="4.5" x2="23" y2="10.8">
                <stop stop-color="#FCD34D"/>
                <stop offset="1" stop-color="#FB923C"/>
            </linearGradient>
        </defs>
    </svg>
    <span class="text-lg font-semibold tracking-tight">Image Forge</span>
</span>
