@extends('layouts.admin')

@section('title', 'Menu')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800">Menu</h2>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-2xl font-bold text-gray-900">Kelola Menu</h3>
            <p class="mt-1 text-sm text-gray-500">Kelola struktur navigasi header dan footer website.</p>
        </div>
        <a href="{{ route('admin.menus.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <span class="text-lg leading-none">+</span>
            <span>Tambah Menu</span>
        </a>
    </div>

    <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-100 p-6">
        <h3 class="text-lg font-black text-slate-900">Daftar Menu</h3>
        <p class="mt-1 text-sm text-slate-500">Kelola menu lalu susun item navigasinya.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-4 text-left font-black">Nama</th>
                    <th class="px-6 py-4 text-left font-black">Lokasi</th>
                    <th class="px-6 py-4 text-left font-black">Item</th>
                    <th class="px-6 py-4 text-right font-black">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($menus as $menu)
                    <tr class="transition hover:bg-blue-50/40">
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.menus.show', $menu) }}" class="font-extrabold text-slate-900 hover:text-blue-700">{{ $menu->name }}</a>
                        </td>
                        <td class="px-6 py-4">
                            <span class="rounded-full bg-cyan-100 px-3 py-1 text-xs font-bold text-cyan-700">{{ $menu->location }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">{{ $menu->allItems()->count() }} item</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.menus.show', $menu) }}" class="rounded-xl bg-blue-50 px-3 py-2 text-xs font-bold text-blue-700 hover:bg-blue-100">Kelola</a>
                                <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-xl bg-rose-50 px-3 py-2 text-xs font-bold text-rose-700 hover:bg-rose-100">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-14 text-center">
                            <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-slate-50 text-2xl">☰</div>
                            <h3 class="mt-4 text-base font-black text-slate-900">Belum ada menu</h3>
                            <p class="mt-1 text-sm text-slate-500">Tambahkan menu pertama untuk navigasi website.</p>
                            <a href="{{ route('admin.menus.create') }}" class="mt-5 inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <span class="text-lg leading-none">+</span>
                                <span>Tambah Menu</span>
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>
</div>
@endsection
