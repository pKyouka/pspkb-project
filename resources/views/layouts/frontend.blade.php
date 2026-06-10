<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', __('frontend.site_name').' | '.__('frontend.university'))</title>
    <meta name="description" content="@yield('description', $settings['website_description'] ?? '')">
    @yield('seo')
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #google_translate_element,
        .goog-te-banner-frame,
        .goog-te-balloon-frame,
        .goog-logo-link,
        .goog-te-gadget {
            display: none !important;
        }

        body {
            top: 0 !important;
        }

        iframe.skiptranslate {
            display: none !important;
        }
    </style>
</head>
<body class="bg-[#f1f2ef] text-slate-800 antialiased">
    @php
        $siteName = __('frontend.site_name');
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

    <footer class="bg-slate-950 text-white">
        <div class="mx-auto max-w-[1440px] px-5 py-14 sm:px-8 lg:px-12 lg:py-20">
            <div class="grid grid-cols-1 gap-10 md:grid-cols-4">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3">
                        <span class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl bg-white text-sm font-black text-emerald-700">
                            @if($logo)
                                <img src="{{ asset('storage/' . $logo) }}" alt="{{ $siteName }}" class="h-full w-full object-contain p-1.5">
                            @else
                                ULD
                            @endif
                        </span>
                        <div>
                            <h3 class="text-xl font-semibold">{{ $siteName }}</h3>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-300">{{ __('frontend.university') }}</p>
                        </div>
                    </div>
                    <p class="mt-5 max-w-xl leading-7 text-slate-300">{{ __('frontend.footer.description') }}</p>
                    @if($instagramUrl)
                        <a href="{{ $instagramUrl }}" target="_blank" class="mt-6 inline-flex items-center rounded-full bg-white/10 px-5 py-3 text-sm font-bold text-white ring-1 ring-white/10 transition hover:bg-white/20">{{ __('frontend.footer.follow_instagram') }} →</a>
                    @endif
                </div>

                <div>
                    <h4 class="mb-4 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-300">{{ __('frontend.footer.contact') }}</h4>
                    <ul class="space-y-3 text-sm leading-6 text-slate-300">
                        @if(!empty($settings['contact_email']))<li>📧 {{ $settings['contact_email'] }}</li>@endif
                        @if(!empty($settings['contact_phone']))<li>📞 {{ $settings['contact_phone'] }}</li>@endif
                        @if(!empty($settings['contact_address']))<li>📍 {{ $settings['contact_address'] }}</li>@endif
                    </ul>
                </div>

                <div>
                    <h4 class="mb-4 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-300">{{ __('frontend.footer.links') }}</h4>
                    <ul class="space-y-3 text-sm text-slate-300">
                        <li><a href="{{ route('pages.show', 'profil-uld-dan-struktur') }}" class="hover:text-white">{{ __('frontend.nav.profile') }}</a></li>
                        <li><a href="{{ route('posts.index') }}" class="hover:text-white">{{ __('frontend.nav.news') }}</a></li>
                        <li><a href="{{ route('activities.index') }}" class="hover:text-white">{{ __('frontend.nav.activities') }}</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white">{{ __('frontend.nav.contact') }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 border-t border-white/10 pt-6 text-center text-sm text-slate-400">
                &copy; {{ date('Y') }} {{ $siteName }}. {{ __('frontend.footer.rights') }}
            </div>
        </div>
    </footer>

    <div id="google_translate_element" aria-hidden="true"></div>
    <script>
        window.googleTranslateElementInit = function () {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'id,en',
                autoDisplay: false,
            }, 'google_translate_element');

            window.syncGoogleLanguageButtons();
        };

        window.currentGoogleLanguage = function () {
            const match = document.cookie.match(/(?:^|;\s*)googtrans=\/id\/([^;]+)/);
            return match ? match[1] : 'id';
        };

        window.syncGoogleLanguageButtons = function () {
            const activeLanguage = window.currentGoogleLanguage();

            document.querySelectorAll('.google-lang-button').forEach((button) => {
                const isActive = button.dataset.googleLang === activeLanguage;
                button.classList.toggle('bg-slate-950', isActive);
                button.classList.toggle('text-white', isActive);
                button.classList.toggle('text-slate-500', !isActive);
            });
        };

        window.setGoogleLanguage = function (language) {
            const hostname = window.location.hostname;
            const expires = language === 'id' ? 'Thu, 01 Jan 1970 00:00:00 GMT' : 'Fri, 31 Dec 9999 23:59:59 GMT';
            const value = language === 'id' ? '' : `/id/${language}`;

            document.cookie = `googtrans=${value}; path=/; expires=${expires}; SameSite=Lax`;

            if (hostname.includes('.')) {
                document.cookie = `googtrans=${value}; path=/; domain=.${hostname}; expires=${expires}; SameSite=Lax`;
            }

            window.location.reload();
        };

        document.addEventListener('DOMContentLoaded', window.syncGoogleLanguageButtons);
    </script>
    <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async></script>

    @stack('scripts')
</body>
</html>
