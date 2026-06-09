<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - {{ config('app.name', 'PSPKB CMS') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }

        body {
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, .12), transparent 32rem),
                radial-gradient(circle at top right, rgba(14, 165, 233, .10), transparent 28rem),
                #f5f7fb;
        }

        .admin-shell {
            color: #0f172a;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .admin-sidebar {
            background:
                linear-gradient(180deg, rgba(15, 23, 42, .98), rgba(30, 41, 59, .98)),
                radial-gradient(circle at 30% 0%, rgba(37, 99, 235, .28), transparent 16rem);
            box-shadow: 18px 0 45px rgba(15, 23, 42, .18);
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
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            box-shadow: 0 12px 24px rgba(37, 99, 235, .28);
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
            border: 1px solid rgba(226, 232, 240, .85) !important;
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
            border-color: #dbe3ef !important;
            border-radius: .85rem !important;
            background: #fff !important;
            transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
        }

        main input:focus,
        main select:focus,
        main textarea:focus {
            outline: none !important;
            border-color: #2563eb !important;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .12) !important;
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
            background: #f8fafc;
        }

        main tbody tr {
            transition: background .15s ease;
        }

        main tbody tr:hover {
            background: #f8fbff !important;
        }

        .ql-toolbar.ql-snow {
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            border-color: #dbe3ef !important;
            background: linear-gradient(180deg, #ffffff, #f8fafc);
        }

        .ql-container.ql-snow {
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
            border-color: #dbe3ef !important;
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
            box-shadow: 0 10px 24px rgba(37, 99, 235, .18);
        }

        @media (max-width: 1024px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-main {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body class="admin-shell min-h-screen">
    <div class="min-h-screen flex">
        <aside class="admin-sidebar fixed inset-y-0 left-0 z-40 w-72 overflow-y-auto text-white">
            <div class="px-5 pb-4 pt-5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="grid h-11 w-11 place-items-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 text-lg font-black shadow-lg shadow-blue-900/30">
                        P
                    </div>
                    <div>
                        <h1 class="text-lg font-black tracking-tight">{{ config('app.name', 'PSPKB CMS') }}</h1>
                        <p class="text-xs font-medium text-slate-400">Admin Panel</p>
                    </div>
                </a>
            </div>

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
                    Berita
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
        </aside>

        <div class="admin-main flex-1 ml-72">
            <header class="sticky top-0 z-30 border-b border-white/70 bg-white/80 px-8 py-4 shadow-sm backdrop-blur-xl">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[.22em] text-blue-600">Admin Workspace</p>
                        <div class="mt-1 text-xl font-black tracking-tight text-slate-900">
                            @hasSection('header')
                                @yield('header')
                            @else
                                @yield('title', 'Dashboard')
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-200 hover:text-blue-700 hover:shadow-md">
                            <span>🌐</span>
                            Lihat Website
                        </a>

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="inline-flex items-center gap-3 rounded-full border border-slate-200 bg-white py-1.5 pl-2 pr-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:shadow-md">
                                <span class="grid h-8 w-8 place-items-center rounded-full bg-gradient-to-br from-blue-600 to-cyan-400 text-xs font-black text-white">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                                {{ auth()->user()->name }}
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

            <main class="p-8">
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