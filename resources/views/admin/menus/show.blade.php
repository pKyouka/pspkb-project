@extends('layouts.admin')

@section('title', 'Kelola Menu: ' . $menu->name)

@section('content')
<div class="space-y-6">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">{{ $menu->name }}</h2>
            <p class="mt-1 text-sm text-slate-500">Edit judul, alamat, dan urutan menu yang tampil pada {{ $menu->location }} website.</p>
        </div>
        <a href="{{ route('admin.menus.index') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-700">Kembali ke daftar menu</a>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1fr_360px]">
        <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h3 class="font-bold text-slate-900">Item Menu</h3>
            <p class="mt-1 text-sm text-slate-500">Jika item menuju halaman CMS, perubahan URL akan otomatis memperbarui slug halaman tersebut.</p>
            <div class="mt-5 space-y-3">
                @forelse($menu->items as $item)
                    <form action="{{ route('admin.menus.items.update', $item) }}" method="POST" class="grid items-end gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 md:grid-cols-[1fr_1.4fr_90px_auto]">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="mb-1 block text-xs font-bold text-slate-500">Judul</label>
                            <input type="text" name="title" value="{{ $item->title }}" class="w-full border px-3 py-2 text-sm" required>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-bold text-slate-500">URL</label>
                            <input type="text" name="url" value="{{ $item->url }}" class="w-full border px-3 py-2 text-sm" placeholder="/halaman">
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-bold text-slate-500">Urutan</label>
                            <input type="number" name="order_number" value="{{ $item->order_number }}" min="0" class="w-full border px-3 py-2 text-sm">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-bold text-white hover:bg-blue-700">Simpan</button>
                            <button type="submit" form="delete-menu-item-{{ $item->id }}" class="rounded-xl bg-red-50 px-3 py-2.5 text-xs font-bold text-red-700 hover:bg-red-100">Hapus</button>
                        </div>
                    </form>
                    <form id="delete-menu-item-{{ $item->id }}" action="{{ route('admin.menus.items.delete', $item) }}" method="POST" onsubmit="return confirm('Hapus item menu ini?')">
                        @csrf
                        @method('DELETE')
                    </form>
                @empty
                    <div class="rounded-xl border border-dashed border-slate-300 p-8 text-center text-sm text-slate-500">Belum ada item menu.</div>
                @endforelse
            </div>
        </section>

        <aside class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h3 class="font-bold text-slate-900">Tambah Item</h3>
            <p class="mt-1 text-sm leading-6 text-slate-500">Gunakan URL relatif seperti <code>/berita</code> atau <code>/kontak</code>.</p>
            <form action="{{ route('admin.menus.items.add', $menu) }}" method="POST" class="mt-5 space-y-4">
                @csrf
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-500">Judul</label>
                    <input type="text" name="title" class="w-full border px-3 py-2 text-sm" required>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-500">URL</label>
                    <input type="text" name="url" class="w-full border px-3 py-2 text-sm" placeholder="/halaman">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-500">Urutan</label>
                    <input type="number" name="order_number" value="{{ ($menu->items->max('order_number') ?? 0) + 1 }}" min="0" class="w-full border px-3 py-2 text-sm">
                </div>
                <button type="submit" class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-bold text-white hover:bg-blue-700">Tambah Item</button>
            </form>
        </aside>
    </div>
</div>
@endsection
