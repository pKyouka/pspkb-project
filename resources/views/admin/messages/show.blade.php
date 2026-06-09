@extends('layouts.admin')
@section('title', 'Lihat Pesan')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <a href="{{ route('admin.messages.index') }}" class="text-blue-600 hover:underline text-sm mb-4 inline-block">← Kembali</a>
    <div class="border rounded-lg p-6">
        <div class="flex justify-between mb-4">
            <div><h3 class="text-lg font-semibold">{{ $message->subject }}</h3><p class="text-sm text-gray-500">Dari: {{ $message->name }} <{{ $message->email }}></p></div>
            <span class="text-sm text-gray-500">{{ $message->created_at?->format('d/m/Y H:i') }}</span>
        </div>
        @if($message->phone)<p class="text-sm text-gray-500 mb-4">Telepon: {{ $message->phone }}</p>@endif
        <div class="prose prose-sm max-w-none border-t pt-4"><p>{!! nl2br(e($message->message)) !!}</p></div>
    </div>
    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="mt-4" onsubmit="return confirm('Hapus pesan ini?')">
        @csrf @method('DELETE')
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-600">Hapus Pesan</button>
    </form>
</div>
@endsection
