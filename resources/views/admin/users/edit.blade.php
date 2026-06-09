@extends('layouts.admin')
@section('title', 'Edit Pengguna')
@section('content')
<div class="bg-white rounded-lg shadow p-6"><h2 class="text-lg font-semibold mb-4">Edit: {{ $user->name }}</h2>
    <form action="{{ route('admin.users.update', $user) }}" method="POST"><div class="space-y-4 max-w-xl">@csrf @method('PUT')
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama *</label><input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded-lg px-3 py-2" required></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Email *</label><input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded-lg px-3 py-2" required></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Password (kosongkan jika tidak diubah)</label><input type="password" name="password" class="w-full border rounded-lg px-3 py-2"></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label><input type="password" name="password_confirmation" class="w-full border rounded-lg px-3 py-2"></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Role *</label><select name="role" class="w-full border rounded-lg px-3 py-2"><option value="author" {{ old('role', $user->role) === 'author' ? 'selected' : '' }}>Author</option><option value="editor" {{ old('role', $user->role) === 'editor' ? 'selected' : '' }}>Editor</option><option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option><option value="super_admin" {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>Super Admin</option></select></div>
    </div><div class="flex items-center space-x-2 mt-6"><button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Perbarui</button><a href="{{ route('admin.users.index') }}" class="text-gray-600">Batal</a></div></form>
</div>
@endsection
