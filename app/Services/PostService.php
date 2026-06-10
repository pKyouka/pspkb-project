<?php

namespace App\Services;

use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\UploadedFile;

class PostService
{
    public function __construct(
        protected PostRepository $postRepository,
        protected TagRepository $tagRepository
    ) {}

    public function getAllPaginated(int $perPage = 10)
    {
        return $this->postRepository->paginate($perPage);
    }

    public function getPublishedPaginated(int $perPage = 10)
    {
        return $this->postRepository->getPublishedPaginated($perPage);
    }

    public function getAdminByCategorySlugs(array $slugs, int $perPage = 10)
    {
        return $this->postRepository->getAdminByCategorySlugs($slugs, $perPage);
    }

    public function getAdminExcludingCategorySlugs(array $slugs, int $perPage = 10)
    {
        return $this->postRepository->getAdminExcludingCategorySlugs($slugs, $perPage);
    }

    public function getByCategorySlugs(array $slugs, int $perPage = 10)
    {
        return $this->postRepository->getByCategorySlugs($slugs, $perPage);
    }

    public function find(int $id)
    {
        return $this->postRepository->find($id);
    }

    public function findBySlug(string $slug)
    {
        return $this->postRepository->findPublishedBySlug($slug);
    }

    public function create(array $data)
    {
        if (isset($data['thumbnail']) && $data['thumbnail'] instanceof UploadedFile) {
            $data['thumbnail'] = $data['thumbnail']->store('posts', 'public');
        } elseif (!empty($data['thumbnail_media_path'])) {
            $data['thumbnail'] = $data['thumbnail_media_path'];
        }

        unset($data['thumbnail_media_path']);

        if (empty($data['published_at']) && ($data['status'] ?? 'draft') === 'published') {
            $data['published_at'] = now();
        }

        $tags = $data['tags'] ?? [];
        unset($data['tags']);

        $post = $this->postRepository->create($data);

        if (!empty($tags)) {
            $tagModels = $this->tagRepository->getOrCreateByNames($tags);
            $post->tags()->sync($tagModels->pluck('id'));
        }

        return $post;
    }

    public function update(int $id, array $data)
    {
        if (isset($data['thumbnail']) && $data['thumbnail'] instanceof UploadedFile) {
            $data['thumbnail'] = $data['thumbnail']->store('posts', 'public');
        } elseif (!empty($data['thumbnail_media_path'])) {
            $data['thumbnail'] = $data['thumbnail_media_path'];
        }

        unset($data['thumbnail_media_path']);

        if (isset($data['status']) && $data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $tags = $data['tags'] ?? null;
        unset($data['tags']);

        $this->postRepository->update($id, $data);

        if ($tags !== null) {
            $post = $this->postRepository->find($id);
            $tagModels = $this->tagRepository->getOrCreateByNames($tags);
            $post->tags()->sync($tagModels->pluck('id'));
        }

        return $this->postRepository->find($id);
    }

    public function delete(int $id)
    {
        return $this->postRepository->delete($id);
    }

    public function publish(int $id)
    {
        return $this->postRepository->publish($id);
    }

    public function unpublish(int $id)
    {
        return $this->postRepository->unpublish($id);
    }

    public function search(string $query)
    {
        return $this->postRepository->search($query);
    }

    public function getFeatured(int $limit = 5)
    {
        return $this->postRepository->getFeatured($limit);
    }

    public function getFeaturedByCategorySlugs(array $slugs, int $limit = 5)
    {
        return $this->postRepository->getFeaturedByCategorySlugs($slugs, $limit);
    }

    public function getByCategory(int $categoryId, int $perPage = 10)
    {
        return $this->postRepository->getByCategory($categoryId, $perPage);
    }

    public function count()
    {
        return $this->postRepository->count();
    }
}
