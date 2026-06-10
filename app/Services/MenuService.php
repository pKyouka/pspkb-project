<?php

namespace App\Services;

use App\Models\MenuItem;
use App\Models\Page;
use App\Repositories\MenuRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MenuService
{
    public function __construct(
        protected MenuRepository $menuRepository
    ) {}

    public function getAll()
    {
        return $this->menuRepository->all();
    }

    public function find(int $id)
    {
        return $this->menuRepository->find($id);
    }

    public function getWithItems(int $id)
    {
        return $this->menuRepository->getWithItems($id);
    }

    public function findByLocation(string $location)
    {
        return $this->menuRepository->findByLocation($location);
    }

    public function create(array $data)
    {
        return $this->menuRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->menuRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->menuRepository->delete($id);
    }

    public function addMenuItem(array $data)
    {
        $data['url'] = $this->normalizeUrl($data['url'] ?? null);

        return MenuItem::create($data);
    }

    public function updateMenuItem(int $id, array $data)
    {
        $item = MenuItem::find($id);
        if (!$item) {
            return false;
        }

        $data['url'] = $this->normalizeUrl($data['url'] ?? null);

        return DB::transaction(function () use ($item, $data) {
            $page = $this->resolveLinkedPage($item);
            $newSlug = $this->pageSlugFromUrl($data['url']);

            if ($page && $newSlug && $newSlug !== $page->slug) {
                if (Page::where('slug', $newSlug)->where('id', '!=', $page->id)->exists()) {
                    throw ValidationException::withMessages([
                        'url' => 'URL tersebut sudah digunakan oleh halaman lain.',
                    ]);
                }

                $page->update(['slug' => $newSlug]);
            }

            return $item->update($data);
        });
    }

    public function deleteMenuItem(int $id)
    {
        $item = MenuItem::find($id);
        if (!$item) {
            return false;
        }
        return $item->delete();
    }

    public function reorderMenuItems(array $items): void
    {
        foreach ($items as $index => $itemId) {
            MenuItem::where('id', $itemId)->update(['order_number' => $index + 1]);
        }
    }

    private function resolveLinkedPage(MenuItem $item): ?Page
    {
        $currentSlug = $this->pageSlugFromUrl($item->url);

        if ($currentSlug) {
            $page = Page::where('slug', $currentSlug)->first();

            if ($page) {
                return $page;
            }
        }

        // Recover links that were renamed before URL-to-page synchronization existed.
        $normalizedTitle = Str::lower($item->title);

        if (Str::contains($normalizedTitle, ['profil', 'struktur'])) {
            return Page::where('slug', 'profil-uld-dan-struktur')
                ->orWhere('title', 'like', '%Profil%Struktur%')
                ->first();
        }

        return null;
    }

    private function normalizeUrl(?string $url): ?string
    {
        $url = trim((string) $url);

        if ($url === '') {
            return null;
        }

        if (Str::startsWith($url, ['http://', 'https://', '#', 'mailto:', 'tel:'])) {
            return $url;
        }

        return '/' . ltrim($url, '/');
    }

    private function pageSlugFromUrl(?string $url): ?string
    {
        if (!$url || Str::startsWith($url, ['http://', 'https://', '#', 'mailto:', 'tel:'])) {
            return null;
        }

        $path = trim(parse_url($url, PHP_URL_PATH) ?? '', '/');

        if ($path === '' || Str::contains($path, '/')) {
            return null;
        }

        $reservedPaths = ['berita', 'kegiatan', 'kontak', 'search', 'admin', 'dashboard', 'settings'];

        return in_array($path, $reservedPaths, true) ? null : Str::slug($path);
    }
}
