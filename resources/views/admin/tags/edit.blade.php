@extends('layouts.admin')
@section('title', 'Edit Tag')
@section('content')
<div class="bg-white rounded-lg shadow p-6"><h2 class="text-lg font-semibold mb-4">Edit: {{ $tag->name }}</h2>
    <form action="{{ route('admin.tags.update', $tag) }}" method="POST"><div class="space-y-4 max-w-xl">@csrf @method('PUT')
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama *</label><input type="text" name="name" value="{{ old('name', $tag->name) }}" class="w-full border rounded-lg px-3 py-2" required></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Slug</label><input type="text" name="slug" value="{{ old('slug', $tag->slug) }}" class="w-full border rounded-lg px-3 py-2"></div>
    </div><div class="flex items-center space-x-2 mt-6"><button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Perbarui</button><a href="{{ route('admin.tags.index') }}" class="text-gray-600">Batal</a></div></form>
</div>
@endsection
