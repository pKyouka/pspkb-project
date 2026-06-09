@props([
    'settings' => [],
    'headerMenu' => null,
])

@php
    $siteName = $settings['website_name'] ?? config('app.name', 'PSPKB');
    $logo = $settings['logo'] ?? '';
    $instagram = $settings['social_instagram'] ?? '';
    $instagramUrl = $instagram
        ? (\Illuminate\Support\Str::startsWith($instagram, ['http://', 'https://']) ? $instagram : 'https://instagram.com/' . ltrim($instagram, '@'))
        : '';

    $navBase = 'inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold transition-colors duration-200';
    $navIdle = 'text-slate-700 hover:bg-emerald-50 hover:text-emerald-700';
    $navActive = 'bg-emerald-600 text-white shadow-sm shadow-emerald-200';

    $mobileBase = 'block rounded-2xl px-4 py-3 text-sm font-semibold transition-colors duration-200';
    $mobileIdle = 'text-slate-700 hover:bg-emerald-50 hover:text-emerald-700';
    $mobileActive = 'bg-emerald-600 text-white';

    $menuIsActive = function ($url) {
        $path = ltrim(parse_url($url, PHP_URL_PATH) ?: $url, '/');

        return request()->fullUrlIs(url($url))
            || request()->url() === url($url)
            || ($path !== '' && request()->is($path, $path . '/*'));
    };
@endphp

<header x-data="{ open: false }" class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur">
    <div class="mx-auto flex min-h-20 max-w-7xl items-center justify-between gap-5 px-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3">
            <span class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-emerald-600 text-sm font-black text-white shadow-sm">
                @if($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="{{ $siteName }}" class="h-full w-full object-contain bg-white p-1.5">
                @else
                    UN
                @endif
            </span>
            <span class="min-w-0">
                <span class="block truncate text-lg font-black leading-tight tracking-tight text-slate-950">{{ $siteName }}</span>
                <span class="block text-xs font-bold uppercase tracking-[0.2em] text-emerald-700">Aisyiyah Yogyakarta</span>
            </span>
        </a>

        <nav class="hidden items-center gap-1 lg:flex">
            <a href="{{ route('home') }}" class="{{ $navBase }} {{ request()->routeIs('home') ? $navActive : $navIdle }}">Beranda</a>
            <a href="{{ route('posts.index') }}" class="{{ $navBase }} {{ request()->routeIs('posts.*') ? $navActive : $navIdle }}">Berita</a>
            <a href="{{ route('contact') }}" class="{{ $navBase }} {{ request()->routeIs('contact') ? $navActive : $navIdle }}">Kontak</a>

            @if($headerMenu)
                @foreach($headerMenu->items as $item)
                    <a href="{{ $item->url }}" class="{{ $navBase }} {{ $menuIsActive($item->url) ? $navActive : $navIdle }}">{{ $item->title }}</a>
                @endforeach
            @endif
        </nav>

        <div class="hidden items-center gap-3 lg:flex">
            <form action="{{ route('search') }}" method="GET" class="flex overflow-hidden rounded-full border border-slate-200 bg-slate-50 transition focus-within:border-emerald-500 focus-within:bg-white">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita..." class="w-48 border-0 bg-transparent px-4 py-2.5 text-sm outline-none focus:ring-0">
                <button type="submit" class="bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-emerald-700">Cari</button>
            </form>

            @if($instagramUrl)
                <a href="{{ $instagramUrl }}" target="_blank" class="rounded-full border border-purple-200 px-4 py-2.5 text-sm font-bold text-purple-700 transition hover:bg-purple-700 hover:text-white">Instagram</a>
            @endif
        </div>

        <button type="button" class="rounded-2xl border border-slate-200 p-2.5 text-slate-700 transition hover:bg-slate-50 lg:hidden" @click="open = !open" aria-label="Toggle menu">
            <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.25" d="M4 7h16M4 12h16M4 17h16"/></svg>
            <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.25" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <div x-show="open" x-cloak x-transition class="border-t border-slate-100 bg-white px-4 pb-5 sm:px-6 lg:hidden">
        <nav class="mx-auto mt-4 max-w-7xl space-y-1">
            <a href="{{ route('home') }}" class="{{ $mobileBase }} {{ request()->routeIs('home') ? $mobileActive : $mobileIdle }}">Beranda</a>
            <a href="{{ route('posts.index') }}" class="{{ $mobileBase }} {{ request()->routeIs('posts.*') ? $mobileActive : $mobileIdle }}">Berita</a>
            <a href="{{ route('contact') }}" class="{{ $mobileBase }} {{ request()->routeIs('contact') ? $mobileActive : $mobileIdle }}">Kontak</a>

            @if($headerMenu)
                @foreach($headerMenu->items as $item)
                    <a href="{{ $item->url }}" class="{{ $mobileBase }} {{ $menuIsActive($item->url) ? $mobileActive : $mobileIdle }}">{{ $item->title }}</a>
                @endforeach
            @endif
        </nav>

        <form action="{{ route('search') }}" method="GET" class="mx-auto mt-4 flex max-w-7xl overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita..." class="min-w-0 flex-1 border-0 bg-transparent px-4 py-3 text-sm outline-none focus:ring-0">
            <button type="submit" class="bg-emerald-600 px-5 py-3 text-sm font-bold text-white">Cari</button>
        </form>
    </div>
</header>