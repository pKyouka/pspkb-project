<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
    ];

    /**
     * Check if message has been read
     */
    public function isRead(): bool
    {
        return $this->read_at !== null;
    }
}
