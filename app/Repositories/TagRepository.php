<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository extends BaseRepository
{
    public function __construct(Tag $model)
    {
        parent::__construct($model);
    }

    /**
     * Get tags with post count
     */
    public function getWithPostCount(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->withCount('posts');
    }

    /**
     * Find tag by slug
     */
    public function findBySlug(string $slug): ?Tag
    {
        return $this->model->where('slug', $slug)->first();
    }

    /**
     * Get or create tags by names
     */
    public function getOrCreateByNames(array $names): \Illuminate\Database\Eloquent\Collection
    {
        $tags = new \Illuminate\Database\Eloquent\Collection();

        foreach ($names as $name) {
            $name = trim($name);

            if ($name === '') {
                continue;
            }

            $tag = $this->model->firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($name)],
                ['name' => $name]
            );

            $tags->push($tag);
        }

        return $tags;
    }
}
