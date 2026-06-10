<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul *</label>
            <input type="text" id="post-title" name="title" value="{{ old('title', $page->title ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <div class="flex items-center justify-between mb-1">
                <label class="block text-sm font-medium text-gray-700">Slug</label>
                <span class="text-xs text-gray-400">Otomatis dari judul, tetap bisa diedit manual</span>
            </div>
            <input type="text" id="post-slug" name="slug" value="{{ old('slug', $page->slug ?? '') }}" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <div class="flex items-center justify-between mb-2">
                <label class="block text-sm font-semibold text-gray-700">Konten</label>
                <span class="text-xs text-gray-400">Editor visual lengkap</span>
            </div>

            <textarea id="post-content" name="content" class="hidden">{{ old('content', $page->content ?? '') }}</textarea>

            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <div id="post-content-editor" class="content-editor min-h-[460px]"></div>
            </div>
            @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

    </div>

    <div class="space-y-4">
        @php
            $selectedStatus = old('status', $page->status ?? 'draft');
        @endphp

        <div x-data="{ status: @js($selectedStatus) }" :class="status === 'published' ? 'border-emerald-200 bg-emerald-50/90' : 'border-amber-200 bg-amber-50/90'" class="rounded-2xl border p-4 shadow-sm transition">
            <div class="mb-3 flex items-center justify-between gap-3">
                <div>
                    <label class="block text-sm font-bold text-gray-800">Status *</label>
                    <p class="mt-0.5 text-xs" :class="status === 'published' ? 'text-emerald-700' : 'text-amber-700'" x-text="status === 'published' ? 'Halaman tampil di website publik.' : 'Masih draft, aman untuk diedit dulu.'"></p>
                </div>
                <span class="rounded-full px-3 py-1 text-xs font-extrabold uppercase tracking-wide" :class="status === 'published' ? 'bg-emerald-600 text-white' : 'bg-amber-500 text-white'" x-text="status"></span>
            </div>
            <select name="status" x-model="status" class="w-full border rounded-lg px-3 py-2 font-semibold">
                <option value="draft" {{ $selectedStatus === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ $selectedStatus === 'published' ? 'selected' : '' }}>Published</option>
            </select>
            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="rounded-2xl border border-indigo-200 bg-indigo-50/90 p-4 shadow-sm">
            <div class="mb-3 flex items-center gap-2">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-indigo-500 text-white">🖼️</span>
                <div>
                    <label class="block text-sm font-bold text-gray-800">Gambar Utama</label>
                    <p class="text-xs text-indigo-700">Visual utama untuk halaman publik.</p>
                </div>
            </div>

            <div class="rounded-2xl border border-indigo-200 bg-white p-3 shadow-sm">
                <input type="file" id="post-thumbnail" name="featured_image" class="sr-only" accept="image/*">
                <label for="post-thumbnail" class="group flex cursor-pointer items-center gap-3 rounded-xl border border-dashed border-indigo-300 bg-gradient-to-br from-indigo-50 to-white p-3 transition hover:border-indigo-500 hover:from-indigo-100 hover:shadow-md">
                    <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-indigo-600 text-lg text-white shadow-md shadow-indigo-200 transition group-hover:scale-105 group-hover:bg-indigo-700">⬆️</span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-sm font-extrabold text-indigo-900">Pilih / Ganti Gambar</span>
                        <span id="post-thumbnail-filename" class="mt-0.5 block truncate text-xs font-semibold text-indigo-600">
                            {{ !empty($page->featured_image) ? basename($page->featured_image) : 'PNG/JPG/WebP, maksimal 5MB' }}
                        </span>
                    </span>
                    <span class="hidden rounded-full bg-indigo-600 px-3 py-1 text-xs font-bold text-white shadow-sm sm:inline-flex">Browse</span>
                </label>
            </div>
            @error('featured_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

            <div class="mt-3 overflow-hidden rounded-xl border border-indigo-100 bg-white">
                <img id="post-thumbnail-preview" src="{{ !empty($page->featured_image) ? asset('storage/' . $page->featured_image) : '' }}" class="{{ !empty($page->featured_image) ? 'block' : 'hidden' }} h-40 w-full object-cover" alt="Preview gambar utama">
                <div id="post-thumbnail-empty" class="{{ !empty($page->featured_image) ? 'hidden' : 'flex' }} h-28 items-center justify-center text-xs text-gray-500">
                    Belum ada gambar utama
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
                    <input type="text" id="post-meta-title" name="meta_title" value="{{ old('meta_title', $page->meta_title ?? '') }}" class="w-full border rounded-lg px-3 py-2 text-sm">
                    @error('meta_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Meta Description</label>
                    <textarea id="post-meta-description" name="meta_description" rows="3" class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
                    @error('meta_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
                const contentInput = document.getElementById('post-content');
                const metaTitleInput = document.getElementById('post-meta-title');
                const metaDescriptionInput = document.getElementById('post-meta-description');
                const thumbnailInput = document.getElementById('post-thumbnail');
                const thumbnailPreview = document.getElementById('post-thumbnail-preview');
                const thumbnailEmpty = document.getElementById('post-thumbnail-empty');
                const thumbnailFilename = document.getElementById('post-thumbnail-filename');

                let slugEdited = !!slugInput.value.trim();
                let metaTitleEdited = !!metaTitleInput.value.trim();
                let metaDescriptionEdited = !!metaDescriptionInput.value.trim();

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

                    if (!slugEdited) slugInput.value = slugify(title);
                    if (!metaTitleEdited) metaTitleInput.value = limitText(title, 60);
                    if (!metaDescriptionEdited) metaDescriptionInput.value = limitText(contentText, 160);
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

                if (thumbnailInput && thumbnailPreview && thumbnailEmpty) {
                    thumbnailInput.addEventListener('change', function () {
                        const file = this.files && this.files[0];

                        if (!file) return;

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
