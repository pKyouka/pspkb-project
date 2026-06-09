@extends('layouts.admin')
@section('title', 'Tambah Menu')
@section('content')
<div class="bg-white rounded-lg shadow p-6"><h2 class="text-lg font-semibold mb-4">Tambah Menu</h2>
    <form action="{{ route('admin.menus.store') }}" method="POST"><div class="space-y-4 max-w-xl">@csrf
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama *</label><input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg px-3 py-2" required></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Lokasi *</label><select name="location" class="w-full border rounded-lg px-3 py-2"><option value="header">Header Menu</option><option value="footer">Footer Menu</option></select></div>
    </div><div class="flex items-center space-x-2 mt-6"><button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan</button><a href="{{ route('admin.menus.index') }}" class="text-gray-600">Batal</a></div></form>
</div>
@endsection
