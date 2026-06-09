<?php

namespace App\Services;

use App\Repositories\ContactMessageRepository;

class ContactMessageService
{
    public function __construct(
        protected ContactMessageRepository $contactMessageRepository
    ) {}

    public function getAllPaginated(int $perPage = 15)
    {
        return $this->contactMessageRepository->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->contactMessageRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->contactMessageRepository->create($data);
    }

    public function delete(int $id)
    {
        return $this->contactMessageRepository->delete($id);
    }

    public function markAsRead(int $id)
    {
        return $this->contactMessageRepository->markAsRead($id);
    }

    public function getUnread()
    {
        return $this->contactMessageRepository->getUnread();
    }

    public function count()
    {
        return $this->contactMessageRepository->count();
    }

    public function countUnread(): int
    {
        return $this->contactMessageRepository->getModel()
            ->whereNull('read_at')
            ->count();
    }
}
