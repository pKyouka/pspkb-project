@extends('layouts.frontend')

@section('title', 'Pencarian')

@section('content')
<section class="bg-gradient-to-br from-emerald-900 via-emerald-700 to-purple-800 py-16 text-white">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <span class="inline-flex rounded-full bg-white/15 px-4 py-2 text-sm font-bold ring-1 ring-white/20">Pencarian</span>
        <h1 class="mt-5 text-4xl font-black md:text-5xl">Cari Informasi</h1>
        <p class="mt-4 max-w-2xl text-lg leading-8 text-emerald-50">Temukan berita, halaman, dan informasi website dengan cepat.</p>
    </div>
</section>

<section class="mx-auto max-w-5xl px-4 py-14 sm:px-6 lg:px-8">
    <form action="{{ route('search') }}" method="GET" class="mb-8 overflow-hidden rounded-[2rem] bg-white p-3 shadow-sm ring-1 ring-slate-200">
        <div class="flex flex-col gap-3 sm:flex-row">
            <input type="text" name="q" value="{{ $query }}" placeholder="Cari halaman atau berita..." class="min-w-0 flex-1 rounded-2xl border border-slate-200 px-5 py-4 text-base outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100">
            <button type="submit" class="rounded-2xl bg-emerald-600 px-7 py-4 text-sm font-black text-white transition hover:bg-emerald-700">Cari</button>
        </div>
    </form>

    @if($query)
        <div class="mb-5 rounded-2xl bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800 ring-1 ring-emerald-100">
            Ditemukan {{ $results->count() }} hasil untuk "<strong>{{ $query }}</strong>"
        </div>

        <div class="space-y-4">
            @forelse($results as $result)
                <a href="{{ $result['url'] }}" class="block rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-0.5 hover:shadow-xl hover:ring-emerald-200">
                    <span class="rounded-full px-3 py-1 text-xs font-black {{ $result['type'] === 'post' ? 'bg-purple-50 text-purple-700 ring-1 ring-purple-100' : 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100' }}">{{ $result['type'] === 'post' ? 'Berita' : 'Halaman' }}</span>
                    <h3 class="mt-3 text-xl font-black text-slate-950">{{ $result['title'] }}</h3>
                    @if($result['excerpt'])
                        <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-600">{{ $result['excerpt'] }}</p>
                    @endif
                </a>
            @empty
                <div class="rounded-3xl bg-white p-12 text-center shadow-sm ring-1 ring-slate-200">
                    <div class="text-5xl">🔎</div>
                    <h2 class="mt-4 text-xl font-black text-slate-950">Tidak ada hasil ditemukan</h2>
                    <p class="mt-2 text-slate-600">Coba gunakan kata kunci lain yang lebih umum.</p>
                </div>
            @endforelse
        </div>
    @endif
</section>
@endsection