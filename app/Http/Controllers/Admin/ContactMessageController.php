<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Services\ContactMessageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function __construct(
        protected ContactMessageService $contactMessageService
    ) {}

    public function index(): View
    {
        $messages = $this->contactMessageService->getAllPaginated(15);
        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $contactMessage): View
    {
        // Mark as read when viewing
        $this->contactMessageService->markAsRead($contactMessage->id);
        return view('admin.messages.show', ['message' => $contactMessage]);
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $this->contactMessageService->delete($contactMessage->id);
        return redirect()->route('admin.messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
