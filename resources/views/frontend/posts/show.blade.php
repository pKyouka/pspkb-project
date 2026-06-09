@extends('layouts.frontend')

@section('title', $post->title)
@section('description', $post->meta_description ?? $post->excerpt)

@section('content')
<article>
    <section class="bg-gradient-to-br from-emerald-900 via-emerald-700 to-purple-800 py-14 text-white">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <nav class="text-sm font-semibold text-emerald-50/90">
                <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
                <span class="mx-2">/</span>
                <a href="{{ route('posts.index') }}" class="hover:text-white">Berita</a>
            </nav>

            <div class="mt-8 flex flex-wrap items-center gap-3 text-sm">
                @if($post->category)
                    <span class="rounded-full bg-white px-4 py-2 font-black text-emerald-800">{{ $post->category->name }}</span>
                @endif
                <span class="rounded-full bg-white/15 px-4 py-2 font-bold ring-1 ring-white/20">{{ $post->published_at?->format('d M Y') }}</span>
                @if($post->creator)
                    <span class="rounded-full bg-white/15 px-4 py-2 font-bold ring-1 ring-white/20">Oleh {{ $post->creator->name }}</span>
                @endif
            </div>

            <h1 class="mt-6 text-4xl font-black leading-tight tracking-tight md:text-5xl">{{ $post->title }}</h1>
            @if($post->excerpt)
                <p class="mt-5 max-w-3xl text-lg leading-8 text-emerald-50">{{ $post->excerpt }}</p>
            @endif
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        @if($post->thumbnail)
            <img src="{{ asset('storage/' . $post->thumbnail) }}" class="mb-10 h-72 w-full rounded-[2rem] object-cover shadow-xl md:h-[28rem]" alt="{{ $post->title }}">
        @endif

        @if($post->tags->count())
            <div class="mb-8 flex flex-wrap gap-2">
                @foreach($post->tags as $tag)
                    <span class="rounded-full bg-emerald-50 px-4 py-2 text-sm font-bold text-emerald-700 ring-1 ring-emerald-100">#{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif

        <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200 md:p-10">
            <div class="prose prose-lg max-w-none prose-headings:font-black prose-headings:text-slate-950 prose-a:text-emerald-700 prose-img:rounded-2xl">
                {!! $post->content !!}
            </div>
        </div>

        <div class="mt-10 flex flex-col gap-3 sm:flex-row sm:justify-between">
            <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-6 py-3 text-sm font-black text-white transition hover:bg-slate-800">← Kembali ke Berita</a>
            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-6 py-3 text-sm font-black text-white transition hover:bg-emerald-700">Hubungi Kami</a>
        </div>
    </section>
</article>
@endsection