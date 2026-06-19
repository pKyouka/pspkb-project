@extends('layouts.frontend')

@section('title', $page->meta_title ?: $page->title)
@section('description', $page->meta_description ?? '')

@section('content')
<article>
    <section class="pspkb-page-hero relative flex overflow-hidden bg-[#f1f2ef]">
        <div class="pspkb-hero-glow" aria-hidden="true"></div>
        <div class="pspkb-ribbons" aria-hidden="true">
            <span></span><span></span><span></span><span></span><span></span><span></span>
        </div>
        <div class="pspkb-grain" aria-hidden="true"></div>

        <div class="relative z-10 mx-auto flex w-full max-w-[1440px] flex-col justify-end px-5 pb-14 pt-32 sm:px-8 sm:pb-16 lg:px-12 lg:pb-20">
            <nav class="mb-7 flex items-center gap-2 text-xs font-medium text-slate-500">
                <a href="{{ route('home') }}" class="transition hover:text-emerald-700">{{ __('frontend.common.home') }}</a>
                <span>/</span>
                <span class="text-slate-800">{{ $page->title }}</span>
            </nav>
            <div class="flex items-center gap-3">
                <span class="grid h-7 w-7 place-items-center rounded-full bg-slate-950 text-xs font-semibold text-white">1</span>
                <span class="rounded-full border border-slate-300 bg-white/40 px-4 py-1.5 text-xs font-medium text-slate-700 backdrop-blur">{{ __('frontend.page.label') }}</span>
            </div>
            <h1 class="mt-7 max-w-5xl text-[clamp(2.75rem,7vw,5.8rem)] font-medium leading-[.98] tracking-[-0.055em] text-slate-950">{{ $page->title }}</h1>
            @if($page->meta_description)
                <p class="mt-7 max-w-2xl text-base leading-7 text-slate-600 sm:text-lg">{{ $page->meta_description }}</p>
            @endif
        </div>
    </section>

    <section class="bg-white py-16 sm:py-20 lg:py-28">
        <div class="mx-auto max-w-[1440px] px-5 sm:px-8 lg:px-12">
            @if($page->featured_image)
                <div class="mb-16 overflow-hidden rounded-2xl lg:mb-24">
                    <img src="{{ asset('storage/' . $page->featured_image) }}" class="aspect-[16/7] w-full object-cover" alt="{{ $page->title }}">
                </div>
            @else
                <div class="mb-16 grid overflow-hidden rounded-2xl bg-[#dce9e2] lg:mb-24 lg:grid-cols-[1fr_42%]">
                    <div class="flex min-h-72 flex-col justify-between p-8 sm:p-10">
                        <span class="grid h-12 w-12 place-items-center rounded-full bg-[#00c46a] text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 3 2.5 8 12 13l9.5-5L12 3Zm-6 7.1V16l6 3 6-3v-5.9M21.5 8v6"/></svg>
                        </span>
                        <p class="mt-12 max-w-2xl text-2xl font-medium leading-tight tracking-tight text-slate-950 sm:text-4xl">{{ __('frontend.page.equal_access') }}</p>
                    </div>
                    <div class="pspkb-photo-placeholder min-h-72"></div>
                </div>
            @endif

            <div class="grid gap-10 lg:grid-cols-[240px_1fr] lg:gap-20">
                <aside class="lg:sticky lg:top-28 lg:self-start">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">{{ __('frontend.page.unit_profile') }}</p>
                    <a href="{{ route('contact') }}" class="group mt-7 inline-flex items-center gap-3 text-sm font-semibold text-slate-900">
                        {{ __('frontend.common.contact_uld') }}
                        <span class="grid h-8 w-8 place-items-center rounded-full border border-slate-300 transition group-hover:bg-slate-950 group-hover:text-white">
                            <svg class="h-4 w-4 -rotate-45 transition-transform duration-300 group-hover:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                        </span>
                    </a>
                </aside>

                <div class="pspkb-prose">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </section>

    <section class="bg-emerald-800 px-5 py-8 text-white sm:px-8 lg:px-12">
        <div class="mx-auto flex max-w-[1440px] flex-col items-start justify-between gap-8 py-10 md:flex-row md:items-center">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-200">{{ __('frontend.common.inclusive_campus') }}</p>
                <h2 class="mt-3 max-w-3xl text-3xl font-medium leading-tight tracking-[-0.035em] sm:text-5xl">{{ __('frontend.page.together') }}</h2>
            </div>
            <a href="{{ route('contact') }}" class="group inline-flex items-center gap-4 rounded-full bg-white py-2 pl-6 pr-2 text-sm font-semibold text-emerald-900">
                {{ __('frontend.common.contact_uld') }}
                <span class="grid h-9 w-9 place-items-center rounded-full bg-emerald-100">
                    <svg class="h-4 w-4 -rotate-45 transition-transform duration-500 group-hover:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </span>
            </a>
        </div>
    </section>
</article>
@endsection
