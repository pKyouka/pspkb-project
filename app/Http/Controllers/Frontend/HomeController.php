<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\BannerService;
use App\Services\MenuService;
use App\Services\PageService;
use App\Services\PostService;
use App\Services\SettingService;

class HomeController extends Controller
{
    public function __construct(
        protected PostService $postService,
        protected PageService $pageService,
        protected BannerService $bannerService,
        protected SettingService $settingService,
        protected MenuService $menuService
    ) {}

    public function index()
    {
        $banners = $this->bannerService->getActive()->take(3);
        $featuredPosts = $this->postService->getFeatured(6);
        $featuredPages = $this->pageService->getPublishedPaginated(4);
        $settings = $this->settingService->getAll();
        $headerMenu = $this->menuService->findByLocation('header');
        $footerMenu = $this->menuService->findByLocation('footer');

        return view('frontend.home', compact(
            'banners',
            'featuredPosts',
            'featuredPages',
            'settings',
            'headerMenu',
            'footerMenu'
        ));
    }
}
