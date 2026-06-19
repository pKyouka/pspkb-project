<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head', ['title' => 'Masuk Admin Unit Layanan Disabilitas'])
</head>
<body class="min-h-screen bg-[#edf2ee] text-slate-900 antialiased">
    @php
        $loginWebsiteName = \App\Models\Setting::getValue('website_name', 'Unit Layanan Disabilitas') ?: 'Unit Layanan Disabilitas';
        $loginLogo = trim((string) \App\Models\Setting::getValue('logo', ''));
        $loginLogoUrl = $loginLogo !== '' && \Illuminate\Support\Facades\Storage::disk('public')->exists($loginLogo)
            ? asset('storage/' . $loginLogo)
            : null;
    @endphp

    <main class="relative min-h-screen overflow-hidden p-4 sm:p-6 lg:p-8">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -left-24 -top-28 h-80 w-80 rounded-full bg-emerald-300/25 blur-3xl"></div>
            <div class="absolute -bottom-32 right-0 h-96 w-96 rounded-full bg-emerald-700/15 blur-3xl"></div>
        </div>

        <div class="relative mx-auto grid min-h-[calc(100vh-2rem)] max-w-[1440px] overflow-hidden rounded-[2rem] bg-white shadow-[0_30px_90px_rgba(15,23,42,.14)] sm:min-h-[calc(100vh-3rem)] lg:grid-cols-[1.05fr_.95fr]">
            <section class="relative hidden overflow-hidden bg-emerald-950 p-10 text-white lg:flex lg:flex-col lg:justify-between xl:p-14">
                <div class="pspkb-auth-pattern absolute inset-0" aria-hidden="true"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-950/30 via-transparent to-slate-950/60"></div>

                <a href="{{ route('home') }}" class="relative z-10 flex w-fit items-center gap-3">
                    <span class="grid h-12 w-12 shrink-0 place-items-center overflow-hidden rounded-2xl bg-white text-emerald-800 shadow-lg">
                        @if($loginLogoUrl)
                            <img src="{{ $loginLogoUrl }}" alt="{{ $loginWebsiteName }}" class="h-full w-full object-contain p-1.5">
                        @else
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="4.5" r="2" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 7.5v6m0 0 4 5m-4-5-4 5m-3-7h14"/></svg>
                        @endif
                    </span>
                    <span>
                        <span class="block text-lg font-semibold">{{ $loginWebsiteName }}</span>
                        <span class="mt-0.5 block text-[10px] font-semibold uppercase tracking-[0.22em] text-emerald-300">Universitas 'Aisyiyah Yogyakarta</span>
                    </span>
                </a>

                <div class="relative z-10 max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-emerald-300">Ruang Kerja Unit Layanan Disabilitas</p>
                    <h1 class="mt-5 text-[clamp(2.75rem,5vw,5.3rem)] font-medium leading-[.96] tracking-[-0.055em]">
                        Kelola layanan untuk kampus yang lebih inklusif.
                    </h1>
                    <p class="mt-6 max-w-xl text-base leading-7 text-emerald-100/80">
                        Masuk ke panel administrasi untuk mengelola informasi, layanan, banner, berita, dan konten Unit Layanan Disabilitas.
                    </p>
                </div>

                <div class="relative z-10 flex items-center justify-between border-t border-white/15 pt-6 text-xs text-emerald-100/70">
                    <span>Akses internal pengelola Unit Layanan Disabilitas</span>
                    <span>{{ date('Y') }}</span>
                </div>
            </section>

            <section class="flex items-center justify-center px-5 py-10 sm:px-10 lg:px-14 xl:px-20">
                <div class="w-full max-w-md">
                    <div class="mb-10 flex items-center justify-between lg:hidden">
                        <a href="{{ route('home') }}" class="flex items-center gap-3">
                            <span class="grid h-11 w-11 shrink-0 place-items-center overflow-hidden rounded-xl bg-white text-emerald-800 shadow-sm ring-1 ring-emerald-100">
                                @if($loginLogoUrl)
                                    <img src="{{ $loginLogoUrl }}" alt="{{ $loginWebsiteName }}" class="h-full w-full object-contain p-1.5">
                                @else
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="4.5" r="2" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 7.5v6m0 0 4 5m-4-5-4 5m-3-7h14"/></svg>
                                @endif
                            </span>
                            <span>
                                <span class="block text-sm font-semibold">{{ $loginWebsiteName }}</span>
                                <span class="block text-[9px] font-semibold uppercase tracking-[0.18em] text-emerald-700">Universitas 'Aisyiyah Yogyakarta</span>
                            </span>
                        </a>
                    </div>

                    <a href="{{ route('home') }}" class="mb-10 hidden w-fit items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-emerald-700 lg:inline-flex">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m15 18-6-6 6-6"/></svg>
                        Kembali ke website
                    </a>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700">Admin Unit Layanan Disabilitas</p>
                        <h2 class="mt-3 text-4xl font-semibold tracking-[-0.04em] text-slate-950">Selamat datang</h2>
                        <p class="mt-3 text-sm leading-6 text-slate-500">Masukkan email dan kata sandi akun pengelola Anda.</p>
                    </div>

                    <x-auth-session-status class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-left" :status="session('status')" />

                    @if($errors->any())
                        <div class="mt-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700" role="alert">
                            Email atau kata sandi tidak sesuai. Silakan periksa kembali.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Alamat email</label>
                            <input
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                type="email"
                                required
                                autofocus
                                autocomplete="email"
                                placeholder="nama@unisayogya.ac.id"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100"
                            >
                            @error('email')<p class="mt-2 text-xs font-medium text-rose-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between gap-4">
                                <label for="password" class="block text-sm font-semibold text-slate-700">Kata sandi</label>
                                @if(Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-emerald-700 transition hover:text-emerald-900">Lupa kata sandi?</a>
                                @endif
                            </div>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan kata sandi"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100"
                            >
                        </div>

                        <label class="group flex w-fit cursor-pointer items-center gap-3 text-sm font-medium text-slate-600">
                            <span class="relative grid h-5 w-5 shrink-0 place-items-center">
                                <input name="remember" type="checkbox" value="1" {{ old('remember') ? 'checked' : '' }} class="peer absolute inset-0 h-full w-full cursor-pointer appearance-none rounded-md border border-slate-300 bg-white transition checked:border-emerald-700 checked:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-100">
                                <svg class="pointer-events-none relative h-3.5 w-3.5 scale-75 text-white opacity-0 transition peer-checked:scale-100 peer-checked:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m5 12 4 4L19 6"/></svg>
                            </span>
                            <span class="transition group-hover:text-slate-900">Ingat saya di perangkat ini</span>
                        </label>

                        <button type="submit" data-test="login-button" class="group flex w-full items-center justify-between rounded-xl bg-emerald-700 px-5 py-3.5 text-sm font-semibold text-white shadow-[0_12px_30px_rgba(4,120,87,.22)] transition hover:bg-emerald-800 focus:outline-none focus:ring-4 focus:ring-emerald-200">
                            <span>Masuk ke dashboard</span>
                            <span class="grid h-7 w-7 place-items-center rounded-full bg-white/15 transition group-hover:translate-x-0.5">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                            </span>
                        </button>
                    </form>

                    <p class="mt-8 text-center text-xs leading-5 text-slate-400">
                        Halaman ini hanya diperuntukkan bagi pengelola resmi Unit Layanan Disabilitas.
                    </p>
                </div>
            </section>
        </div>
    </main>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
</body>
</html>
