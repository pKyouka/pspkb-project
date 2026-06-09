<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $settings['website_name'] ?? config('app.name', 'PSPKB CMS'))</title>
    <meta name="description" content="@yield('description', $settings['website_description'] ?? '')">
    @yield('seo')
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    @php
        $siteName = $settings['website_name'] ?? config('app.name', 'PSPKB');
        $logo = $settings['logo'] ?? '';
        $instagram = $settings['social_instagram'] ?? '';
        $instagramUrl = $instagram
            ? (\Illuminate\Support\Str::startsWith($instagram, ['http://', 'https://']) ? $instagram : 'https://instagram.com/' . ltrim($instagram, '@'))
            : '';
    @endphp

    <x-frontend.header :settings="$settings" :header-menu="$headerMenu ?? null" />

    <main>
        @yield('content')
    </main>

    <footer class="mt-20 bg-slate-950 text-white">
        <div class="h-1 bg-gradient-to-r from-emerald-600 via-teal-500 to-purple-700"></div>
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-10 md:grid-cols-4">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3">
                        <span class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl bg-white text-sm font-black text-emerald-700">
                            @if($logo)
                                <img src="{{ asset('storage/' . $logo) }}" alt="{{ $siteName }}" class="h-full w-full object-contain p-1.5">
                            @else
                                UN
                            @endif
                        </span>
                        <div>
                            <h3 class="text-xl font-black">{{ $siteName }}</h3>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-300">Aisyiyah Yogyakarta</p>
                        </div>
                    </div>
                    <p class="mt-5 max-w-xl leading-7 text-slate-300">{{ $settings['website_description'] ?? '' }}</p>
                    @if($instagramUrl)
                        <a href="{{ $instagramUrl }}" target="_blank" class="mt-6 inline-flex items-center rounded-full bg-white/10 px-5 py-3 text-sm font-bold text-white ring-1 ring-white/10 transition hover:bg-white/20">Ikuti Instagram →</a>
                    @endif
                </div>

                <div>
                    <h4 class="mb-4 text-sm font-black uppercase tracking-widest text-emerald-300">Kontak</h4>
                    <ul class="space-y-3 text-sm leading-6 text-slate-300">
                        @if(!empty($settings['contact_email']))<li>📧 {{ $settings['contact_email'] }}</li>@endif
                        @if(!empty($settings['contact_phone']))<li>📞 {{ $settings['contact_phone'] }}</li>@endif
                        @if(!empty($settings['contact_address']))<li>📍 {{ $settings['contact_address'] }}</li>@endif
                    </ul>
                </div>

                <div>
                    <h4 class="mb-4 text-sm font-black uppercase tracking-widest text-emerald-300">Tautan</h4>
                    <ul class="space-y-3 text-sm text-slate-300">
                        <li><a href="{{ route('home') }}" class="hover:text-white">Beranda</a></li>
                        <li><a href="{{ route('posts.index') }}" class="hover:text-white">Berita</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white">Kontak</a></li>
                        <li><a href="{{ route('search') }}" class="hover:text-white">Pencarian</a></li>
                        @if(isset($footerMenu) && $footerMenu)
                            @foreach($footerMenu->items as $item)
                                <li><a href="{{ $item->url }}" class="hover:text-white">{{ $item->title }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

            <div class="mt-10 border-t border-white/10 pt-6 text-center text-sm text-slate-400">
                &copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>