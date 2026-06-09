import Quill from 'quill';
import 'quill/dist/quill.snow.css';

window.Quill = Quill;

document.addEventListener('DOMContentLoaded', () => {
    const editorEl = document.getElementById('post-content-editor');
    const contentInput = document.getElementById('post-content');

    if (!editorEl || !contentInput || !window.Quill) return;

    const imageSizes = {
        small: { label: 'Small', width: '320px' },
        medium: { label: 'Medium', width: '560px' },
        large: { label: 'Large', width: '820px' },
        original: { label: 'Original', width: '' }
    };

    const quill = new Quill(editorEl, {
        theme: 'snow',
        placeholder: 'Tulis konten berita di sini...',
        modules: {
            toolbar: {
                container: [
                    [{ header: [false, 2, 3, 4] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ color: [] }, { background: [] }],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    [{ align: [] }],
                    ['blockquote', 'link', 'image'],
                    ['clean']
                ],
                handlers: {
                    image() {
                        const range = quill.getSelection(true);
                        const insertImage = (media) => {
                            quill.insertEmbed(range.index, 'image', media.url, 'user');
                            quill.setSelection(range.index + 1);

                            requestAnimationFrame(() => {
                                const images = quill.root.querySelectorAll(`img[src="${CSS.escape(media.url)}"]`);
                                const image = images[images.length - 1];

                                if (image) {
                                    applyImageSize(image, 'large');
                                }
                            });

                            syncContent();
                        };

                        if (window.pspkbOpenMediaPicker) {
                            window.pspkbOpenMediaPicker({ onSelect: insertImage });
                            return;
                        }

                        const input = document.createElement('input');
                        input.type = 'file';
                        input.accept = 'image/jpeg,image/png,image/webp,image/svg+xml';

                        input.addEventListener('change', async () => {
                            const file = input.files && input.files[0];
                            if (!file) return;

                            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                            const formData = new FormData();
                            formData.append('file', file);

                            try {
                                const response = await fetch('/admin/media/upload', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Accept': 'application/json'
                                    },
                                    body: formData
                                });

                                if (!response.ok) {
                                    throw new Error('Upload gagal');
                                }

                                insertImage(await response.json());
                            } catch (error) {
                                alert('Upload gambar gagal. Pastikan file gambar valid dan ukuran maksimal 5MB.');
                                console.error(error);
                            }
                        });

                        input.click();
                    }
                }
            }
        }
    });

    if (contentInput.value) {
        quill.root.innerHTML = contentInput.value;
    }

    const syncContent = () => {
        contentInput.value = quill.root.innerHTML;
        document.dispatchEvent(new CustomEvent('pspkb:post-content-updated'));
    };

    const applyImageSize = (image, size) => {
        const config = imageSizes[size] || imageSizes.original;

        image.dataset.size = size;
        image.style.width = config.width;
        image.style.maxWidth = '100%';
        image.style.height = 'auto';
        image.style.borderRadius = '10px';
        image.style.display = 'block';

        if (size === 'original') {
            image.removeAttribute('width');
        }

        syncContent();
    };

    const closeImageSizePicker = () => {
        document.querySelectorAll('.pspkb-image-size-picker').forEach((picker) => picker.remove());
        quill.root.querySelectorAll('img.is-selected').forEach((image) => image.classList.remove('is-selected'));
    };

    const showImageSizePicker = (image) => {
        closeImageSizePicker();

        image.classList.add('is-selected');

        const picker = document.createElement('div');
        picker.className = 'pspkb-image-size-picker';

        Object.entries(imageSizes).forEach(([value, config]) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.textContent = config.label;
            button.className = image.dataset.size === value ? 'is-active' : '';

            button.addEventListener('click', () => {
                applyImageSize(image, value);
                closeImageSizePicker();
            });

            picker.appendChild(button);
        });

        document.body.appendChild(picker);

        const rect = image.getBoundingClientRect();
        picker.style.left = `${Math.max(12, rect.left + window.scrollX)}px`;
        picker.style.top = `${rect.top + window.scrollY - picker.offsetHeight - 10}px`;

        if (picker.getBoundingClientRect().top < 0) {
            picker.style.top = `${rect.bottom + window.scrollY + 10}px`;
        }
    };

    const injectEditorStyle = () => {
        if (document.getElementById('pspkb-editor-image-style')) return;

        const style = document.createElement('style');
        style.id = 'pspkb-editor-image-style';
        style.textContent = `
            .ql-editor img {
                cursor: pointer;
                max-width: 100%;
                height: auto;
                border-radius: 10px;
            }

            .ql-editor img.is-selected {
                outline: 3px solid #2563eb;
                outline-offset: 3px;
            }

            .pspkb-image-size-picker {
                position: absolute;
                z-index: 9999;
                display: flex;
                gap: 6px;
                padding: 8px;
                background: #111827;
                border-radius: 10px;
                box-shadow: 0 12px 30px rgba(15, 23, 42, 0.24);
            }

            .pspkb-image-size-picker button {
                padding: 6px 10px;
                border: 0;
                border-radius: 8px;
                background: #374151;
                color: #fff;
                font-size: 12px;
                font-weight: 600;
                cursor: pointer;
            }

            .pspkb-image-size-picker button:hover,
            .pspkb-image-size-picker button.is-active {
                background: #2563eb;
            }
        `;

        document.head.appendChild(style);
    };

    injectEditorStyle();

    quill.root.addEventListener('click', (event) => {
        const image = event.target.closest('img');

        if (!image || !quill.root.contains(image)) {
            closeImageSizePicker();
            return;
        }

        event.preventDefault();
        showImageSizePicker(image);
    });

    document.addEventListener('click', (event) => {
        if (
            event.target.closest('.pspkb-image-size-picker') ||
            event.target.closest('.ql-editor img')
        ) {
            return;
        }

        closeImageSizePicker();
    });

    quill.on('text-change', syncContent);

    const form = editorEl.closest('form');
    if (form) {
        form.addEventListener('submit', syncContent);
    }

    syncContent();
});