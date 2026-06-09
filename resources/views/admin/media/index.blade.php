@extends('layouts.admin')

@section('title', 'Media')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800">Media</h2>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-2xl font-bold text-gray-900">Kelola Media</h3>
            <p class="mt-1 text-sm text-gray-500">Upload dan kelola gambar, dokumen, serta aset website.</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
        <div class="border-b border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900">Upload Media</h3>
            <p class="mt-1 text-sm text-gray-500">Pilih file gambar, PDF, atau SVG untuk ditambahkan ke library.</p>
        </div>

        <form action="{{ route('admin.media.upload') }}" method="POST" enctype="multipart/form-data" class="p-6" id="media-upload-form">
            @csrf

            <div class="grid gap-4 lg:grid-cols-[1fr_auto] lg:items-start">
                <div class="space-y-4">
                    <label for="media-file-input" class="group flex min-h-[140px] cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-blue-200 bg-gradient-to-br from-blue-50 via-white to-indigo-50 px-6 py-5 text-center transition hover:border-blue-400 hover:bg-blue-50">
                        <span class="mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-2xl shadow-sm ring-1 ring-blue-100">⬆️</span>
                        <span class="text-sm font-bold text-gray-900">Pilih file untuk diupload</span>
                        <span class="mt-1 text-xs text-gray-500">Format: image, PDF, SVG</span>
                        <span class="mt-3 rounded-full bg-white px-3 py-1 text-xs font-semibold text-blue-700 shadow-sm ring-1 ring-blue-100">Klik untuk memilih file</span>
                        <input type="file" name="file" id="media-file-input" class="sr-only" accept="image/*,.pdf,.svg" required>
                    </label>

                    <div id="media-preview" class="hidden overflow-hidden rounded-2xl border border-blue-100 bg-blue-50/60 p-4">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                            <div id="media-preview-frame" class="flex h-32 w-full items-center justify-center overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-blue-100 sm:w-44">
                                <img id="media-preview-image" src="" alt="Preview file" class="hidden h-full w-full object-cover">
                                <div id="media-preview-document" class="hidden text-center">
                                    <div class="mx-auto mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-blue-50 text-2xl">📄</div>
                                    <p class="text-xs font-semibold text-gray-500">Dokumen</p>
                                </div>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-bold uppercase tracking-wide text-blue-600">File dipilih</p>
                                <p id="media-preview-name" class="mt-1 truncate text-sm font-bold text-gray-900"></p>
                                <p id="media-preview-size" class="mt-1 text-xs font-medium text-gray-500"></p>
                                <button type="button" id="media-preview-reset" class="mt-3 rounded-lg bg-white px-3 py-2 text-xs font-bold text-red-700 shadow-sm ring-1 ring-red-100 hover:bg-red-50">Ganti file</button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" id="media-upload-button" class="inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:bg-gray-300 disabled:text-gray-500 disabled:shadow-none" disabled>
                    <span class="text-lg leading-none">+</span>
                    <span>Upload</span>
                </button>
            </div>

            @error('file')
                <p class="mt-3 rounded-xl bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">{{ $message }}</p>
            @enderror
        </form>
    </div>

    <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
        <div class="border-b border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900">Library Media</h3>
            <p class="mt-1 text-sm text-gray-500">Total {{ $media->total() ?? $media->count() }} media tersedia.</p>
        </div>

        @if($media->count())
            <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6">
                @foreach($media as $item)
                    <article class="group relative overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="relative h-36 overflow-hidden bg-gray-100">
                            @if($item->isImage())
                                <img src="{{ asset('storage/' . $item->path) }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" alt="{{ $item->filename }}">
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-50 via-indigo-50 to-gray-100">
                                    <div class="text-center">
                                        <div class="mx-auto mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-white text-2xl shadow-sm">📄</div>
                                        <p class="text-xs font-medium text-gray-500">Dokumen</p>
                                    </div>
                                </div>
                            @endif

                            <div class="absolute right-3 top-3 opacity-0 transition group-hover:opacity-100">
                                <form action="{{ route('admin.media.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus media ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-full bg-red-50 text-xs font-bold text-red-700 shadow-sm ring-1 ring-red-100 hover:bg-red-100">✕</button>
                                </form>
                            </div>
                        </div>

                        <div class="p-4">
                            <p class="truncate text-xs font-bold text-gray-900" title="{{ $item->filename }}">{{ $item->filename }}</p>
                            <p class="mt-1 text-xs font-medium text-gray-400">{{ $item->formatted_size }}</p>
                        </div>
                    </article>
                @endforeach
            </div>

            @if($media->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $media->links() }}
                </div>
            @endif
        @else
            <div class="p-12 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-blue-50 text-3xl">🖼️</div>
                <h3 class="text-lg font-bold text-gray-900">Belum ada media</h3>
                <p class="mt-2 text-sm text-gray-500">Upload file pertama untuk mengisi library media.</p>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('media-file-input');
        const preview = document.getElementById('media-preview');
        const image = document.getElementById('media-preview-image');
        const documentPreview = document.getElementById('media-preview-document');
        const name = document.getElementById('media-preview-name');
        const size = document.getElementById('media-preview-size');
        const reset = document.getElementById('media-preview-reset');
        const uploadButton = document.getElementById('media-upload-button');

        if (!input || !preview || !image || !documentPreview || !name || !size || !reset || !uploadButton) {
            return;
        }

        const formatSize = (bytes) => {
            if (!bytes) {
                return '0 KB';
            }

            const units = ['B', 'KB', 'MB', 'GB'];
            const index = Math.min(Math.floor(Math.log(bytes) / Math.log(1024)), units.length - 1);
            const value = bytes / Math.pow(1024, index);

            return `${value.toFixed(value >= 10 || index === 0 ? 0 : 2)} ${units[index]}`;
        };

        const resetPreview = () => {
            input.value = '';
            image.src = '';
            image.classList.add('hidden');
            documentPreview.classList.add('hidden');
            preview.classList.add('hidden');
            name.textContent = '';
            size.textContent = '';
            uploadButton.disabled = true;
        };

        input.addEventListener('change', () => {
            const file = input.files?.[0];

            if (!file) {
                resetPreview();
                return;
            }

            name.textContent = file.name;
            size.textContent = formatSize(file.size);
            preview.classList.remove('hidden');
            uploadButton.disabled = false;

            if (file.type.startsWith('image/')) {
                image.src = URL.createObjectURL(file);
                image.classList.remove('hidden');
                documentPreview.classList.add('hidden');
            } else {
                image.src = '';
                image.classList.add('hidden');
                documentPreview.classList.remove('hidden');
            }
        });

        reset.addEventListener('click', resetPreview);
    });
</script>
@endsection
