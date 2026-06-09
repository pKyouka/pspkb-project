@extends('layouts.admin')
@section('title', 'Kelola Menu: ' . $menu->name)
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">{{ $menu->name }} <span class="text-sm text-gray-500">({{ $menu->location }})</span></h2>
        <div class="space-x-2">
            <a href="{{ route('admin.menus.edit', $menu) }}" class="text-blue-600 hover:underline text-sm">Edit Menu</a>
            <a href="{{ route('admin.menus.index') }}" class="text-gray-600 hover:underline text-sm">← Kembali</a>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Existing Items -->
        <div>
            <h3 class="font-medium mb-3">Item Menu</h3>
            @forelse($menu->items as $item)
                <div class="border rounded-lg p-3 mb-2 flex justify-between items-center">
                    <div><p class="font-medium text-sm">{{ $item->title }}</p><p class="text-xs text-gray-500">{{ $item->url }}</p></div>
                    <div class="space-x-1">
                        <form action="{{ route('admin.menus.items.delete', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-red-500 text-xs">✕</button></form>
                    </div>
                </div>
                @foreach($item->children as $child)
                    <div class="border rounded-lg p-3 mb-2 ml-6 flex justify-between items-center">
                        <div><p class="text-sm">{{ $child->title }}</p><p class="text-xs text-gray-500">{{ $child->url }}</p></div>
                        <form action="{{ route('admin.menus.items.delete', $child) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-red-500 text-xs">✕</button></form>
                    </div>
                @endforeach
            @empty
                <p class="text-gray-500 text-sm">Belum ada item.</p>
            @endforelse
        </div>
        <!-- Add Item Form -->
        <div>
            <h3 class="font-medium mb-3">Tambah Item</h3>
            <form action="{{ route('admin.menus.items.add', $menu) }}" method="POST" class="border rounded-lg p-4 space-y-3">@csrf
                <div><label class="block text-xs text-gray-500 mb-1">Judul</label><input type="text" name="title" class="w-full border rounded px-3 py-2 text-sm" required></div>
                <div><label class="block text-xs text-gray-500 mb-1">URL</label><input type="text" name="url" class="w-full border rounded px-3 py-2 text-sm" placeholder="/halaman"></div>
                <div><label class="block text-xs text-gray-500 mb-1">Parent ID (opsional)</label><input type="number" name="parent_id" class="w-full border rounded px-3 py-2 text-sm" placeholder="Kosongkan jika root"></div>
                <div><label class="block text-xs text-gray-500 mb-1">Urutan</label><input type="number" name="order_number" value="0" class="w-full border rounded px-3 py-2 text-sm"></div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Tambah</button>
            </form>
        </div>
    </div>
</div>
@endsection
