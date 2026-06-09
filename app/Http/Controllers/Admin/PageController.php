<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageRequest;
use App\Models\Page;
use App\Services\PageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(
        protected PageService $pageService
    ) {}

    public function index(): View
    {
        $pages = $this->pageService->getAllPaginated(15);
        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.pages.create');
    }

    public function store(PageRequest $request): RedirectResponse
    {
        $page = $this->pageService->create($request->validated());
        return redirect()->route('admin.pages.index')
            ->with('success', 'Halaman berhasil dibuat.');
    }

    public function show(Page $page): View
    {
        $page->load('creator');
        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(PageRequest $request, Page $page): RedirectResponse
    {
        $this->pageService->update($page->id, $request->validated());
        return redirect()->route('admin.pages.index')
            ->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $this->pageService->delete($page->id);
        return redirect()->route('admin.pages.index')
            ->with('success', 'Halaman berhasil dihapus.');
    }

    public function publish(Page $page): RedirectResponse
    {
        $this->pageService->publish($page->id);
        return redirect()->route('admin.pages.index')
            ->with('success', 'Halaman berhasil dipublikasikan.');
    }

    public function unpublish(Page $page): RedirectResponse
    {
        $this->pageService->unpublish($page->id);
        return redirect()->route('admin.pages.index')
            ->with('success', 'Halaman berhasil di-unpublish.');
    }
}
