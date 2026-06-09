@extends('layouts.admin')
@section('title', 'Tambah Banner')
@section('content')
<div class="bg-white rounded-lg shadow p-6"><h2 class="text-lg font-semibold mb-4">Tambah Banner</h2>
    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data"><div class="space-y-4 max-w-xl">@csrf
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Judul *</label><input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded-lg px-3 py-2" required></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label><textarea name="description" rows="3" class="w-full border rounded-lg px-3 py-2">{{ old('description') }}</textarea></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label><input type="file" name="image" class="w-full border rounded-lg px-3 py-2" accept="image/*"></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Tombol Teks</label><input type="text" name="button_text" value="{{ old('button_text') }}" class="w-full border rounded-lg px-3 py-2"></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Tombol URL</label><input type="url" name="button_url" value="{{ old('button_url') }}" class="w-full border rounded-lg px-3 py-2"></div>
        <div class="flex items-center"><input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} class="mr-2"><label class="text-sm text-gray-700">Aktif</label></div>
    </div><div class="flex items-center space-x-2 mt-6"><button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan</button><a href="{{ route('admin.banners.index') }}" class="text-gray-600">Batal</a></div></form>
</div>
@endsection
