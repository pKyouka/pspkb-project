@extends('layouts.admin')

@section('title', 'Pengguna')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800">Pengguna</h2>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-2xl font-bold text-gray-900">Kelola Pengguna</h3>
            <p class="mt-1 text-sm text-gray-500">Kelola akun admin, editor, dan author.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <span class="text-lg leading-none">+</span>
            <span>Tambah User</span>
        </a>
    </div>

    <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-100 p-6">
        <h3 class="text-lg font-black text-slate-900">Daftar Pengguna</h3>
        <p class="mt-1 text-sm text-slate-500">Total {{ $users->total() ?? $users->count() }} pengguna terdaftar.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-4 text-left font-black">Nama</th>
                    <th class="px-6 py-4 text-left font-black">Email</th>
                    <th class="px-6 py-4 text-left font-black">Role</th>
                    <th class="px-6 py-4 text-right font-black">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $u)
                    <tr class="transition hover:bg-blue-50/40">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="grid h-10 w-10 place-items-center rounded-2xl bg-blue-100 font-black text-blue-700">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                                <span class="font-extrabold text-slate-900">{{ $u->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-500">{{ $u->email }}</td>
                        <td class="px-6 py-4">
                            <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">{{ ucfirst(str_replace('_', ' ', $u->role)) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $u) }}" class="rounded-xl bg-blue-50 px-3 py-2 text-xs font-bold text-blue-700 hover:bg-blue-100">Edit</a>
                                @if($u->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-xl bg-rose-50 px-3 py-2 text-xs font-bold text-rose-700 hover:bg-rose-100">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-14 text-center">
                            <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-slate-50 text-2xl">👥</div>
                            <h3 class="mt-4 text-base font-black text-slate-900">Belum ada pengguna</h3>
                            <p class="mt-1 text-sm text-slate-500">Tambahkan pengguna pertama untuk mengatur akses CMS.</p>
                            <a href="{{ route('admin.users.create') }}" class="mt-5 inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <span class="text-lg leading-none">+</span>
                                <span>Tambah Pengguna</span>
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="border-t border-slate-100 p-6">{{ $users->links() }}</div>
    </div>
</div>
@endsection
