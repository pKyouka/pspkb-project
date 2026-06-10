@extends('layouts.frontend')
@section('title', $category->name)
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-2">{{ __('frontend.common.category') }}: {{ $category->name }}</h1>
    @if($category->description)<p class="text-gray-600 mb-8">{{ $category->description }}</p>@endif
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($posts as $post)
            <a href="{{ route('posts.show', $post->slug) }}" class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                @if($post->thumbnail)<img src="{{ asset('storage/' . $post->thumbnail) }}" class="w-full h-48 object-cover" alt="{{ $post->title }}">@else<div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">📰</div>@endif
                <div class="p-4"><p class="text-xs text-gray-500 mb-1">{{ $post->published_at?->format('d M Y') }}</p><h3 class="font-semibold text-lg mb-2">{{ $post->title }}</h3><p class="text-gray-600 text-sm">{{ \Illuminate\Support\Str::limit($post->excerpt, 100) }}</p></div>
            </a>
        @empty
            <p class="text-gray-500 col-span-3 text-center py-8">{{ __('frontend.posts.category_empty') }}</p>
        @endforelse
    </div>
    <div class="mt-8">{{ $posts->links() }}</div>
</div>
@endsection
