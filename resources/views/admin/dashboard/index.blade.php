@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
@endsection

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-500">Total Berita</div>
        <div class="text-2xl font-bold text-gray-800">{{ $stats['total_posts'] }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-500">Total Halaman</div>
        <div class="text-2xl font-bold text-gray-800">{{ $stats['total_pages'] }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-500">Total Pengguna</div>
        <div class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-500">Total Pesan</div>
        <div class="text-2xl font-bold text-gray-800">{{ $stats['total_messages'] }}</div>
        @if($stats['unread_messages'] > 0)
            <span class="text-xs text-red-500">{{ $stats['unread_messages'] }} belum dibaca</span>
        @endif
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-500">Total Media</div>
        <div class="text-2xl font-bold text-gray-800">{{ $stats['total_media'] }}</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Posts -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Berita Terbaru</h3>
        </div>
        <div class="p-6">
            @forelse($recentPosts as $post)
                <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                    <div>
                        <p class="font-medium text-sm">{{ $post->title }}</p>
                        <p class="text-xs text-gray-500">{{ $post->created_at?->diffForHumans() }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $post->status === 'published' ? 'Published' : 'Draft' }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Belum ada berita.</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Messages -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Pesan Terbaru</h3>
        </div>
        <div class="p-6">
            @forelse($recentMessages as $msg)
                <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                    <div>
                        <p class="font-medium text-sm">{{ $msg->name }}</p>
                        <p class="text-xs text-gray-500">{{ $msg->subject }}</p>
                    </div>
                    <a href="{{ route('admin.messages.show', $msg->id) }}" class="text-xs text-blue-600 hover:underline">Lihat</a>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Tidak ada pesan baru.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
