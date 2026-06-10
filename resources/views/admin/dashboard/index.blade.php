@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header')
    Dashboard
@endsection

@section('content')
    <section class="relative mb-6 overflow-hidden rounded-[2rem] bg-slate-950 px-6 py-8 text-white shadow-2xl shadow-slate-900/10 sm:px-8 lg:px-10">
        <div class="absolute -right-16 -top-24 h-72 w-72 rounded-full bg-emerald-500/20 blur-3xl"></div>
        <div class="absolute bottom-0 right-10 h-32 w-64 rotate-[-18deg] rounded-full bg-white/5 blur-xl"></div>

        <div class="relative flex flex-col justify-between gap-6 lg:flex-row lg:items-end">
            <div class="max-w-2xl">
                <p class="mb-3 text-xs font-bold uppercase tracking-[.24em] text-emerald-300">Pusat Kendali Konten</p>
                <h2 class="text-3xl font-black tracking-tight sm:text-4xl">Selamat datang, {{ auth()->user()->name }}.</h2>
                <p class="mt-3 max-w-xl text-sm leading-7 text-slate-300 sm:text-base">
                    Kelola informasi Unit Layanan Disabilitas dalam satu ruang kerja yang ringkas, rapi, dan mudah dipantau.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 rounded-full bg-emerald-500 px-5 py-3 text-sm font-bold text-white transition hover:bg-emerald-400">
                    <span class="text-lg leading-none">+</span>
                    Tulis Berita
                </a>
                <a href="{{ route('admin.activities.create') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-3 text-sm font-bold text-white transition hover:bg-white/15">
                    Tambah Kegiatan
                </a>
            </div>
        </div>
    </section>

    @php
        $cards = [
            ['label' => 'Berita & Artikel', 'value' => $stats['total_posts'], 'route' => 'admin.posts.index', 'tone' => 'bg-emerald-50 text-emerald-700'],
            ['label' => 'Halaman', 'value' => $stats['total_pages'], 'route' => 'admin.pages.index', 'tone' => 'bg-teal-50 text-teal-700'],
            ['label' => 'Pengguna', 'value' => $stats['total_users'], 'route' => 'admin.users.index', 'tone' => 'bg-slate-100 text-slate-700'],
            ['label' => 'Pesan Masuk', 'value' => $stats['total_messages'], 'route' => 'admin.messages.index', 'tone' => 'bg-amber-50 text-amber-700'],
            ['label' => 'Media', 'value' => $stats['total_media'], 'route' => 'admin.media.index', 'tone' => 'bg-cyan-50 text-cyan-700'],
        ];
    @endphp

    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
        @foreach($cards as $card)
            <a href="{{ route($card['route']) }}" class="admin-card group rounded-[1.4rem] bg-white p-5 transition duration-200 hover:-translate-y-1 hover:shadow-xl">
                <div class="mb-5 flex items-center justify-between">
                    <span class="grid h-10 w-10 place-items-center rounded-2xl {{ $card['tone'] }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8M8 12h8M8 17h5M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                        </svg>
                    </span>
                    <svg class="h-4 w-4 text-slate-300 transition group-hover:translate-x-1 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <div class="text-3xl font-black tracking-tight text-slate-900">{{ $card['value'] }}</div>
                <div class="mt-1 text-sm font-semibold text-slate-500">{{ $card['label'] }}</div>
                @if($card['label'] === 'Pesan Masuk' && $stats['unread_messages'] > 0)
                    <div class="mt-3 text-xs font-bold text-amber-700">{{ $stats['unread_messages'] }} belum dibaca</div>
                @endif
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <section class="admin-card overflow-hidden rounded-[1.5rem] bg-white">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[.18em] text-emerald-700">Konten</p>
                    <h3 class="mt-1 text-lg font-black text-slate-900">Berita Terbaru</h3>
                </div>
                <a href="{{ route('admin.posts.index') }}" class="text-sm font-bold text-emerald-700 hover:text-emerald-900">Lihat semua</a>
            </div>
            <div class="divide-y divide-slate-100 px-6">
                @forelse($recentPosts as $post)
                    <div class="flex items-center justify-between gap-4 py-4">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-bold text-slate-800">{{ $post->title }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $post->created_at?->diffForHumans() }}</p>
                        </div>
                        <span class="shrink-0 rounded-full px-3 py-1 text-[11px] font-bold {{ $post->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                            {{ $post->status === 'published' ? 'Terbit' : 'Draf' }}
                        </span>
                    </div>
                @empty
                    <p class="py-8 text-center text-sm text-slate-500">Belum ada berita.</p>
                @endforelse
            </div>
        </section>

        <section class="admin-card overflow-hidden rounded-[1.5rem] bg-white">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[.18em] text-emerald-700">Kotak Masuk</p>
                    <h3 class="mt-1 text-lg font-black text-slate-900">Pesan Terbaru</h3>
                </div>
                <a href="{{ route('admin.messages.index') }}" class="text-sm font-bold text-emerald-700 hover:text-emerald-900">Lihat semua</a>
            </div>
            <div class="divide-y divide-slate-100 px-6">
                @forelse($recentMessages as $msg)
                    <a href="{{ route('admin.messages.show', $msg->id) }}" class="group flex items-center justify-between gap-4 py-4">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-bold text-slate-800 group-hover:text-emerald-700">{{ $msg->name }}</p>
                            <p class="mt-1 truncate text-xs text-slate-500">{{ $msg->subject }}</p>
                        </div>
                        <span class="shrink-0 text-xs font-bold text-emerald-700">Buka</span>
                    </a>
                @empty
                    <p class="py-8 text-center text-sm text-slate-500">Tidak ada pesan baru.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
