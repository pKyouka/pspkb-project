<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @php
        $isActivity = $isActivity ?? false;
        $contentLabel = $isActivity ? 'Aktivitas' : 'Berita / Artikel';
    @endphp
    <div class="lg:col-span-2 space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul *</label>
            <input type="text" id="post-title" name="title" value="{{ old('title', $post->title ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <div class="flex items-center justify-between mb-1">
                <label class="block text-sm font-medium text-gray-700">Slug</label>
                <span class="text-xs text-gray-400">Otomatis dari judul, tetap bisa diedit manual</span>
            </div>
            <input type="text" id="post-slug" name="slug" value="{{ old('slug', $post->slug ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label>
            <textarea id="post-excerpt" name="excerpt" rows="3" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
        </div>
        <div>
            <div class="flex items-center justify-between mb-2">
                <label class="block text-sm font-semibold text-gray-700">Konten</label>
                <span class="text-xs text-gray-400">Editor visual lengkap</span>
            </div>

            <textarea id="post-content" name="content" class="hidden">{{ old('content', $post->content ?? '') }}</textarea>

            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <div id="post-content-editor" class="content-editor min-h-[460px]"></div>
            </div>
        </div>

    </div>
    <div class="space-y-4">
        @php
            $selectedStatus = old('status', $post->status ?? 'draft');
            $selectedCategoryId = old('category_id', $post->category_id ?? '');
            $tagValue = old('tags_input', isset($post) ? $post->tags->pluck('name')->implode(', ') : '');
        @endphp

        <div x-data="{ status: @js($selectedStatus) }" :class="status === 'published' ? 'border-emerald-200 bg-emerald-50/90' : 'border-amber-200 bg-amber-50/90'" class="rounded-2xl border p-4 shadow-sm transition">
            <div class="mb-3 flex items-center justify-between gap-3">
                <div>
                    <label class="block text-sm font-bold text-gray-800">Status *</label>
                    <p class="mt-0.5 text-xs" :class="status === 'published' ? 'text-emerald-700' : 'text-amber-700'" x-text="status === 'published' ? 'Konten tampil di website publik.' : 'Masih draft, aman untuk diedit dulu.'"></p>
                </div>
                <span class="rounded-full px-3 py-1 text-xs font-extrabold uppercase tracking-wide" :class="status === 'published' ? 'bg-emerald-600 text-white' : 'bg-amber-500 text-white'" x-text="status"></span>
            </div>
            <select name="status" x-model="status" class="w-full border rounded-lg px-3 py-2 font-semibold">
                <option value="draft" {{ $selectedStatus === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ $selectedStatus === 'published' ? 'selected' : '' }}>Published</option>
            </select>
        </div>

        <div class="rounded-2xl border border-sky-200 bg-sky-50/90 p-4 shadow-sm">
            <div class="mb-3 flex items-center gap-2">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-sky-500 text-white">🏷️</span>
                <div>
                    <label class="block text-sm font-bold text-gray-800">Kategori</label>
                    <p class="text-xs text-sky-700">{{ $isActivity ? 'Aktivitas otomatis tampil di halaman Aktivitas/Kegiatan.' : 'Pilih Berita atau Artikel sesuai jenis konten.' }}</p>
                </div>
            </div>
            @if($isActivity)
                <input type="hidden" name="category_id" value="{{ $activityCategory->id }}">
                <div class="flex items-center justify-between rounded-xl border border-sky-200 bg-white px-4 py-3">
                    <span class="text-sm font-bold text-sky-900">{{ $activityCategory->name }}</span>
                    <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-bold text-sky-700">Otomatis</span>
                </div>
            @else
                <select name="category_id" class="w-full border rounded-lg px-3 py-2">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $selectedCategoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            @endif
        </div>

        <div class="rounded-2xl border border-violet-200 bg-violet-50/90 p-4 shadow-sm">
            <div class="mb-3 flex items-center gap-2">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-violet-500 text-white">#</span>
                <div>
                    <label class="block text-sm font-bold text-gray-800">Tag</label>
                    <p class="text-xs text-violet-700">Pisahkan dengan koma, contoh: Kegiatan, Sekolah.</p>
                </div>
            </div>
            <input type="text" name="tags_input" value="{{ $tagValue }}" class="w-full border rounded-lg px-3 py-2" placeholder="Tag1, Tag2, Tag3">
        </div>

        <div class="rounded-2xl border border-indigo-200 bg-indigo-50/90 p-4 shadow-sm">
            <div class="mb-3 flex items-center gap-2">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-indigo-500 text-white">🖼️</span>
                <div>
                    <label class="block text-sm font-bold text-gray-800">Thumbnail</label>
                    <p class="text-xs text-indigo-700">Gambar utama untuk kartu {{ strtolower($contentLabel) }}.</p>
                </div>
            </div>
            <div class="rounded-2xl border border-indigo-200 bg-white p-3 shadow-sm">
                <input type="file" id="post-thumbnail" name="thumbnail" class="sr-only" accept="image/*">
                <input type="hidden" id="post-thumbnail-media-path" name="thumbnail_media_path" value="{{ old('thumbnail_media_path') }}">
                <button type="button" id="post-thumbnail-picker" class="group flex w-full cursor-pointer items-center gap-3 rounded-xl border border-dashed border-indigo-300 bg-gradient-to-br from-indigo-50 to-white p-3 text-left transition hover:border-indigo-500 hover:from-indigo-100 hover:shadow-md">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-indigo-600 text-lg text-white shadow-md shadow-indigo-200 transition group-hover:scale-105 group-hover:bg-indigo-700">🖼️</span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-sm font-extrabold text-indigo-900">Pilih / Ganti Thumbnail</span>
                        <span id="post-thumbnail-filename" class="mt-0.5 block truncate text-xs font-semibold text-indigo-600">
                            {{ !empty($post->thumbnail) ? basename($post->thumbnail) : 'Ambil dari galeri atau upload baru' }}
                        </span>
                    </span>
                    <span class="hidden rounded-full bg-indigo-600 px-3 py-1 text-xs font-bold text-white shadow-sm sm:inline-flex">Pilih</span>
                </button>
            </div>
            <div class="mt-3 overflow-hidden rounded-xl border border-indigo-100 bg-white">
                <img id="post-thumbnail-preview" src="{{ !empty($post->thumbnail) ? asset('storage/' . $post->thumbnail) : '' }}" class="{{ !empty($post->thumbnail) ? 'block' : 'hidden' }} h-40 w-full object-cover" alt="Preview thumbnail">
                <div id="post-thumbnail-empty" class="{{ !empty($post->thumbnail) ? 'hidden' : 'flex' }} h-28 items-center justify-center text-xs text-gray-500">
                    Belum ada thumbnail
                </div>
            </div>
        </div>
        <div id="pspkb-media-picker-modal" class="fixed inset-0 z-[9998] hidden items-center justify-center bg-slate-900/60 p-4">
            <div class="w-full max-w-5xl overflow-hidden rounded-2xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b px-5 py-4">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-900">Pilih Gambar</h3>
                        <p class="text-xs text-gray-500">Gunakan gambar dari galeri atau upload baru.</p>
                    </div>
                    <button type="button" id="pspkb-media-picker-close" class="rounded-full bg-gray-100 px-3 py-1 text-sm font-bold text-gray-700 hover:bg-gray-200">✕</button>
                </div>

                <div class="border-b px-5 pt-4">
                    <div class="flex gap-2">
                        <button type="button" data-media-tab="gallery" class="pspkb-media-tab rounded-t-xl bg-indigo-600 px-4 py-2 text-sm font-bold text-white">Galeri</button>
                        <button type="button" data-media-tab="upload" class="pspkb-media-tab rounded-t-xl bg-gray-100 px-4 py-2 text-sm font-bold text-gray-600">Upload</button>
                    </div>
                </div>

                <div class="max-h-[70vh] overflow-y-auto p-5">
                    <div id="pspkb-media-gallery-panel">
                        <div id="pspkb-media-gallery-loading" class="py-10 text-center text-sm text-gray-500">Memuat galeri...</div>
                        <div id="pspkb-media-gallery-empty" class="hidden rounded-xl border border-dashed border-gray-300 py-10 text-center text-sm text-gray-500">Belum ada gambar di galeri.</div>
                        <div id="pspkb-media-gallery-grid" class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5"></div>
                    </div>

                    <div id="pspkb-media-upload-panel" class="hidden">
                        <label class="flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-indigo-300 bg-indigo-50/70 px-6 py-12 text-center hover:border-indigo-500 hover:bg-indigo-50">
                            <span class="text-4xl">⬆️</span>
                            <span class="mt-3 text-sm font-extrabold text-indigo-900">Upload gambar baru</span>
                            <span id="pspkb-media-upload-status" class="mt-1 text-xs font-semibold text-indigo-600">PNG/JPG/WebP/SVG maksimal 5MB</span>
                            <input type="file" id="pspkb-media-upload-input" class="sr-only" accept="image/jpeg,image/png,image/webp,image/svg+xml">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-rose-200 bg-rose-50/90 p-4 shadow-sm">
            <div class="mb-3 flex items-center gap-2">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-rose-500 text-white">🔎</span>
                <div>
                    <h4 class="text-sm font-bold text-gray-800">SEO</h4>
                    <p class="text-xs text-rose-700">Preview mesin pencari, otomatis ikut judul/konten.</p>
                </div>
            </div>
            <div class="space-y-3">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Meta Title</label>
                    <input type="text" id="post-meta-title" name="meta_title" value="{{ old('meta_title', $post->meta_title ?? '') }}" class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Meta Description</label>
                    <textarea id="post-meta-description" name="meta_description" rows="3" class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                </div>

