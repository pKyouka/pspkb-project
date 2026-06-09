<?php

namespace App\Repositories;

use App\Models\Menu;

class MenuRepository extends BaseRepository
{
    public function __construct(Menu $model)
    {
        parent::__construct($model);
    }

    /**
     * Find menu by location
     */
    public function findByLocation(string $location): ?Menu
    {
        return $this->model->where('location', $location)->first();
    }

    /**
     * Get menu with its items
     */
    public function getWithItems(int $id): ?Menu
    {
        return $this->model->with(['items' => function ($query) {
            $query->whereNull('parent_id')->orderBy('order_number');
        }, 'items.children' => function ($query) {
            $query->orderBy('order_number');
        }])->find($id);
    }
}
