<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - {{ config('app.name', 'PSPKB CMS') }}</title>
    @include('partials.favicon')
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --admin-emerald: #047857;
            --admin-emerald-dark: #065f46;
            --admin-ink: #0f172a;
            --admin-line: #dce5df;
        }

        [x-cloak] { display: none !important; }

        body {
            background:
                radial-gradient(circle at top left, rgba(16, 185, 129, .13), transparent 32rem),
                radial-gradient(circle at top right, rgba(148, 210, 190, .20), transparent 30rem),
                #f1f3ef;
        }

        .admin-shell {
            color: var(--admin-ink);
            font-family: "Instrument Sans", ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .admin-sidebar {
            background:
                radial-gradient(circle at 25% 0%, rgba(52, 211, 153, .20), transparent 18rem),
                linear-gradient(165deg, #16251f 0%, #0f172a 72%);
            box-shadow: 0 24px 65px rgba(15, 23, 42, .20);
            display: flex;
            flex-direction: column;
            isolation: isolate;
            overflow: hidden;
            transition: transform .25s ease;
        }

        .admin-sidebar-scroll {
            flex: 1 1 auto;
            min-height: 0;
            margin: 0 .55rem .75rem 0;
            overscroll-behavior: contain;
            scrollbar-color: rgba(148, 163, 184, .42) transparent;
            scrollbar-width: thin;
        }

        .admin-sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .admin-sidebar-scroll::-webkit-scrollbar-track {
            margin-block: .75rem;
            background: transparent;
        }

        .admin-sidebar-scroll::-webkit-scrollbar-thumb {
            min-height: 3rem;
            border-radius: 999px;
            background: rgba(148, 163, 184, .42);
        }

        .admin-sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(52, 211, 153, .72);
        }

        .admin-sidebar-scroll::-webkit-scrollbar-button,
        .admin-sidebar-scroll::-webkit-scrollbar-button:single-button,
        .admin-sidebar-scroll::-webkit-scrollbar-corner {
            appearance: none;
            display: block;
            width: 0;
            height: 0;
            background: transparent;
        }

        .admin-nav-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: .8rem;
            margin: .12rem .75rem;
            padding: .72rem .85rem;
            border-radius: .95rem;
            color: #cbd5e1;
            font-size: .9rem;
            font-weight: 600;
            transition: all .18s ease;
        }

        .admin-nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, .08);
            transform: translateX(3px);
        }

        .admin-nav-link.is-active {
            color: #fff;
            background: linear-gradient(135deg, #059669, #047857);
            box-shadow: 0 12px 28px rgba(4, 120, 87, .30);
        }

        .admin-nav-link svg {
            flex: none;
            width: 1.18rem;
            height: 1.18rem;
        }

        .admin-nav-group {
            padding: 1.05rem 1rem .35rem;
            color: #93a4b8;
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .admin-card,
        main > .bg-white {
            border: 1px solid rgba(220, 229, 223, .95) !important;
            border-radius: 1.35rem !important;
            background: rgba(255, 255, 255, .88) !important;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .07) !important;
            backdrop-filter: blur(14px);
        }

        main input[type="text"],
        main input[type="email"],
        main input[type="password"],
        main input[type="number"],
        main input[type="file"],
        main input[type="url"],
        main select,
        main textarea {
            border-color: var(--admin-line) !important;
            border-radius: .85rem !important;
            background: #fff !important;
            transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
        }

        main input:focus,
        main select:focus,
        main textarea:focus {
            outline: none !important;
            border-color: #10b981 !important;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, .13) !important;
        }

        main label {
            color: #334155 !important;
            font-weight: 700 !important;
        }

        main table {
            overflow: hidden;
            border-radius: 1rem;
        }

        main thead {
            background: #f3f7f4;
        }

        main tbody tr {
            transition: background .15s ease;
        }

        main tbody tr:hover {
            background: #f7faf8 !important;
        }

        .ql-toolbar.ql-snow {
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            border-color: var(--admin-line) !important;
            background: linear-gradient(180deg, #ffffff, #f3f7f4);
        }

        .ql-container.ql-snow {
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
            border-color: var(--admin-line) !important;
            min-height: 26rem;
            background: #fff;
        }

        .ql-editor {
            font-size: 1rem;
            line-height: 1.75;
            padding: 1.45rem !important;
        }

        .btn-primary,
        main a[href*="/create"],
        main button[type="submit"] {
            border-radius: .9rem !important;
            box-shadow: 0 10px 24px rgba(4, 120, 87, .18);
        }

        .admin-topbar {
            border: 1px solid rgba(255, 255, 255, .82);
            background: rgba(255, 255, 255, .90);
            box-shadow: 0 14px 38px rgba(15, 23, 42, .08);
            backdrop-filter: blur(20px);
        }

        .admin-main .bg-blue-600,
        .admin-main .bg-blue-700,
        .admin-main .bg-indigo-600,
        .admin-main .bg-sky-600,
        .admin-main .bg-cyan-600 { background-color: var(--admin-emerald) !important; }

        .admin-main .hover\:bg-blue-700:hover,
        .admin-main .hover\:bg-blue-800:hover,
        .admin-main .hover\:bg-indigo-700:hover,
        .admin-main .hover\:bg-sky-700:hover { background-color: var(--admin-emerald-dark) !important; }

        .admin-main .bg-blue-50,
        .admin-main .bg-blue-100,
        .admin-main .bg-indigo-50,
        .admin-main .bg-sky-50,
        .admin-main .bg-cyan-50 { background-color: #ecfdf5 !important; }

        .admin-main .text-blue-600,
        .admin-main .text-blue-700,
        .admin-main .text-blue-800,
        .admin-main .text-indigo-600,
        .admin-main .text-indigo-700,
        .admin-main .text-sky-600,
        .admin-main .text-cyan-600 { color: var(--admin-emerald) !important; }

        .admin-main .border-blue-100,
        .admin-main .border-blue-200,
        .admin-main .border-blue-300,
        .admin-main .border-indigo-100,
        .admin-main .border-indigo-200,
        .admin-main .border-sky-200 { border-color: #a7f3d0 !important; }

        .admin-main .focus\:ring-blue-500:focus,
        .admin-main .focus\:ring-indigo-500:focus { --tw-ring-color: rgba(16, 185, 129, .35) !important; }
    </style>
</head>
<body class="admin-shell min-h-screen" x-data="{ sidebarOpen: false }">
    @php
        $adminWebsiteName = \App\Models\Setting::getValue('website_name', 'Unit Layanan Disabilitas') ?: 'Unit Layanan Disabilitas';
        $adminLogo = trim((string) \App\Models\Setting::getValue('logo', ''));
        $adminLogoUrl = $adminLogo !== '' && \Illuminate\Support\Facades\Storage::disk('public')->exists($adminLogo)
            ? asset('storage/' . $adminLogo)
            : null;
    @endphp

    <div class="min-h-screen flex">
        <div x-cloak x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-950/45 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"></div>

        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-[120%]'"
            class="admin-sidebar fixed inset-y-3 left-3 z-50 w-64 rounded-[2rem] text-white lg:translate-x-0"
        >
            <div class="flex-none px-5 pb-4 pt-5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="grid h-12 w-12 shrink-0 place-items-center overflow-hidden rounded-2xl bg-white text-emerald-800 shadow-lg shadow-emerald-950/30">
                        @if($adminLogoUrl)
                            <img src="{{ $adminLogoUrl }}" alt="{{ $adminWebsiteName }}" class="h-full w-full object-contain p-1.5">
                        @else
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="4.5" r="2" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 7.5v6m0 0 4 5m-4-5-4 5m-3-7h14"/></svg>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <h1 class="max-w-36 text-sm font-black leading-tight tracking-tight">Admin {{ $adminWebsiteName }}</h1>
                        <p class="mt-0.5 text-[10px] font-semibold uppercase tracking-[.14em] text-emerald-300">Universitas 'Aisyiyah</p>
                    </div>
                </a>
            </div>

            <div class="admin-sidebar-scroll overflow-y-auto">
                <nav class="pb-8">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>

                <div class="admin-nav-group">Konten</div>

                <a href="{{ route('admin.pages.index') }}" class="admin-nav-link {{ request()->routeIs('admin.pages.*') ? 'is-active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Halaman
                </a>

                <a href="{{ route('admin.posts.index') }}" class="admin-nav-link {{ request()->routeIs('admin.posts.*') ? 'is-active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    Berita & Artikel
                </a>

                <a href="{{ route('admin.activities.index') }}" class="admin-nav-link {{ request()->routeIs('admin.activities.*') ? 'is-active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"></path></svg>
                    Aktivitas/Kegiatan
                </a>

                <a href="{{ route('admin.categories.index') }}" class="admin-nav-link {{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Kategori
                </a>

                <a href="{{ route('admin.tags.index') }}" class="admin-nav-link {{ request()->routeIs('admin.tags.*') ? 'is-active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Tag
                </a>

                <div class="admin-nav-group">Media</div>

                <a href="{{ route('admin.media.index') }}" class="admin-nav-link {{ request()->routeIs('admin.media.*') ? 'is-active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Media
                </a>

                <a href="{{ route('admin.banners.index') }}" class="admin-nav-link {{ request()->routeIs('admin.banners.*') ? 'is-active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    Banner
                </a>

                <div class="admin-nav-group">Navigasi</div>

                <a href="{{ route('admin.menus.index') }}" class="admin-nav-link {{ request()->routeIs('admin.menus.*') ? 'is-active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    Menu
                </a>

                <div class="admin-nav-group">Sistem</div>

                <a href="{{ route('admin.messages.index') }}" class="admin-nav-link {{ request()->routeIs('admin.messages.*') ? 'is-active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Pesan
                </a>

                @if(auth()->user()->hasRole('super_admin', 'admin'))
                    <a href="{{ route('admin.users.index') }}" class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Pengguna
                    </a>

                    <a href="{{ route('admin.settings.index') }}" class="admin-nav-link {{ request()->routeIs('admin.settings.*') ? 'is-active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Pengaturan
                    </a>
                @endif
                </nav>
            </div>
        </aside>

        <div class="admin-main min-w-0 flex-1 lg:ml-[17.75rem]">
            <header class="admin-topbar sticky top-3 z-30 mx-3 rounded-full px-4 py-3 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="hidden text-[10px] font-bold uppercase tracking-[.18em] text-emerald-700 sm:block">Ruang Kerja Admin Unit Layanan Disabilitas</p>
                        <div class="text-base font-black tracking-tight text-slate-900 sm:mt-1 sm:text-xl">
                            @hasSection('header')
                                @yield('header')
                            @else
                                @yield('title', 'Dashboard')
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="button" @click="sidebarOpen = true" class="grid h-10 w-10 place-items-center rounded-full border border-slate-200 bg-white text-slate-700 lg:hidden" aria-label="Buka menu admin">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>

                        <a href="{{ route('home') }}" target="_blank" class="hidden items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-200 hover:text-emerald-700 hover:shadow-md sm:inline-flex">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 100-18 9 9 0 000 18zm0 0c2.21 0 4-4.03 4-9s-1.79-9-4-9-4 4.03-4 9 1.79 9 4 9zM3.6 9h16.8M3.6 15h16.8"/></svg>
                            Lihat Website
                        </a>

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white py-1.5 pl-2 pr-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:shadow-md sm:gap-3 sm:pr-3">
                                <span class="grid h-8 w-8 place-items-center rounded-full bg-emerald-700 text-xs font-black text-white">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                                <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-cloak x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-3 w-56 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl shadow-slate-900/10">
                                <div class="border-b border-slate-100 px-4 py-3">
                                    <p class="text-sm font-bold text-slate-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full px-4 py-3 text-left text-sm font-semibold text-red-600 hover:bg-red-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="mx-auto max-w-[1600px] p-4 pt-8 sm:p-6 sm:pt-10 lg:p-8 lg:pt-10">
                @if(session('success'))
                    <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-800 shadow-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
