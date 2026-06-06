# ImageForge Project Guide

## Tech Stack

- **Framework**: Laravel 13
- **PHP**: ^8.5.6
- **Frontend**: Livewire 4 (Volt), Alpine.js, Tailwind CSS v4
- **Icons**: @iconify/tailwind4 (use `icon-[collection--name]` classes)
- **Build**: Vite with @tailwindcss/vite

## Architecture

### Livewire Components (`new class extends Component`)

All interactive UI uses Livewire 4's class-based multi-file components with PHP class + Blade template in the same directory.

**Directory pattern:**
- Pages: `resources/views/pages/{section}/{route-name}/⚡{action}/`
- Components: `resources/views/components/{section}/⚡{component-name}/`
- Each component directory has `{name}.php` (class) + `{name}.blade.php` (template)

**Component example:**
```blade
<?php

use Livewire\Component;

new class extends Component
{
    public string $property = '';

    public function save(): void
    {
        //
    }
};
?>
<div x-data="exampleData()">
    {{-- HTML --}}
</div>

@script
    <script>
        Alpine.data('exampleData', () => ({
            
        }))
    </script>
@endscript
```

**Alpine.js** is used for client-side interactivity (modals, dropdowns, toggles) via `x-data`, `x-show`, `@click`, etc.

### Layouts

- `layouts/app.blade.php` — Default layout with navbar and slot
- `layouts/user.blade.php` — User settings layout with sidebar + navbar + slot
- `layouts/auth.blade.php` — Authentication layout

Use `#[Layout('layouts::user')]` attribute on Livewire component classes to specify a layout.

## Enums

### `App\Enums\Post\VisibilityType` (backed int)
- `PUBLIC = 1`
- `PRIVATE = 2`
- `FRIENDS = 3`

Use integer values in `wire:model` bindings: `value="1"`, compare with `$visibility === 1`.

## Code Rules

1. **No hardcoded hex colors** — always use theme tokens from `@theme` block, if the color didn't you can add it
2. **No JS/Blade comments in output** — don't add code comments
4. **SVG icons** — prefer Lucide-style inline SVGs or `icon-[collection--name]` classes from @iconify
5. **Livewire components** — always use `new class extends Component` syntax
6. **Alpine state** — define in `x-data` inline or in `@script`/`@endscript` blocks with `Alpine.data()`
7. **No concatenated class strings** — use `@class([])` Blade directive for conditional classes
8. **Forms** — use `wire:model` for Livewire binding, `wire:submit` or `wire:click` for actions
