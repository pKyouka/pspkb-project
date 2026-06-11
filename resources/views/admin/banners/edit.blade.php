@extends('layouts.admin')
@section('title', 'Edit Banner')
@section('content')
<div class="rounded-2xl bg-white p-6 shadow-sm">
    <h2 class="mb-1 text-lg font-semibold">Ganti Gambar Banner</h2>
    <p class="mb-6 text-sm text-slate-500">Banner hanya menyimpan gambar. Tulisan hero homepage tetap dan tidak dapat diubah dari menu ini.</p>
    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="max-w-2xl space-y-4">
            <div>
                <label class="mb-2 block text-sm font-bold text-gray-700">Gambar Saat Ini</label>
                <img src="{{ $banner->image_url }}" alt="Gambar banner homepage" class="mb-5 aspect-video w-full max-w-xl rounded-2xl bg-slate-100 object-cover">
                <label class="mb-2 block text-sm font-bold text-gray-700">Pilih Gambar Pengganti</label>
                <input type="file" name="image" class="w-full rounded-xl border px-4 py-3" accept="image/jpeg,image/png,image/webp" required>
                <p class="mt-2 text-xs text-slate-500">Rekomendasi 1920 x 1080 piksel. Format JPG, PNG, atau WebP, maksimal 5 MB.</p>
                @error('image')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>
            <input type="hidden" name="is_active" value="0">
            <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}><span class="text-sm text-gray-700">Tampilkan di homepage</span></label>
        </div>
        <div class="mt-6 flex items-center gap-3"><button type="submit" class="rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700">Ganti Gambar</button><a href="{{ route('admin.banners.index') }}" class="text-gray-600">Batal</a></div>
    </form>
</div>
@endsection
