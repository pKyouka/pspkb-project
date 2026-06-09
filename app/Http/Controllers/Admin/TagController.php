<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TagRequest;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TagController extends Controller
{
    public function __construct(
        protected TagService $tagService
    ) {}

    public function index(): View
    {
        $tags = $this->tagService->getWithPostCount()->paginate(15);
        return view('admin.tags.index', compact('tags'));
    }

    public function create(): View
    {
        return view('admin.tags.create');
    }

    public function store(TagRequest $request): RedirectResponse
    {
        $this->tagService->create($request->validated());
        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil dibuat.');
    }

    public function edit(Tag $tag): View
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag): RedirectResponse
    {
        $this->tagService->update($tag->id, $request->validated());
        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil diperbarui.');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $this->tagService->delete($tag->id);
        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil dihapus.');
    }
}
