@extends('layouts.admin')

@section('title', 'Banner')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800">Banner</h2>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-2xl font-bold text-gray-900">Kelola Banner</h3>
            <p class="mt-1 text-sm text-gray-500">Kelola banner promosi/hero untuk halaman publik.</p>
        </div>
        <a href="{{ route('admin.banners.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <span class="text-lg leading-none">+</span>
            <span>Tambah Banner</span>
        </a>
    </div>

    <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-100 p-6">
        <h3 class="text-lg font-black text-slate-900">Daftar Banner</h3>
        <p class="mt-1 text-sm text-slate-500">Atur status banner aktif/nonaktif.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-4 text-left font-black">Judul</th>
                    <th class="px-6 py-4 text-left font-black">Status</th>
                    <th class="px-6 py-4 text-right font-black">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($banners as $b)
                    <tr class="transition hover:bg-blue-50/40">
                        <td class="px-6 py-4 font-extrabold text-slate-900">{{ $b->title }}</td>
                        <td class="px-6 py-4">
                            <span class="rounded-full px-3 py-1 text-xs font-bold {{ $b->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ $b->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.banners.edit', $b) }}" class="rounded-xl bg-blue-50 px-3 py-2 text-xs font-bold text-blue-700 hover:bg-blue-100">Edit</a>
                                <form action="{{ route('admin.banners.destroy', $b) }}" method="POST" onsubmit="return confirm('Hapus banner ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-xl bg-rose-50 px-3 py-2 text-xs font-bold text-rose-700 hover:bg-rose-100">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-14 text-center">
                            <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-slate-50 text-2xl">🖼️</div>
                            <h3 class="mt-4 text-base font-black text-slate-900">Belum ada banner</h3>
                            <p class="mt-1 text-sm text-slate-500">Tambahkan banner pertama untuk mempercantik halaman publik.</p>
                            <a href="{{ route('admin.banners.create') }}" class="mt-5 inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <span class="text-lg leading-none">+</span>
                                <span>Tambah Banner</span>
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="border-t border-slate-100 p-6">{{ $banners->links() }}</div>
    </div>
</div>
@endsection
