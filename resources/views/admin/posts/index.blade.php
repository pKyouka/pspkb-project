@extends('layouts.admin')

@section('title', 'Berita & Artikel')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800">Berita & Artikel</h2>
@endsection

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">Kelola Berita & Artikel</h3>
                <p class="text-sm text-gray-500 mt-1">Kelola berita dan artikel Unit Layanan Disabilitas. Aktivitas memiliki menu pengelolaan tersendiri.</p>
            </div>
            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <span class="text-lg leading-none">+</span>
                <span>Tambah Berita/Artikel</span>
            </a>
        </div>

        @if($posts->count())
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
                @foreach($posts as $post)
                    <article class="group flex h-full flex-col overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-1 hover:shadow-lg">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="block">
                            <div class="relative h-32 overflow-hidden bg-gray-100">
                                @if(!empty($post->thumbnail))
                                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-50 via-indigo-50 to-gray-100">
                                        <div class="text-center">
                                            <div class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-white text-lg shadow-sm">📰</div>
                                            <p class="text-xs font-medium text-gray-500">Belum ada gambar</p>
                                        </div>
                                    </div>
                                @endif

                                <div class="absolute left-3 top-3">
                                    <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold shadow-sm {{ $post->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ $post->status === 'published' ? 'Published' : 'Draft' }}
                                    </span>
                                </div>
                            </div>
                        </a>

                        <div class="flex flex-1 flex-col p-4">
                            <div class="mb-2 flex flex-wrap items-center gap-1.5 text-[11px] text-gray-500">
                                <span class="rounded-full bg-gray-100 px-2 py-1 font-medium text-gray-700">{{ $post->category?->name ?? 'Tanpa Kategori' }}</span>
                                <span>•</span>
                                <span>{{ $post->created_at?->format('d/m/Y') }}</span>
                            </div>

                            <h4 class="line-clamp-2 text-sm font-bold leading-5 text-gray-900">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="hover:text-blue-600">
                                    {{ $post->title }}
                                </a>
                            </h4>

                            <p class="mt-2 min-h-[40px] line-clamp-2 text-xs leading-5 text-gray-600">
                                {{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 120) }}
                            </p>

                            <div class="mt-auto border-t pt-3">
                                <div class="grid grid-cols-3 gap-2">
                                    @if($post->status === 'draft')
                                        <form action="{{ route('admin.posts.publish', $post) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-green-50 px-2 py-1.5 text-[11px] font-semibold text-green-700 hover:bg-green-100">Publish</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.posts.unpublish', $post) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-yellow-50 px-2 py-1.5 text-[11px] font-semibold text-yellow-700 hover:bg-yellow-100">Unpub</button>
                                        </form>
                                    @endif

                                    <a href="{{ route('admin.posts.edit', $post) }}" class="inline-flex items-center justify-center rounded-lg bg-blue-50 px-2 py-1.5 text-[11px] font-semibold text-blue-700 hover:bg-blue-100">Edit</a>

                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-red-50 px-2 py-1.5 text-[11px] font-semibold text-red-700 hover:bg-red-100">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if($posts->hasPages())
                <div class="rounded-2xl bg-white px-4 py-3 shadow-sm ring-1 ring-gray-200">
                    {{ $posts->links() }}
                </div>
            @endif
        @else
            <div class="rounded-2xl bg-white p-12 text-center shadow-sm ring-1 ring-gray-200">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-blue-50 text-3xl">📰</div>
                <h3 class="text-lg font-bold text-gray-900">Belum ada berita</h3>
                <p class="mt-2 text-sm text-gray-500">Mulai buat berita pertama dengan thumbnail agar tampilannya lebih menarik.</p>
                <a href="{{ route('admin.posts.create') }}" class="mt-6 inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                    + Tambah Berita
                </a>
            </div>
        @endif
    </div>
@endsection
