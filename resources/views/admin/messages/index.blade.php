@extends('layouts.admin')
@section('title', 'Pesan')
@section('header')
    <h2 class="text-xl font-semibold text-gray-800">Pesan Kontak</h2>
@endsection
@section('content')
<div class="bg-white rounded-lg shadow"><div class="p-6">
    <table class="w-full text-sm"><thead><tr class="border-b"><th class="text-left py-3 px-2">Nama</th><th class="text-left py-3 px-2">Email</th><th class="text-left py-3 px-2">Subjek</th><th class="text-left py-3 px-2">Tanggal</th><th class="text-right py-3 px-2">Aksi</th></tr></thead>
    <tbody>@forelse($messages as $msg)
        <tr class="border-b hover:bg-gray-50 {{ $msg->read_at ? '' : 'bg-blue-50' }}">
            <td class="py-3 px-2 font-medium">{{ $msg->name }}</td>
            <td class="py-3 px-2 text-gray-500">{{ $msg->email }}</td>
            <td class="py-3 px-2">{{ $msg->subject }}</td>
            <td class="py-3 px-2 text-gray-500">{{ $msg->created_at?->format('d/m/Y H:i') }}</td>
            <td class="py-3 px-2 text-right space-x-2">
                <a href="{{ route('admin.messages.show', $msg) }}" class="text-blue-600 hover:underline text-xs">Lihat</a>
                <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-red-600 hover:underline text-xs">Hapus</button></form>
            </td>
        </tr>
    @empty<tr><td colspan="5" class="py-8 text-center text-gray-500">Belum ada pesan.</td></tr>@endforelse</tbody></table>
    <div class="mt-4">{{ $messages->links() }}</div>
</div></div>
@endsection
