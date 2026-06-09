<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    public function __construct(
        protected CategoryRepository $categoryRepository
    ) {}

    public function getAll()
    {
        return $this->categoryRepository->all();
    }

    public function getWithPostCount()
    {
        return $this->categoryRepository->getWithPostCount();
    }

    public function find(int $id)
    {
        return $this->categoryRepository->find($id);
    }

    public function findBySlug(string $slug)
    {
        return $this->categoryRepository->findBySlug($slug);
    }

    public function create(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->categoryRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->categoryRepository->delete($id);
    }

    public function count()
    {
        return $this->categoryRepository->count();
    }
}
