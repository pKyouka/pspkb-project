<?php

namespace App\Services;

use App\Models\MenuItem;
use App\Repositories\MenuRepository;

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
        return MenuItem::create($data);
    }

    public function updateMenuItem(int $id, array $data)
    {
        $item = MenuItem::find($id);
        if (!$item) {
            return false;
        }
        return $item->update($data);
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
}
