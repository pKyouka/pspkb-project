@extends('layouts.frontend')

@section('title', $post->meta_title ?: $post->title)
@section('description', $post->meta_description ?: $post->excerpt)

@section('content')
@php
    $isActivity = $post->category?->slug === 'kegiatan';
    $indexRoute = $isActivity ? route('activities.index') : route('posts.index');
    $indexLabel = $isActivity ? __('frontend.nav.activities') : __('frontend.nav.news');
@endphp

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
                <a href="{{ $indexRoute }}" class="transition hover:text-emerald-700">{{ $indexLabel }}</a>
            </nav>

            <div class="flex flex-wrap items-center gap-3">
                @if($post->category)
                    <span class="rounded-full bg-slate-950 px-4 py-2 text-xs font-semibold text-white">{{ $post->category->name }}</span>
                @endif
                <span class="rounded-full border border-slate-300 bg-white/40 px-4 py-2 text-xs font-medium text-slate-700 backdrop-blur">{{ $post->published_at?->translatedFormat('d F Y') }}</span>
            </div>

            <h1 class="mt-7 max-w-6xl text-[clamp(2.5rem,6vw,5rem)] font-medium leading-[1] tracking-[-0.05em] text-slate-950">{{ $post->title }}</h1>
            @if($post->excerpt)
                <p class="mt-7 max-w-3xl text-base leading-7 text-slate-600 sm:text-lg">{{ $post->excerpt }}</p>
            @endif
        </div>
    </section>

    <section class="bg-white py-14 sm:py-20 lg:py-24">
        <div class="mx-auto max-w-[1440px] px-5 sm:px-8 lg:px-12">
            @if($post->thumbnail)
                <img src="{{ asset('storage/' . $post->thumbnail) }}" class="aspect-[16/8] w-full rounded-2xl object-cover" alt="{{ $post->title }}">
            @else
                <div class="pspkb-news-placeholder aspect-[16/7] w-full rounded-2xl"></div>
            @endif

            <div class="mt-14 grid gap-10 lg:mt-20 lg:grid-cols-[240px_1fr] lg:gap-20">
                <aside class="lg:sticky lg:top-28 lg:self-start">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">{{ __('frontend.common.information') }}</p>
                    <dl class="mt-5 divide-y divide-slate-200 text-sm">
                        <div class="py-4 first:pt-0">
                            <dt class="text-slate-400">{{ __('frontend.common.category') }}</dt>
                            <dd class="mt-1 font-medium text-slate-900">{{ $post->category?->name ?? __('frontend.posts.default_category') }}</dd>
                        </div>
                        <div class="py-4">
                            <dt class="text-slate-400">{{ __('frontend.common.published') }}</dt>
                            <dd class="mt-1 font-medium text-slate-900">{{ $post->published_at?->translatedFormat('d F Y') }}</dd>
                        </div>
                        @if($post->creator)
                            <div class="py-4">
                                <dt class="text-slate-400">{{ __('frontend.common.author') }}</dt>
                                <dd class="mt-1 font-medium text-slate-900">{{ $post->creator->name }}</dd>
                            </div>
                        @endif
                    </dl>

                    @if($post->tags->count())
                        <div class="mt-6 flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                                <span class="rounded-full border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600">#{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif
                </aside>

                <div>
                    <div class="pspkb-prose">
                        {!! $post->content !!}
                    </div>

                    <div class="mt-14 flex flex-col gap-3 border-t border-slate-200 pt-8 sm:flex-row sm:justify-between">
                        <a href="{{ $indexRoute }}" class="group inline-flex items-center gap-3 text-sm font-semibold text-slate-900">
                            <span class="grid h-9 w-9 place-items-center rounded-full border border-slate-300 transition group-hover:bg-slate-950 group-hover:text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="m15 18-6-6 6-6"/></svg>
                            </span>
                            {{ __('frontend.common.back_to', ['page' => $indexLabel]) }}
                        </a>
                        <a href="{{ route('contact') }}" class="group inline-flex items-center gap-3 text-sm font-semibold text-emerald-700">
                            {{ __('frontend.common.contact_uld') }}
                            <span class="grid h-9 w-9 place-items-center rounded-full bg-[#00c46a] text-white">
                                <svg class="h-4 w-4 -rotate-45 transition-transform duration-300 group-hover:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</article>
@endsection
