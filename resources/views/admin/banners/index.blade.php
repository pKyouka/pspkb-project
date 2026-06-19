@extends('layouts.admin')

@section('title', 'Banner')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800">Banner</h2>
@endsection

@section('content')
<div class="space-y-6">
    <div>
        <h3 class="text-2xl font-bold text-gray-900">Galeri Banner Homepage</h3>
        <p class="mt-1 text-sm text-gray-500">Banner hanya berisi gambar. Judul dan tulisan pada homepage tetap statis.</p>
    </div>

    <div class="rounded-[2rem] border border-dashed border-emerald-300 bg-emerald-50/60 p-6 shadow-sm">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5 lg:flex-row lg:items-end">
            @csrf
            <div class="flex-1">
                <label class="mb-2 block text-sm font-bold text-slate-800">Upload Gambar Banner</label>
                <input type="file" name="images[]" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm" accept="image/jpeg,image/png,image/webp" multiple required>
                <p class="mt-2 text-xs text-slate-500">Bisa memilih hingga 10 gambar sekaligus. Rekomendasi 1920 x 1080 piksel, maksimal 5 MB per gambar.</p>
                @error('images')<p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>@enderror
                @error('images.*')<p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>@enderror
            </div>
            <input type="hidden" name="is_active" value="1">
            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#00c46a] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#00d976]">
                Upload Gambar
            </button>
        </form>
    </div>

    <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <h3 class="text-lg font-black text-slate-900">Gambar Banner</h3>
            <p class="mt-1 text-sm text-slate-500">Hanya gambar berstatus aktif yang akan bergulir di homepage.</p>
        </div>

        @if($banners->count())
            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                @foreach($banners as $banner)
                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                        <div class="relative aspect-video bg-slate-200">
                            <img src="{{ $banner->image_url }}" alt="Gambar banner homepage" class="h-full w-full object-cover">
                            <span class="absolute left-3 top-3 rounded-full px-3 py-1 text-xs font-bold shadow-sm {{ $banner->is_active ? 'bg-emerald-600 text-white' : 'bg-slate-900/80 text-white' }}">
                                {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-2 p-4">
                            <form action="{{ route('admin.banners.update', $banner) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="is_active" value="{{ $banner->is_active ? 0 : 1 }}">
                                <button class="rounded-xl bg-white px-3 py-2 text-xs font-bold text-slate-700 ring-1 ring-slate-200 hover:bg-slate-100">
                                    {{ $banner->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <a href="{{ route('admin.banners.edit', $banner) }}" class="rounded-xl bg-blue-50 px-3 py-2 text-xs font-bold text-blue-700 hover:bg-blue-100">Ganti Gambar</a>
                            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Hapus gambar banner ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-xl bg-rose-50 px-3 py-2 text-xs font-bold text-rose-700 hover:bg-rose-100">Hapus</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl bg-slate-50 px-6 py-14 text-center">
                <h3 class="font-bold text-slate-900">Belum ada gambar banner</h3>
                <p class="mt-1 text-sm text-slate-500">Upload gambar melalui area di atas.</p>
            </div>
        @endif

        <div class="mt-6">{{ $banners->links() }}</div>
    </div>
</div>
@endsection