@once
    @push('scripts')
        <style>
            .content-editor .ql-toolbar,
            .ql-toolbar.ql-snow {
                border: 0;
                border-bottom: 1px solid #e5e7eb;
                border-radius: .75rem .75rem 0 0;
                background: linear-gradient(#fff, #f9fafb);
                padding: .75rem;
            }

            .content-editor .ql-container,
            .ql-container.ql-snow {
                border: 0;
                border-radius: 0 0 .75rem .75rem;
                font-size: 1rem;
            }

            .content-editor .ql-editor {
                min-height: 460px;
                padding: 1.5rem;
                line-height: 1.8;
                color: #1f2937;
            }

            .content-editor .ql-editor.ql-blank::before {
                color: #9ca3af;
                font-style: normal;
                left: 1.5rem;
                right: 1.5rem;
            }

            .content-editor .ql-editor h2 {
                font-size: 1.5rem;
            }

            .content-editor .ql-editor h3 {
                font-size: 1.25rem;
            }

            .content-editor .ql-editor h4 {
                font-size: 1.125rem;
            }

            .content-editor .ql-editor img {
                max-width: 100%;
                border-radius: .75rem;
                margin: .75rem 0;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const titleInput = document.getElementById('post-title');
                const slugInput = document.getElementById('post-slug');
                const excerptInput = document.getElementById('post-excerpt');
                const contentInput = document.getElementById('post-content');
                const metaTitleInput = document.getElementById('post-meta-title');
                const metaDescriptionInput = document.getElementById('post-meta-description');
                const thumbnailInput = document.getElementById('post-thumbnail');
                const thumbnailPreview = document.getElementById('post-thumbnail-preview');
                const thumbnailEmpty = document.getElementById('post-thumbnail-empty');
                const thumbnailFilename = document.getElementById('post-thumbnail-filename');
                const thumbnailPicker = document.getElementById('post-thumbnail-picker');
                const thumbnailMediaPath = document.getElementById('post-thumbnail-media-path');

                let slugEdited = !!slugInput.value.trim();
                let metaTitleEdited = !!metaTitleInput.value.trim();
                let metaDescriptionEdited = !!metaDescriptionInput.value.trim();
                let excerptEdited = !!excerptInput.value.trim();

                const slugify = (value) => value
                    .toString()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .toLowerCase()
                    .trim()
                    .replace(/&/g, '-dan-')
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '')
                    .substring(0, 255);

                const stripHtml = (html) => {
                    const tmp = document.createElement('div');
                    tmp.innerHTML = html || '';
                    return (tmp.textContent || tmp.innerText || '').replace(/\s+/g, ' ').trim();
                };

                const limitText = (text, limit) => {
                    if (!text) return '';
                    return text.length > limit ? text.substring(0, limit).replace(/\s+\S*$/, '') : text;
                };

                const syncSeoFields = () => {
                    const title = titleInput.value.trim();
                    const contentText = stripHtml(contentInput.value);
                    const descriptionSource = excerptInput.value.trim() || contentText;

                    if (!slugEdited) slugInput.value = slugify(title);
                    if (!metaTitleEdited) metaTitleInput.value = limitText(title, 60);
                    if (!excerptEdited && contentText) excerptInput.value = limitText(contentText, 160);
                    if (!metaDescriptionEdited) metaDescriptionInput.value = limitText(descriptionSource, 160);
                };

                titleInput.addEventListener('input', syncSeoFields);
                slugInput.addEventListener('input', function () {
                    slugEdited = !!this.value.trim();
                    this.value = slugify(this.value);
                });
                metaTitleInput.addEventListener('input', function () {
                    metaTitleEdited = !!this.value.trim();
                });
                metaDescriptionInput.addEventListener('input', function () {
                    metaDescriptionEdited = !!this.value.trim();
                });
                excerptInput.addEventListener('input', function () {
                    excerptEdited = !!this.value.trim();
                    if (!metaDescriptionEdited) {
                        metaDescriptionInput.value = limitText(this.value.trim(), 160);
                    }
                });

                const setThumbnailPreview = (url, label, path = '') => {
                    if (thumbnailFilename) thumbnailFilename.textContent = label;
                    if (thumbnailMediaPath) thumbnailMediaPath.value = path;
                    if (thumbnailInput) thumbnailInput.value = '';

                    thumbnailPreview.src = url;
                    thumbnailPreview.classList.remove('hidden');
                    thumbnailPreview.classList.add('block');
                    thumbnailEmpty.classList.add('hidden');
                    thumbnailEmpty.classList.remove('flex');
                };

                if (thumbnailPicker) {
                    thumbnailPicker.addEventListener('click', function () {
                        window.pspkbOpenMediaPicker?.({
                            mode: 'thumbnail',
                            onSelect: (media) => setThumbnailPreview(media.url, media.filename, media.path),
                        });
                    });
                }

                if (thumbnailInput && thumbnailPreview && thumbnailEmpty) {
                    thumbnailInput.addEventListener('change', function () {
                        const file = this.files && this.files[0];

                        if (!file) return;

                        if (thumbnailMediaPath) thumbnailMediaPath.value = '';
                        if (thumbnailFilename) {
                            thumbnailFilename.textContent = `${file.name} • ${(file.size / 1024 / 1024).toFixed(2)} MB`;
                        }

                        thumbnailPreview.src = URL.createObjectURL(file);
                        thumbnailPreview.classList.remove('hidden');
                        thumbnailPreview.classList.add('block');
                        thumbnailEmpty.classList.add('hidden');
                        thumbnailEmpty.classList.remove('flex');
                    });
                }

                const mediaModal = document.getElementById('pspkb-media-picker-modal');
                const mediaClose = document.getElementById('pspkb-media-picker-close');
                const galleryGrid = document.getElementById('pspkb-media-gallery-grid');
                const galleryLoading = document.getElementById('pspkb-media-gallery-loading');
                const galleryEmpty = document.getElementById('pspkb-media-gallery-empty');
                const uploadInput = document.getElementById('pspkb-media-upload-input');
                const uploadStatus = document.getElementById('pspkb-media-upload-status');
                const tabs = document.querySelectorAll('.pspkb-media-tab');
                const galleryPanel = document.getElementById('pspkb-media-gallery-panel');
                const uploadPanel = document.getElementById('pspkb-media-upload-panel');
                let mediaSelectCallback = null;
                let mediaLoaded = false;

                const switchMediaTab = (tab) => {
                    tabs.forEach((button) => {
                        const active = button.dataset.mediaTab === tab;
                        button.className = active
                            ? 'pspkb-media-tab rounded-t-xl bg-indigo-600 px-4 py-2 text-sm font-bold text-white'
                            : 'pspkb-media-tab rounded-t-xl bg-gray-100 px-4 py-2 text-sm font-bold text-gray-600';
                    });
                    galleryPanel.classList.toggle('hidden', tab !== 'gallery');
                    uploadPanel.classList.toggle('hidden', tab !== 'upload');
                };

                const renderMedia = (items) => {
                    galleryGrid.innerHTML = '';
                    galleryEmpty.classList.toggle('hidden', items.length > 0);

                    items.forEach((media) => {
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.className = 'overflow-hidden rounded-xl border border-gray-200 bg-white text-left shadow-sm transition hover:border-indigo-500 hover:shadow-md';
                        button.innerHTML = `
                            <img src="${media.url}" alt="${media.filename}" class="h-28 w-full object-cover">
                            <span class="block truncate px-2 py-2 text-xs font-semibold text-gray-700">${media.filename}</span>
                        `;
                        button.addEventListener('click', () => {
                            mediaSelectCallback?.(media);
                            closeMediaPicker();
                        });
                        galleryGrid.appendChild(button);
                    });
                };

                const loadMedia = async (force = false) => {
                    if (mediaLoaded && !force) return;
                    galleryLoading.classList.remove('hidden');

                    try {
                        const response = await fetch('/admin/media/library', {
                            headers: { 'Accept': 'application/json' },
                        });
                        if (!response.ok) throw new Error('Galeri gagal dimuat');
                        const payload = await response.json();
                        renderMedia(payload.data || []);
                        mediaLoaded = true;
                    } catch (error) {
                        galleryGrid.innerHTML = '<div class="col-span-full rounded-xl bg-red-50 p-4 text-sm font-semibold text-red-700">Galeri gagal dimuat.</div>';
                        console.error(error);
                    } finally {
                        galleryLoading.classList.add('hidden');
                    }
                };

                const closeMediaPicker = () => {
                    mediaModal.classList.add('hidden');
                    mediaModal.classList.remove('flex');
                    mediaSelectCallback = null;
                };

                window.pspkbOpenMediaPicker = ({ onSelect }) => {
                    mediaSelectCallback = onSelect;
                    mediaModal.classList.remove('hidden');
                    mediaModal.classList.add('flex');
                    switchMediaTab('gallery');
                    loadMedia();
                };

                tabs.forEach((button) => button.addEventListener('click', () => switchMediaTab(button.dataset.mediaTab)));
                mediaClose?.addEventListener('click', closeMediaPicker);
                mediaModal?.addEventListener('click', (event) => {
                    if (event.target === mediaModal) closeMediaPicker();
                });

                uploadInput?.addEventListener('change', async () => {
                    const file = uploadInput.files && uploadInput.files[0];
                    if (!file) return;

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const formData = new FormData();
                    formData.append('file', file);
                    uploadStatus.textContent = 'Mengupload...';

                    try {
                        const response = await fetch('/admin/media/upload', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                            body: formData,
                        });
                        if (!response.ok) throw new Error('Upload gagal');

                        const media = await response.json();
                        mediaSelectCallback?.(media);
                        mediaLoaded = false;
                        uploadInput.value = '';
                        uploadStatus.textContent = 'Upload berhasil.';
                        closeMediaPicker();
                    } catch (error) {
                        uploadStatus.textContent = 'Upload gagal. Pastikan gambar valid dan maksimal 5MB.';
                        console.error(error);
                    }
                });

                document.addEventListener('pspkb:post-content-updated', syncSeoFields);

                syncSeoFields();
            });
        </script>
    @endpush
@endonce
            </div>
        </div>
    </div>
</div>
