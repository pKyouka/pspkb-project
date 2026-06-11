@extends('layouts.admin')
@section('title', 'Tambah Banner')
@section('content')
<div class="rounded-2xl bg-white p-6 shadow-sm">
    <h2 class="mb-1 text-lg font-semibold">Tambah Banner Homepage</h2>
    <p class="mb-6 text-sm text-slate-500">Pilih hingga 10 gambar sekaligus. Semua gambar akan menjadi slide latar hero homepage.</p>
    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="max-w-2xl space-y-4">
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Gambar Banner *</label>
                <input type="file" name="images[]" class="w-full rounded-lg border px-3 py-2" accept="image/jpeg,image/png,image/webp" multiple required>
                <p class="mt-1 text-xs text-slate-500">Rekomendasi 1920 x 1080 piksel. Format JPG, PNG, atau WebP, maksimal 5 MB per gambar.</p>
                @error('images')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                @error('images.*')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>
            <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}><span class="text-sm text-gray-700">Tampilkan di homepage</span></label>
        </div>
        <div class="mt-6 flex items-center gap-3"><button type="submit" class="rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700">Simpan</button><a href="{{ route('admin.banners.index') }}" class="text-gray-600">Batal</a></div>
    </form>
</div>
@endsection
