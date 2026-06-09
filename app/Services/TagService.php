<?php

namespace App\Services;

use App\Repositories\TagRepository;

class TagService
{
    public function __construct(
        protected TagRepository $tagRepository
    ) {}

    public function getAll()
    {
        return $this->tagRepository->all();
    }

    public function getWithPostCount()
    {
        return $this->tagRepository->getWithPostCount();
    }

    public function find(int $id)
    {
        return $this->tagRepository->find($id);
    }

    public function findBySlug(string $slug)
    {
        return $this->tagRepository->findBySlug($slug);
    }

    public function create(array $data)
    {
        return $this->tagRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->tagRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->tagRepository->delete($id);
    }

    public function count()
    {
        return $this->tagRepository->count();
    }
}
