@props([
    'settings' => [],
    'headerMenu' => null,
])

@php
    $siteName = __('frontend.site_name');
    $logo = $settings['logo'] ?? '';
    $headerPosition = request()->routeIs('home') ? 'fixed' : 'sticky';
    $navigation = $headerMenu?->items?->map(fn ($item) => [
        'title' => $item->title,
        'url' => $item->url,
    ])->values() ?? collect();

    if ($navigation->isEmpty()) {
        $navigation = collect([
            ['title' => __('frontend.nav.profile'), 'url' => route('pages.show', 'profil-uld-dan-struktur')],
            ['title' => __('frontend.nav.news'), 'url' => route('posts.index')],
            ['title' => __('frontend.nav.activities'), 'url' => route('activities.index')],
            ['title' => __('frontend.nav.contact'), 'url' => route('contact')],
        ]);
    }

    $isActive = function (string $url): bool {
        $path = ltrim(parse_url($url, PHP_URL_PATH) ?: $url, '/');

        return request()->url() === url($url)
            || ($path !== '' && request()->is($path, $path . '/*'));
    };
@endphp

<header x-data="{ open: false }" class="{{ $headerPosition }} inset-x-0 top-0 z-50 p-2 sm:p-3">
    <div class="mx-auto flex max-w-[1440px] items-center justify-between rounded-full border border-white bg-white p-[5px] shadow-[0_16px_45px_rgba(15,23,42,.12)] ring-1 ring-emerald-100/70">
        <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3">
            <span class="grid h-10 w-10 shrink-0 place-items-center overflow-hidden rounded-full bg-slate-950 text-[10px] font-bold text-white">
                @if($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="{{ $siteName }}" class="h-full w-full bg-white object-contain p-1">
                @else
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="4.5" r="2" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 7.5v6m0 0 4 5m-4-5-4 5m-3-7h14"/></svg>
                @endif
            </span>
            <span class="hidden min-w-0 sm:block">
                <span class="block truncate text-[15px] font-semibold leading-none tracking-tight text-slate-950">{{ $siteName }}</span>
                <span class="mt-1 block text-[9px] font-semibold uppercase tracking-[0.2em] text-emerald-700">{{ __('frontend.university') }}</span>
            </span>
        </a>

        <nav class="hidden items-center gap-1 md:flex">
            @foreach($navigation as $item)
                <a href="{{ $item['url'] }}" class="rounded-full px-3.5 py-2 text-[13px] font-medium transition-colors duration-300 {{ $isActive($item['url']) ? 'bg-[#00c46a] text-white' : 'text-slate-800 hover:bg-emerald-50 hover:text-[#00a859]' }}">
                    {{ $item['title'] }}
                </a>
            @endforeach
        </nav>

        <div class="hidden items-center gap-2 md:flex">
            <div class="google-language-switcher flex h-10 items-center rounded-full border border-emerald-100 bg-white p-1 text-[11px] font-bold shadow-[0_8px_20px_rgba(15,23,42,.08)]" aria-label="Language">
                <button type="button" data-google-lang="id" onclick="window.setGoogleLanguage('id')" class="google-lang-button grid h-8 min-w-8 place-items-center rounded-full bg-slate-950 px-2 text-white transition">ID</button>
                <button type="button" data-google-lang="en" onclick="window.setGoogleLanguage('en')" class="google-lang-button grid h-8 min-w-8 place-items-center rounded-full px-2 text-slate-500 transition hover:text-emerald-700">EN</button>
            </div>

            <form
            action="{{ route('search') }}"
            method="GET"
            x-data="{ searchOpen: {{ request()->routeIs('search') || request()->filled('q') ? 'true' : 'false' }} }"
            @submit="if (!searchOpen) { $event.preventDefault(); searchOpen = true; $nextTick(() => $refs.searchInput.focus()) }"
            @click.outside="if (!$refs.searchInput.value) searchOpen = false"
            :class="searchOpen ? 'w-72 border-emerald-200 bg-white' : 'w-10 border-slate-200 bg-transparent'"
            class="hidden h-10 items-center overflow-hidden rounded-full border transition-[width,background-color,border-color] duration-500 ease-[cubic-bezier(.25,.1,.25,1)] md:flex"
            role="search"
        >
            <input
                x-ref="searchInput"
                x-show="searchOpen"
                x-transition.opacity
                type="search"
                name="q"
                value="{{ request('q') }}"
                placeholder="{{ __('frontend.search.short_placeholder') }}"
                autocomplete="off"
                class="min-w-0 flex-1 border-0 bg-transparent py-2 pl-4 pr-1 text-sm text-slate-900 outline-none placeholder:text-slate-400 focus:ring-0"
                aria-label="{{ __('frontend.search.title') }}"
            >
            <button
                type="submit"
                @click="if (!searchOpen) { $event.preventDefault(); searchOpen = true; $nextTick(() => $refs.searchInput.focus()) }"
                class="grid h-10 w-10 shrink-0 place-items-center rounded-full text-slate-600 transition hover:bg-emerald-50 hover:text-emerald-700"
                aria-label="{{ __('frontend.search.title') }}"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7" stroke-width="1.8"/><path stroke-linecap="round" stroke-width="1.8" d="m20 20-4-4"/></svg>
            </button>
            </form>
        </div>

        <button type="button" class="grid h-10 w-10 place-items-center rounded-full bg-slate-950 text-white md:hidden" @click="open = !open" aria-label="Buka menu">
            <svg x-show="!open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="2" d="M5 8h14M5 16h14"/></svg>
            <svg x-show="open" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="2" d="m6 6 12 12M18 6 6 18"/></svg>
        </button>
    </div>

    <div x-show="open" x-cloak x-transition.opacity class="fixed inset-0 -z-10 bg-slate-950/60 md:hidden" @click="open = false"></div>
    <div x-show="open" x-cloak x-transition:enter="transition duration-500 ease-[cubic-bezier(.32,.72,0,1)]" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0" x-transition:leave="transition duration-300" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full" class="fixed inset-x-3 bottom-3 rounded-3xl bg-white p-6 shadow-2xl md:hidden">
        <div class="mb-5 flex items-center justify-between gap-4">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">{{ __('frontend.nav.label') }}</p>
            <div class="google-language-switcher flex rounded-full border border-slate-200 bg-slate-50 p-1 text-xs font-bold">
                <button type="button" data-google-lang="id" onclick="window.setGoogleLanguage('id')" class="google-lang-button rounded-full bg-slate-950 px-3 py-1.5 text-white">ID</button>
                <button type="button" data-google-lang="en" onclick="window.setGoogleLanguage('en')" class="google-lang-button rounded-full px-3 py-1.5 text-slate-500">EN</button>
            </div>
        </div>
        <form action="{{ route('search') }}" method="GET" class="mb-5 flex h-12 items-center rounded-full border border-slate-200 bg-slate-50 focus-within:border-emerald-300 focus-within:bg-white focus-within:ring-4 focus-within:ring-emerald-50" role="search">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="{{ __('frontend.search.short_placeholder') }}" autocomplete="off" class="min-w-0 flex-1 border-0 bg-transparent py-3 pl-5 pr-2 text-sm text-slate-900 outline-none placeholder:text-slate-400 focus:ring-0" aria-label="{{ __('frontend.search.title') }}">
            <button type="submit" class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-slate-950 text-white" aria-label="{{ __('frontend.search.title') }}">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7" stroke-width="1.8"/><path stroke-linecap="round" stroke-width="1.8" d="m20 20-4-4"/></svg>
            </button>
        </form>
        <nav class="space-y-1">
            @foreach($navigation as $item)
                <a href="{{ $item['url'] }}" class="flex items-center justify-between border-b border-slate-100 py-3 text-xl font-medium tracking-tight {{ $isActive($item['url']) ? 'text-emerald-700' : 'text-slate-950' }}">
                    {{ $item['title'] }}
                    <svg class="h-4 w-4 -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </a>
            @endforeach
        </nav>
        <a href="{{ route('home') }}" class="mt-7 flex items-center justify-between rounded-full bg-[#00c46a] py-2 pl-5 pr-2 text-sm font-semibold text-white">
            {{ __('frontend.nav.back_home') }}
            <span class="grid h-9 w-9 place-items-center rounded-full bg-white text-emerald-800">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 18-6-6 6-6"/></svg>
            </span>
        </a>
    </div>
</header>
