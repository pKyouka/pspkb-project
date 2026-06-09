<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContactMessageService;
use App\Services\MediaService;
use App\Services\PageService;
use App\Services\PostService;
use App\Services\SettingService;

class DashboardController extends Controller
{
    public function __construct(
        protected PageService $pageService,
        protected PostService $postService,
        protected MediaService $mediaService,
        protected ContactMessageService $contactMessageService,
        protected SettingService $settingService
    ) {}

    public function index()
    {
        $stats = [
            'total_posts' => $this->postService->count(),
            'total_pages' => $this->pageService->count(),
            'total_users' => \App\Models\User::count(),
            'total_messages' => $this->contactMessageService->count(),
            'total_media' => $this->mediaService->count(),
            'unread_messages' => $this->contactMessageService->countUnread(),
        ];

        $recentPosts = $this->postService->getAllPaginated(5);
        $recentMessages = $this->contactMessageService->getUnread()->take(5);

        return view('admin.dashboard.index', compact('stats', 'recentPosts', 'recentMessages'));
    }
}
