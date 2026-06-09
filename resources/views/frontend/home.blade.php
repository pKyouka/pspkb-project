@extends('layouts.frontend')

@section('content')
@php
    $heroBanner = $banners->first();
    $siteName = $settings['website_name'] ?? config('app.name');
    $siteDescription = $settings['website_description'] ?? 'Pusat informasi, berita, dan layanan PSPKB Universitas Aisyiyah Yogyakarta.';
@endphp

<section class="relative overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-700 to-purple-800 text-white">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute -left-24 top-10 h-72 w-72 rounded-full bg-white blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-96 w-96 rounded-full bg-purple-300 blur-3xl"></div>
    </div>

    <div class="relative mx-auto grid max-w-7xl grid-cols-1 items-center gap-10 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-28">
        <div>
            <span class="inline-flex rounded-full bg-white/15 px-4 py-2 text-sm font-bold ring-1 ring-white/20">Universitas Aisyiyah Yogyakarta</span>
            <h1 class="mt-6 text-4xl font-black leading-tight tracking-tight md:text-6xl">
                {{ $heroBanner?->title ?? $siteName }}
            </h1>
            <p class="mt-6 max-w-2xl text-lg leading-8 text-emerald-50">
                {{ $heroBanner?->description ?? $siteDescription }}
            </p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ $heroBanner?->button_url ?: route('posts.index') }}" class="inline-flex items-center justify-center rounded-full bg-white px-7 py-3 text-sm font-black text-emerald-800 shadow-xl shadow-emerald-950/20 transition hover:-translate-y-0.5 hover:bg-emerald-50">
                    {{ $heroBanner?->button_text ?: 'Lihat Berita Terbaru' }}
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-full bg-white/10 px-7 py-3 text-sm font-black text-white ring-1 ring-white/25 transition hover:bg-white/20">
                    Hubungi Kami
                </a>
            </div>
        </div>

        <div class="relative">
            <div class="rounded-[2rem] bg-white/10 p-3 shadow-2xl ring-1 ring-white/20 backdrop-blur">
                @if($heroBanner?->image)
                    <img src="{{ asset('storage/' . $heroBanner->image) }}" alt="{{ $heroBanner->title }}" class="h-80 w-full rounded-[1.5rem] object-cover lg:h-[28rem]">
                @else
                    <div class="flex h-80 w-full items-center justify-center rounded-[1.5rem] bg-gradient-to-br from-white/20 to-white/5 lg:h-[28rem]">
                        <div class="text-center">
                            <div class="text-7xl">🎓</div>
                            <p class="mt-4 text-xl font-black">Smart • Green • Islamic</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="absolute -bottom-6 left-6 right-6 rounded-3xl bg-white p-5 text-slate-900 shadow-xl">
                <p class="text-sm font-bold text-emerald-700">Website Informasi PSPKB</p>
                <p class="mt-1 text-sm text-slate-600">Berita, agenda, layanan, dan informasi kampus tersaji rapi untuk pengunjung.</p>
            </div>
        </div>
    </div>
</section>

@if($featuredPages->count())
<section class="mx-auto max-w-7xl px-4 py-18 sm:px-6 lg:px-8">
    <div class="mb-10 flex flex-col justify-between gap-4 md:flex-row md:items-end">
        <div>
            <span class="text-sm font-black uppercase tracking-widest text-emerald-700">Profil & Layanan</span>
            <h2 class="mt-2 text-3xl font-black text-slate-950 md:text-4xl">Tentang Kami</h2>
            <p class="mt-3 max-w-2xl text-slate-600">Informasi penting disusun dalam kartu yang mudah dipindai oleh pengunjung.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        @foreach($featuredPages as $page)
            <a href="{{ route('pages.show', $page->slug) }}" class="group rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-1 hover:shadow-xl hover:ring-emerald-200">
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-2xl text-emerald-700 transition group-hover:bg-emerald-600 group-hover:text-white">✦</div>
                <h3 class="text-lg font-black text-slate-950 group-hover:text-emerald-700">{{ $page->title }}</h3>
                <p class="mt-3 text-sm leading-6 text-slate-600">{!! \Illuminate\Support\Str::limit(strip_tags($page->content), 120) !!}</p>
                <span class="mt-5 inline-flex text-sm font-bold text-emerald-700">Baca selengkapnya →</span>
            </a>
        @endforeach
    </div>
</section>
@endif

@if($featuredPosts->count())
<section class="bg-white py-18">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10 flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <span class="text-sm font-black uppercase tracking-widest text-purple-700">Informasi Terkini</span>
                <h2 class="mt-2 text-3xl font-black text-slate-950 md:text-4xl">Berita Terbaru</h2>
                <p class="mt-3 max-w-2xl text-slate-600">Kabar terbaru ditampilkan bersih, modern, dan nyaman dibaca.</p>
            </div>
            <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-6 py-3 text-sm font-black text-white shadow-sm transition hover:bg-emerald-700">Semua Berita →</a>
        </div>

        <div class="grid grid-cols-1 gap-7 md:grid-cols-2 lg:grid-cols-3">
            @foreach($featuredPosts as $post)
                <a href="{{ route('posts.show', $post->slug) }}" class="group overflow-hidden rounded-3xl bg-slate-50 shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-1 hover:shadow-xl">
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
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="overflow-hidden rounded-[2rem] bg-gradient-to-r from-emerald-700 to-purple-800 p-8 text-white shadow-xl md:p-12">
        <div class="grid grid-cols-1 items-center gap-8 md:grid-cols-3">
            <div class="md:col-span-2">
                <h2 class="text-3xl font-black">Butuh informasi lebih lanjut?</h2>
                <p class="mt-3 max-w-2xl leading-7 text-emerald-50">Tim kami siap membantu pengunjung mendapatkan informasi yang dibutuhkan.</p>
            </div>
            <div class="md:text-right">
                <a href="{{ route('contact') }}" class="inline-flex rounded-full bg-white px-7 py-3 text-sm font-black text-emerald-800 transition hover:bg-emerald-50">Hubungi Kami</a>
            </div>
        </div>
    </div>
</section>
@endsection