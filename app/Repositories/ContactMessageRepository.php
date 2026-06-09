<?php

namespace App\Repositories;

use App\Models\ContactMessage;

class ContactMessageRepository extends BaseRepository
{
    public function __construct(ContactMessage $model)
    {
        parent::__construct($model);
    }

    /**
     * Get unread messages
     */
    public function getUnread(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->whereNull('read_at')->latest()->get();
    }

    /**
     * Mark message as read
     */
    public function markAsRead(int $id): bool
    {
        return $this->update($id, ['read_at' => now()]);
    }
}
