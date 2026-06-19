@props([
    'url' => 'https://pmb.unisayogya.ac.id',
    'logo' => 'images/logo-unisayogya.png',
])

@php
    $logoUrl = $logo ? asset($logo) : null;
@endphp

<a
    href="{{ $url }}"
    class="group fixed bottom-5 right-5 z-40 flex max-w-[calc(100vw-2.5rem)] items-center gap-3 rounded-full border border-white/70 bg-white/95 p-2 pr-4 text-slate-950 shadow-[0_18px_50px_rgba(15,23,42,.18)] backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-[0_24px_60px_rgba(0,168,89,.24)] focus:outline-none focus:ring-4 focus:ring-emerald-100 sm:bottom-7 sm:right-7 sm:pr-5"
    aria-label="Daftar PMB Universitas Aisyiyah Yogyakarta"
>
    <span class="relative grid h-12 w-12 shrink-0 place-items-center overflow-hidden rounded-full bg-white p-1.5 text-white shadow-lg shadow-emerald-500/20 ring-1 ring-emerald-200 transition duration-300 group-hover:scale-105 sm:h-14 sm:w-14">
        @if($logoUrl)
            <img src="{{ $logoUrl }}" alt="Logo UNISA Yogyakarta" class="h-full w-full object-contain">
        @else
            <span class="absolute inset-0 bg-[radial-gradient(circle_at_30%_25%,rgba(255,255,255,.5),transparent_34%)]"></span>
            <svg class="relative h-6 w-6 sm:h-7 sm:w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.75v10.5m5.25-5.25H6.75" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7.5 4.75h9A2.25 2.25 0 0 1 18.75 7v10A2.25 2.25 0 0 1 16.5 19.25h-9A2.25 2.25 0 0 1 5.25 17V7A2.25 2.25 0 0 1 7.5 4.75Z" />
            </svg>
        @endif
    </span>

    <span class="min-w-0">
        <span class="block text-[11px] font-semibold uppercase tracking-[0.18em] text-emerald-500">PMB Unisa</span>
        <span class="mt-0.5 flex items-center gap-2 text-sm font-bold leading-tight text-slate-950 sm:text-[15px]">
            Mau daftar? Klik di sini
            <svg class="h-4 w-4 shrink-0 -rotate-45 text-emerald-500 transition duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6" />
            </svg>
        </span>
    </span>
</a>
