@extends('layouts.admin')

@section('title', 'Tag')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800">Tag</h2>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-2xl font-bold text-gray-900">Kelola Tag</h3>
            <p class="mt-1 text-sm text-gray-500">Kelola label berita untuk memudahkan pengelompokan konten.</p>
        </div>
        <a href="{{ route('admin.tags.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <span class="text-lg leading-none">+</span>
            <span>Tambah Tag</span>
        </a>
    </div>

    <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
    <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-black text-slate-900">Daftar Tag</h3>
            <p class="text-sm text-slate-500">Total {{ $tags->total() ?? $tags->count() }} tag tersedia.</p>
        </div>
    </div>

    <div class="flex flex-wrap gap-3">
        @forelse($tags as $tag)
            <div class="group inline-flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-200 hover:bg-white hover:shadow-md">
                <div class="grid h-9 w-9 place-items-center rounded-xl bg-blue-100 text-sm font-black text-blue-700">#</div>
                <div>
                    <div class="text-sm font-extrabold text-slate-900">{{ $tag->name }}</div>
                    <div class="text-xs font-semibold text-slate-500">{{ $tag->posts_count ?? 0 }} postingan</div>
                </div>
                <div class="ml-2 flex items-center gap-1">
                    <a href="{{ route('admin.tags.edit', $tag) }}" class="rounded-lg bg-blue-50 px-2.5 py-1.5 text-xs font-bold text-blue-700 hover:bg-blue-100">Edit</a>
                    <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" onsubmit="return confirm('Hapus tag ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-lg bg-rose-50 px-2.5 py-1.5 text-xs font-bold text-rose-700 hover:bg-rose-100">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="w-full rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-10 text-center">
                <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-white text-2xl shadow-sm">🏷️</div>
                <h3 class="mt-4 text-base font-black text-slate-900">Belum ada tag</h3>
                <p class="mt-1 text-sm text-slate-500">Tambahkan tag pertama untuk mulai mengelompokkan berita.</p>
                <a href="{{ route('admin.tags.create') }}" class="mt-5 inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <span class="text-lg leading-none">+</span>
                    <span>Tambah Tag</span>
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $tags->links() }}</div>
    </div>
</div>
@endsection
