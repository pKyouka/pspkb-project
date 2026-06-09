@extends('layouts.frontend')
@section('title', $page->title)
@section('description', $page->meta_description ?? '')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <nav class="text-sm text-gray-500 mb-6"><a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a> / <span class="text-gray-800">{{ $page->title }}</span></nav>
    @if($page->featured_image)
        <img src="{{ asset('storage/' . $page->featured_image) }}" class="w-full h-64 object-cover rounded-lg mb-6" alt="{{ $page->title }}">
    @endif
    <h1 class="text-3xl font-bold mb-6">{{ $page->title }}</h1>
    <div class="prose prose-lg max-w-none">{!! $page->content !!}</div>
</div>
@endsection
