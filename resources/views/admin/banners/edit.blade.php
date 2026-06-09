@extends('layouts.admin')
@section('title', 'Edit Banner')
@section('content')
<div class="bg-white rounded-lg shadow p-6"><h2 class="text-lg font-semibold mb-4">Edit: {{ $banner->title }}</h2>
    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data"><div class="space-y-4 max-w-xl">@csrf @method('PUT')
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Judul *</label><input type="text" name="title" value="{{ old('title', $banner->title) }}" class="w-full border rounded-lg px-3 py-2" required></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label><textarea name="description" rows="3" class="w-full border rounded-lg px-3 py-2">{{ old('description', $banner->description) }}</textarea></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label><input type="file" name="image" class="w-full border rounded-lg px-3 py-2" accept="image/*">@if($banner->image)<img src="{{ asset('storage/'.$banner->image) }}" class="mt-2 w-32 rounded">@endif</div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Tombol Teks</label><input type="text" name="button_text" value="{{ old('button_text', $banner->button_text) }}" class="w-full border rounded-lg px-3 py-2"></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Tombol URL</label><input type="url" name="button_url" value="{{ old('button_url', $banner->button_url) }}" class="w-full border rounded-lg px-3 py-2"></div>
        <div class="flex items-center"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }} class="mr-2"><label class="text-sm text-gray-700">Aktif</label></div>
    </div><div class="flex items-center space-x-2 mt-6"><button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Perbarui</button><a href="{{ route('admin.banners.index') }}" class="text-gray-600">Batal</a></div></form>
</div>
@endsection
