<?php

namespace App\Services;

use App\Repositories\PageRepository;
use Illuminate\Http\UploadedFile;

class PageService
{
    public function __construct(
        protected PageRepository $pageRepository
    ) {}

    public function getAllPaginated(int $perPage = 10)
    {
        return $this->pageRepository->paginate($perPage);
    }

    public function getPublishedPaginated(int $perPage = 10)
    {
        return $this->pageRepository->getPublishedPaginated($perPage);
    }

    public function find(int $id)
    {
        return $this->pageRepository->find($id);
    }

    public function findBySlug(string $slug)
    {
        return $this->pageRepository->findPublishedBySlug($slug);
    }

    public function create(array $data)
    {
        if (isset($data['featured_image']) && $data['featured_image'] instanceof UploadedFile) {
            $data['featured_image'] = $data['featured_image']->store('pages', 'public');
        }

        if (empty($data['published_at']) && ($data['status'] ?? 'draft') === 'published') {
            $data['published_at'] = now();
        }

        return $this->pageRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        if (isset($data['featured_image']) && $data['featured_image'] instanceof UploadedFile) {
            $data['featured_image'] = $data['featured_image']->store('pages', 'public');
        }

        if (isset($data['status']) && $data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $this->pageRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->pageRepository->delete($id);
    }

    public function publish(int $id)
    {
        return $this->pageRepository->publish($id);
    }

    public function unpublish(int $id)
    {
        return $this->pageRepository->unpublish($id);
    }

    public function search(string $query)
    {
        return $this->pageRepository->search($query);
    }

    public function count()
    {
        return $this->pageRepository->count();
    }
}
