@extends('layouts.frontend')

@section('title', 'Berita')

@section('content')
<section class="bg-gradient-to-br from-emerald-900 via-emerald-700 to-purple-800 py-16 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <span class="inline-flex rounded-full bg-white/15 px-4 py-2 text-sm font-bold ring-1 ring-white/20">Informasi Terkini</span>
        <h1 class="mt-5 text-4xl font-black md:text-5xl">Berita</h1>
        <p class="mt-4 max-w-2xl text-lg leading-8 text-emerald-50">Kumpulan kabar, agenda, dan informasi terbaru disajikan ringkas agar mudah dibaca pengunjung.</p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 gap-7 md:grid-cols-2 lg:grid-cols-3">
        @forelse($posts as $post)
            <a href="{{ route('posts.show', $post->slug) }}" class="group overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-1 hover:shadow-xl hover:ring-emerald-200">
                <div class="relative h-56 overflow-hidden">
                    @if($post->thumbnail)
                        <img src="{{ asset('storage/' . $post->thumbnail) }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" alt="{{ $post->title }}">
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-emerald-100 to-purple-100 text-5xl">📰</div>
                    @endif
                    @if($post->category)
                        <span class="absolute left-4 top-4 rounded-full bg-white/95 px-3 py-1 text-xs font-black text-emerald-700 shadow-sm">{{ $post->category->name }}</span>
                    @endif
                </div>
                <div class="p-6">
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-500">{{ $post->published_at?->format('d M Y') }}</p>
                    <h3 class="mt-3 line-clamp-2 text-xl font-black leading-snug text-slate-950 group-hover:text-emerald-700">{{ $post->title }}</h3>
                    <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($post->excerpt, 130) }}</p>
                    <span class="mt-5 inline-flex text-sm font-black text-emerald-700">Baca berita →</span>
                </div>
            </a>
        @empty
            <div class="col-span-full rounded-3xl bg-white p-12 text-center shadow-sm ring-1 ring-slate-200">
                <div class="text-5xl">📰</div>
                <h2 class="mt-4 text-xl font-black text-slate-950">Belum ada berita</h2>
                <p class="mt-2 text-slate-600">Berita terbaru akan tampil di halaman ini.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $posts->links() }}
    </div>
</section>
@endsection