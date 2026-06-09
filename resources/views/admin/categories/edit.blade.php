@extends('layouts.admin')
@section('title', 'Edit Kategori')
@section('header', '')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold mb-4">Edit: {{ $category->name }}</h2>
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf @method('PUT')
        <div class="space-y-4 max-w-xl">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama *</label><input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full border rounded-lg px-3 py-2" required>@error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Slug</label><input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="w-full border rounded-lg px-3 py-2"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label><textarea name="description" rows="3" class="w-full border rounded-lg px-3 py-2">{{ old('description', $category->description) }}</textarea></div>
        </div>
        <div class="flex items-center space-x-2 mt-6"><button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Perbarui</button><a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-800">Batal</a></div>
    </form>
</div>
@endsection
