@extends('layouts.frontend')

@section('title', $pageTitle)
@section('description', $pageDescription)

@section('content')
@php
    $isActivityPage = request()->routeIs('activities.index');
@endphp

<section class="pspkb-page-hero relative flex overflow-hidden bg-[#f1f2ef]">
    <div class="pspkb-hero-glow" aria-hidden="true"></div>
    <div class="pspkb-ribbons" aria-hidden="true">
        <span></span><span></span><span></span><span></span><span></span><span></span>
    </div>
    <div class="pspkb-grain" aria-hidden="true"></div>

    <div class="relative z-10 mx-auto flex w-full max-w-[1440px] flex-col justify-end px-5 pb-14 pt-32 sm:px-8 sm:pb-16 lg:px-12 lg:pb-20">
        <div class="flex items-center gap-3">
            <span class="grid h-7 w-7 place-items-center rounded-full bg-slate-950 text-xs font-semibold text-white">{{ $isActivityPage ? '3' : '2' }}</span>
            <span class="rounded-full border border-slate-300 bg-white/40 px-4 py-1.5 text-xs font-medium text-slate-700 backdrop-blur">{{ $pageLabel }}</span>
        </div>
        <h1 class="mt-7 max-w-5xl text-[clamp(2.75rem,7vw,5.8rem)] font-medium leading-[.98] tracking-[-0.055em] text-slate-950">{{ $pageTitle }}</h1>
        <p class="mt-7 max-w-2xl text-base leading-7 text-slate-600 sm:text-lg">{{ $pageDescription }}</p>
    </div>
</section>

<section class="bg-white py-16 sm:py-20 lg:py-28">
    <div class="mx-auto max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div class="flex flex-col justify-between gap-5 border-b border-slate-200 pb-8 md:flex-row md:items-end">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">{{ $isActivityPage ? __('frontend.posts.program_documentation') : __('frontend.posts.latest_information') }}</p>
                <h2 class="mt-3 text-2xl font-medium tracking-[-0.025em] text-slate-950 sm:text-3xl">{{ $isActivityPage ? __('frontend.posts.activity_heading') : __('frontend.posts.news_heading') }}</h2>
            </div>
        </div>

        <div class="mt-12 grid grid-cols-1 gap-x-6 gap-y-14 md:grid-cols-2 lg:mt-16 lg:grid-cols-3">
            @forelse($posts as $index => $post)
                <a href="{{ route('posts.show', $post->slug) }}" class="group block">
                    <div class="relative {{ $index % 3 === 1 ? 'aspect-square' : 'aspect-[4/3]' }} overflow-hidden rounded-2xl bg-slate-200">
                        @if($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                        @else
                            <div class="pspkb-news-placeholder h-full w-full"></div>
                        @endif
                        <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1.5 text-[11px] font-semibold text-emerald-800 shadow-sm backdrop-blur">{{ $post->category?->name ?? __('frontend.posts.default_category') }}</span>
                        <span class="absolute bottom-4 left-4 flex h-10 w-10 items-center overflow-hidden rounded-full bg-white text-slate-950 shadow-lg transition-all duration-300 group-hover:w-36">
                            <span class="whitespace-nowrap pl-4 text-xs font-semibold opacity-0 transition delay-75 group-hover:opacity-100">{{ __('frontend.common.read_more') }}</span>
                            <svg class="absolute right-3 h-4 w-4 -rotate-45 transition-transform duration-300 group-hover:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                        </span>
                    </div>
                    <div class="mt-5 flex items-center gap-3 text-xs text-slate-500">
                        <span>{{ str_pad($posts->firstItem() + $index, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="h-px w-8 bg-slate-300"></span>
                        <span>{{ $post->published_at?->translatedFormat('d F Y') }}</span>
                    </div>
                    <h2 class="mt-3 text-xl font-semibold leading-snug tracking-tight text-slate-950 transition group-hover:text-emerald-700">{{ $post->title }}</h2>
                    @if($post->excerpt)
                        <p class="mt-3 line-clamp-2 text-sm leading-6 text-slate-600">{{ $post->excerpt }}</p>
                    @endif
                </a>
            @empty
                <div class="col-span-full rounded-2xl border border-slate-200 bg-[#f7f8f5] p-12 text-center">
                    <span class="mx-auto grid h-12 w-12 place-items-center rounded-full bg-[#00c46a] text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 12h16M4 18h10"/></svg>
                    </span>
                    <p class="mt-5 text-lg font-medium text-slate-900">{{ $emptyMessage }}</p>
                    <p class="mt-2 text-sm text-slate-500">{{ __('frontend.common.new_content_admin') }}</p>
                </div>
            @endforelse
        </div>

        @if($posts->hasPages())
            <div class="mt-16 border-t border-slate-200 pt-8">{{ $posts->links() }}</div>
        @endif
    </div>
</section>

<section class="bg-[#f1f2ef] px-5 py-8 sm:px-8 lg:px-12">
    <div class="mx-auto flex max-w-[1440px] flex-col items-start justify-between gap-8 py-10 md:flex-row md:items-center">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">{{ __('frontend.common.stay_connected') }}</p>
            <h2 class="mt-3 max-w-3xl text-3xl font-medium leading-tight tracking-[-0.035em] text-slate-950 sm:text-5xl">{{ __('frontend.common.access_information') }}</h2>
        </div>
        <a href="{{ route('contact') }}" class="group inline-flex items-center gap-4 rounded-full bg-[#00c46a] py-2 pl-6 pr-2 text-sm font-semibold text-white">
            {{ __('frontend.common.contact_uld') }}
            <span class="grid h-9 w-9 place-items-center rounded-full bg-white text-emerald-800">
                <svg class="h-4 w-4 -rotate-45 transition-transform duration-500 group-hover:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </span>
        </a>
    </div>
</section>
@endsection
