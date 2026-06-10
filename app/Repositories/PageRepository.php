<?php

namespace App\Repositories;

use App\Models\Page;

class PageRepository extends BaseRepository
{
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }

    /**
     * Get published pages
     */
    public function getPublished(array $columns = ['*']): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->published()->get($columns);
    }

    /**
     * Get published pages paginated
     */
    public function getPublishedPaginated(int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->model->published()->paginate($perPage);
    }

    /**
     * Find published page by slug
     */
    public function findPublishedBySlug(string $slug): ?Page
    {
        return $this->model->published()->where('slug', $slug)->first();
    }

    /**
     * Search pages by title
     */
    public function search(string $query): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where(function ($builder) use ($query) {
            $builder->where('title', 'like', "%{$query}%")
                ->orWhere('content', 'like', "%{$query}%");
        })
            ->published()
            ->get();
    }

    /**
     * Get draft pages
     */
    public function getDrafts(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where('status', 'draft')->get();
    }

    /**
     * Publish a page
     */
    public function publish(int $id): bool
    {
        return $this->update($id, [
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    /**
     * Unpublish a page
     */
    public function unpublish(int $id): bool
    {
        return $this->update($id, [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}
