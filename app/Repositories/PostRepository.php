<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository extends BaseRepository
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    /**
     * Get published posts
     */
    public function getPublished(array $columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->published()->get($columns);
    }

    /**
     * Get published posts paginated
     */
    public function getPublishedPaginated(int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->model->published()->latest('published_at')->paginate($perPage);
    }

    public function getAdminByCategorySlugs(array $slugs, int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->model
            ->with('category')
            ->whereHas('category', function ($query) use ($slugs) {
                $query->whereIn('slug', $slugs);
            })
            ->latest()
            ->paginate($perPage);
    }

    public function getAdminExcludingCategorySlugs(array $slugs, int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->model
            ->with('category')
            ->where(function ($query) use ($slugs) {
                $query->whereNull('category_id')
                    ->orWhereHas('category', function ($categoryQuery) use ($slugs) {
                        $categoryQuery->whereNotIn('slug', $slugs);
                    });
            })
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get published posts from one or more category slugs.
     */
    public function getByCategorySlugs(array $slugs, int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->model->published()
            ->with(['category', 'creator'])
            ->whereHas('category', function ($query) use ($slugs) {
                $query->whereIn('slug', $slugs);
            })
            ->latest('published_at')
            ->paginate($perPage);
    }

    /**
     * Find published post by slug
     */
    public function findPublishedBySlug(string $slug): ?Post
    {
        return $this->model->published()
            ->where('slug', $slug)
            ->with(['category', 'tags', 'creator'])
            ->first();
    }

    /**
     * Get posts by category
     */
    public function getByCategory(int $categoryId, int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->model->published()
            ->where('category_id', $categoryId)
            ->latest('published_at')
            ->paginate($perPage);
    }

    /**
     * Get posts by tag
     */
    public function getByTag(int $tagId, int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->model->published()
            ->whereHas('tags', function ($query) use ($tagId) {
                $query->where('tags.id', $tagId);
            })
            ->latest('published_at')
            ->paginate($perPage);
    }

    /**
     * Search posts
     */
    public function search(string $query): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where(function ($builder) use ($query) {
            $builder->where('title', 'like', "%{$query}%")
                ->orWhere('excerpt', 'like', "%{$query}%")
                ->orWhere('content', 'like', "%{$query}%");
        })
            ->published()
            ->get();
    }

    /**
     * Get featured/latest posts
     */
    public function getFeatured(int $limit = 5): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->published()
            ->with(['category', 'creator'])
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    public function getFeaturedByCategorySlugs(array $slugs, int $limit = 5): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->published()
            ->with(['category', 'creator'])
            ->whereHas('category', function ($query) use ($slugs) {
                $query->whereIn('slug', $slugs);
            })
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Publish a post
     */
    public function publish(int $id): bool
    {
        return $this->update($id, [
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    /**
     * Unpublish a post
     */
    public function unpublish(int $id): bool
    {
        return $this->update($id, [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}
