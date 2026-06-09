@extends('layouts.admin')
@section('title', 'Tambah Kategori')
@section('header', '')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold mb-4">Tambah Kategori</h2>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="space-y-4 max-w-xl">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama *</label><input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg px-3 py-2" required>@error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Slug</label><input type="text" name="slug" value="{{ old('slug') }}" class="w-full border rounded-lg px-3 py-2"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label><textarea name="description" rows="3" class="w-full border rounded-lg px-3 py-2">{{ old('description') }}</textarea></div>
        </div>
        <div class="flex items-center space-x-2 mt-6"><button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan</button><a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-800">Batal</a></div>
    </form>
</div>
@endsection
