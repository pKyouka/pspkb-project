@extends('layouts.frontend')

@section('title', 'Kontak')

@section('content')
@php
    $instagram = $settings['social_instagram'] ?? '';
    $instagramUrl = $instagram
        ? (\Illuminate\Support\Str::startsWith($instagram, ['http://', 'https://']) ? $instagram : 'https://instagram.com/' . ltrim($instagram, '@'))
        : '';
@endphp

<section class="bg-gradient-to-br from-emerald-900 via-emerald-700 to-purple-800 py-16 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <span class="inline-flex rounded-full bg-white/15 px-4 py-2 text-sm font-bold ring-1 ring-white/20">Kontak</span>
        <h1 class="mt-5 text-4xl font-black md:text-5xl">Hubungi Kami</h1>
        <p class="mt-4 max-w-2xl text-lg leading-8 text-emerald-50">Silakan kirim pesan atau gunakan informasi kontak resmi untuk mendapatkan bantuan.</p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    @if(session('success'))
        <div class="mb-8 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 font-semibold text-emerald-800">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-5">
        <div class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200 md:p-8 lg:col-span-3">
            <h2 class="text-2xl font-black text-slate-950">Kirim Pesan</h2>
            <p class="mt-2 text-slate-600">Formulir dibuat sederhana agar pengunjung mudah menghubungi pengelola.</p>

            <form action="{{ route('contact.store') }}" method="POST" class="mt-8 space-y-5">
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">Nama *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100" required>
                    @error('name') <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100" required>
                    @error('email') <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">Subjek *</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100" required>
                    @error('subject') <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-black text-slate-700">Pesan *</label>
                    <textarea name="message" rows="5" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100" required>{{ old('message') }}</textarea>
                    @error('message') <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="rounded-full bg-emerald-600 px-7 py-3 text-sm font-black text-white shadow-sm transition hover:bg-emerald-700">Kirim Pesan</button>
            </form>
        </div>

        <div class="rounded-[2rem] bg-gradient-to-br from-emerald-700 to-purple-800 p-6 text-white shadow-xl md:p-8 lg:col-span-2">
            <h2 class="text-2xl font-black">Informasi Kontak</h2>
            <div class="mt-8 space-y-5 text-emerald-50">
                @if(!empty($settings['contact_email']))
                    <p class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/10"><strong class="block text-white">Email</strong>{{ $settings['contact_email'] }}</p>
                @endif
                @if(!empty($settings['contact_phone']))
                    <p class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/10"><strong class="block text-white">Telepon</strong>{{ $settings['contact_phone'] }}</p>
                @endif
                @if(!empty($settings['contact_address']))
                    <p class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/10"><strong class="block text-white">Alamat</strong>{{ $settings['contact_address'] }}</p>
                @endif
                @if($instagramUrl)
                    <a href="{{ $instagramUrl }}" target="_blank" class="inline-flex rounded-full bg-white px-6 py-3 text-sm font-black text-emerald-800 transition hover:bg-emerald-50">Instagram Resmi →</a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection