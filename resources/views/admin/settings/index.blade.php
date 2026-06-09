@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800">Pengaturan</h2>
@endsection

@section('content')
@php
    $logo = $settings['logo'] ?? '';
    $favicon = $settings['favicon'] ?? '';
    $inputClass = 'w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100';
    $labelClass = 'mb-2 block text-xs font-bold uppercase tracking-wide text-gray-600';
@endphp

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-2xl font-bold text-gray-900">Pengaturan Website</h3>
            <p class="mt-1 text-sm text-gray-500">Kelola identitas, kontak, media sosial, dan SEO default website.</p>
        </div>

        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <span>💾</span>
            <span>Simpan Pengaturan</span>
        </button>
    </div>

    @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">
            <div class="mb-2 font-bold">Ada input yang perlu diperbaiki:</div>
            <ul class="list-inside list-disc space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="space-y-6 xl:col-span-2">
            <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
                <div class="border-b border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900">Informasi Umum</h3>
                    <p class="mt-1 text-sm text-gray-500">Nama website, deskripsi, logo, dan favicon.</p>
                </div>

                <div class="grid grid-cols-1 gap-5 p-6 lg:grid-cols-2">
                    <div>
                        <label class="{{ $labelClass }}">Nama Website</label>
                        <input type="text" name="website_name" value="{{ old('website_name', $settings['website_name'] ?? '') }}" class="{{ $inputClass }}" placeholder="Nama website">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Deskripsi</label>
                        <input type="text" name="website_description" value="{{ old('website_description', $settings['website_description'] ?? '') }}" class="{{ $inputClass }}" placeholder="Deskripsi singkat website">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Logo</label>
                        <div class="space-y-3">
                            <label class="flex cursor-pointer items-center gap-4 rounded-2xl border border-dashed border-blue-200 bg-blue-50/60 p-4 transition hover:border-blue-400 hover:bg-blue-50">
                                <span class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-blue-100">
                                    @if($logo)
                                        <img src="{{ asset('storage/' . $logo) }}" alt="Logo saat ini" class="h-full w-full object-contain p-2">
                                    @else
                                        <span class="text-xl">🖼️</span>
                                    @endif
                                </span>
                                <span class="min-w-0 flex-1">
                                    <span class="block text-sm font-bold text-gray-900">Upload logo baru</span>
                                    <span class="block truncate text-xs font-medium text-blue-700">{{ $logo ? basename($logo) : 'PNG/JPG/WebP maksimal 2MB' }}</span>
                                </span>
                                <input type="file" name="logo" class="sr-only" accept="image/*">
                            </label>

                            @if($logo)
                                <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-800 transition hover:bg-red-100">
                                    <input type="checkbox" name="remove_logo" value="1" class="mt-1 rounded border-red-300 text-red-600 focus:ring-red-500">
                                    <span>
                                        <span class="block font-bold">Hapus logo saat ini</span>
                                        <span class="block text-xs text-red-700">Centang lalu klik Simpan Pengaturan.</span>
                                    </span>
                                </label>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Favicon</label>
                        <div class="space-y-3">
                            <label class="flex cursor-pointer items-center gap-4 rounded-2xl border border-dashed border-blue-200 bg-blue-50/60 p-4 transition hover:border-blue-400 hover:bg-blue-50">
                                <span class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-blue-100">
                                    @if($favicon)
                                        <img src="{{ asset('storage/' . $favicon) }}" alt="Favicon saat ini" class="h-full w-full object-contain p-2">
                                    @else
                                        <span class="text-xl">⭐</span>
                                    @endif
                                </span>
                                <span class="min-w-0 flex-1">
                                    <span class="block text-sm font-bold text-gray-900">Upload favicon baru</span>
                                    <span class="block truncate text-xs font-medium text-blue-700">{{ $favicon ? basename($favicon) : 'PNG/ICO/JPG maksimal 1MB' }}</span>
                                </span>
                                <input type="file" name="favicon" class="sr-only" accept="image/*">
                            </label>

                            @if($favicon)
                                <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-red-800 transition hover:bg-red-100">
                                    <input type="checkbox" name="remove_favicon" value="1" class="mt-1 rounded border-red-300 text-red-600 focus:ring-red-500">
                                    <span>
                                        <span class="block font-bold">Hapus favicon saat ini</span>
                                        <span class="block text-xs text-red-700">Centang lalu klik Simpan Pengaturan.</span>
                                    </span>
                                </label>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
                <div class="border-b border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900">Kontak</h3>
                    <p class="mt-1 text-sm text-gray-500">Informasi yang tampil di footer dan halaman kontak.</p>
                </div>

                <div class="grid grid-cols-1 gap-5 p-6 lg:grid-cols-3">
                    <div>
                        <label class="{{ $labelClass }}">Email</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" class="{{ $inputClass }}" placeholder="info@domain.id">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Telepon</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}" class="{{ $inputClass }}" placeholder="021-xxxxxxx">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Alamat</label>
                        <input type="text" name="contact_address" value="{{ old('contact_address', $settings['contact_address'] ?? '') }}" class="{{ $inputClass }}" placeholder="Alamat lengkap">
                    </div>
                </div>
            </section>

            <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
                <div class="border-b border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900">Media Sosial</h3>
                    <p class="mt-1 text-sm text-gray-500">Fokuskan akun resmi website ke Instagram.</p>
                </div>

                <div class="p-6">
                    <label class="{{ $labelClass }}">Instagram</label>
                    <div class="flex flex-col gap-4 rounded-2xl border border-pink-100 bg-gradient-to-br from-pink-50 via-white to-orange-50 p-4 sm:flex-row sm:items-center">
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white text-2xl shadow-sm ring-1 ring-pink-100">📸</div>
                        <div class="min-w-0 flex-1">
                            <input type="text" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}" class="{{ $inputClass }}" placeholder="@username atau https://instagram.com/username">
                            <p class="mt-2 text-xs font-medium text-gray-500">Isi username atau URL Instagram resmi PSPKB.</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <aside class="space-y-6">
            <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
                <div class="border-b border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900">SEO Default</h3>
                    <p class="mt-1 text-sm text-gray-500">Metadata fallback halaman publik.</p>
                </div>

                <div class="space-y-5 p-6">
                    <div>
                        <label class="{{ $labelClass }}">Meta Title</label>
                        <input type="text" name="seo_meta_title" value="{{ old('seo_meta_title', $settings['seo_meta_title'] ?? '') }}" class="{{ $inputClass }}" placeholder="Judul SEO default">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Meta Description</label>
                        <textarea name="seo_meta_description" rows="5" class="{{ $inputClass }}" placeholder="Deskripsi untuk mesin pencari">{{ old('seo_meta_description', $settings['seo_meta_description'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Keywords</label>
                        <input type="text" name="seo_keywords" value="{{ old('seo_keywords', $settings['seo_keywords'] ?? '') }}" class="{{ $inputClass }}" placeholder="keyword1, keyword2, keyword3">
                    </div>
                </div>
            </section>

            <section class="rounded-2xl bg-blue-50 p-5 ring-1 ring-blue-100">
                <h3 class="text-sm font-bold text-blue-900">Tips</h3>
                <p class="mt-2 text-sm leading-6 text-blue-800">Isi data utama dan SEO agar tampilan website publik lebih konsisten. Klik simpan setelah semua perubahan selesai.</p>
            </section>
        </aside>
    </div>

    <div class="sticky bottom-4 z-10 flex justify-end">
        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <span>💾</span>
            <span>Simpan Pengaturan</span>
        </button>
    </div>
</form>
@endsection