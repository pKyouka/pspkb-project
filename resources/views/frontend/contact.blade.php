@extends('layouts.frontend')

@section('title', __('frontend.contact.title'))
@section('description', __('frontend.contact.description'))

@section('content')
@php
    $instagram = $settings['social_instagram'] ?? '';
    $instagramUrl = $instagram
        ? (\Illuminate\Support\Str::startsWith($instagram, ['http://', 'https://']) ? $instagram : 'https://instagram.com/' . ltrim($instagram, '@'))
        : '';
    $contactHeading = $settings['contact_heading'] ?? __('frontend.contact.heading');
    $contactDescription = $settings['contact_description'] ?? __('frontend.contact.description');
@endphp

<section class="relative overflow-hidden bg-emerald-800 py-20 text-white sm:py-24 lg:py-28">
    <div class="absolute inset-0 opacity-30 [background:radial-gradient(circle_at_80%_20%,rgba(255,255,255,.45),transparent_26%),linear-gradient(135deg,transparent_35%,rgba(255,255,255,.12))]"></div>
    <div class="relative mx-auto max-w-[1440px] px-5 sm:px-8 lg:px-12">
        <div class="flex items-center gap-3">
            <span class="h-2 w-2 rounded-full bg-emerald-200"></span>
            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-100">{{ __('frontend.contact.label') }}</span>
        </div>
        <h1 class="mt-7 max-w-5xl text-[clamp(2.75rem,7vw,5.8rem)] font-medium leading-[.98] tracking-[-0.055em]">{{ $contactHeading }}</h1>
        <p class="mt-7 max-w-2xl text-base leading-7 text-emerald-50 sm:text-lg">{{ $contactDescription }}</p>
    </div>
</section>

<section class="bg-[#f1f2ef] py-16 sm:py-20 lg:py-24">
    <div class="mx-auto max-w-[1440px] px-5 sm:px-8 lg:px-12">
        @if(session('success'))
            <div class="mb-8 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 font-medium text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[1fr_38%]">
            <div class="rounded-2xl bg-white p-6 sm:p-9">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">{{ __('frontend.contact.send_message') }}</p>
                <h2 class="mt-3 text-3xl font-medium tracking-tight text-slate-950">{{ __('frontend.contact.tell_us') }}</h2>

                <form action="{{ route('contact.store') }}" method="POST" class="mt-9 grid gap-5 sm:grid-cols-2">
                    @csrf
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">{{ __('frontend.contact.name') }} *</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-100" required>
                        @error('name') <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-100" required>
                        @error('email') <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">{{ __('frontend.contact.phone') }}</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-100">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">{{ __('frontend.contact.subject') }} *</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-100" required>
                        @error('subject') <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="mb-2 block text-sm font-semibold text-slate-700">{{ __('frontend.contact.message') }} *</label>
                        <textarea name="message" rows="6" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-100" required>{{ old('message') }}</textarea>
                        @error('message') <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="group inline-flex items-center gap-4 rounded-full bg-[#00c46a] py-2 pl-6 pr-2 text-sm font-semibold text-white transition hover:bg-[#00d976]">
                            {{ __('frontend.contact.submit') }}
                            <span class="grid h-9 w-9 place-items-center rounded-full bg-white text-emerald-800">
                                <svg class="h-4 w-4 -rotate-45 transition-transform duration-300 group-hover:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <aside class="flex flex-col justify-between rounded-2xl bg-slate-950 p-7 text-white sm:p-9">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-300">{{ __('frontend.contact.information') }}</p>
                    <div class="mt-8 divide-y divide-white/10">
                        @if(!empty($settings['contact_email']))
                            <div class="py-5 first:pt-0">
                                <p class="text-xs text-slate-400">Email</p>
                                <a href="mailto:{{ $settings['contact_email'] }}" class="mt-2 block font-medium hover:text-emerald-300">{{ $settings['contact_email'] }}</a>
                            </div>
                        @endif
                        @if(!empty($settings['contact_phone']))
                            <div class="py-5">
                                <p class="text-xs text-slate-400">{{ __('frontend.contact.phone') }}</p>
                                <a href="tel:{{ preg_replace('/\s+/', '', $settings['contact_phone']) }}" class="mt-2 block font-medium hover:text-emerald-300">{{ $settings['contact_phone'] }}</a>
                            </div>
                        @endif
                        @if(!empty($settings['contact_address']))
                            <div class="py-5">
                                <p class="text-xs text-slate-400">{{ __('frontend.contact.address') }}</p>
                                <p class="mt-2 leading-7 text-slate-200">{{ $settings['contact_address'] }}</p>
                            </div>
                        @endif
                        @if(!empty($settings['contact_hours']))
                            <div class="py-5">
                                <p class="text-xs text-slate-400">{{ __('frontend.contact.hours') }}</p>
                                <p class="mt-2 font-medium">{{ $settings['contact_hours'] }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if($instagramUrl)
                    <a href="{{ $instagramUrl }}" target="_blank" rel="noopener" class="mt-8 inline-flex items-center justify-between rounded-full bg-white py-2 pl-5 pr-2 text-sm font-semibold text-slate-950">
                        {{ __('frontend.contact.instagram') }}
                        <span class="grid h-8 w-8 place-items-center rounded-full bg-emerald-100 text-emerald-800">
                            <svg class="h-4 w-4 -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                        </span>
                    </a>
                @endif
            </aside>
        </div>
    </div>
</section>
@endsection
