<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\PageService;
use App\Services\SettingService;

class PageController extends Controller
{
    public function __construct(
        protected PageService $pageService,
        protected SettingService $settingService
    ) {}

    public function show(string $slug)
    {
        $page = $this->pageService->findBySlug($slug);

        if (!$page) {
            abort(404);
        }

        $settings = $this->settingService->getAll();

        return view('frontend.page', compact('page', 'settings'));
    }
}
