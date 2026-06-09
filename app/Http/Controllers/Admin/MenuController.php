<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuItemRequest;
use App\Http\Requests\Admin\MenuRequest;
use App\Models\MenuItem;
use App\Services\MenuService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function __construct(
        protected MenuService $menuService
    ) {}

    public function index(): View
    {
        $menus = $this->menuService->getAll();
        return view('admin.menus.index', compact('menus'));
    }

    public function create(): View
    {
        return view('admin.menus.create');
    }

    public function store(MenuRequest $request): RedirectResponse
    {
        $this->menuService->create($request->validated());
        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dibuat.');
    }

    public function show($id): View
    {
        $menu = $this->menuService->getWithItems($id);
        return view('admin.menus.show', compact('menu'));
    }

    public function edit($id): View
    {
        $menu = $this->menuService->find($id);
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(MenuRequest $request, $id): RedirectResponse
    {
        $this->menuService->update($id, $request->validated());
        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        $this->menuService->delete($id);
        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }

    public function addItem(MenuItemRequest $request, $menuId): RedirectResponse
    {
        $data = $request->validated();
        $data['menu_id'] = $menuId;
        $this->menuService->addMenuItem($data);
        return redirect()->route('admin.menus.show', $menuId)
            ->with('success', 'Item menu berhasil ditambahkan.');
    }

    public function updateItem(MenuItemRequest $request, MenuItem $item): RedirectResponse
    {
        $this->menuService->updateMenuItem($item->id, $request->validated());
        return redirect()->route('admin.menus.show', $item->menu_id)
            ->with('success', 'Item menu berhasil diperbarui.');
    }

    public function deleteItem(MenuItem $item): RedirectResponse
    {
        $menuId = $item->menu_id;
        $this->menuService->deleteMenuItem($item->id);
        return redirect()->route('admin.menus.show', $menuId)
            ->with('success', 'Item menu berhasil dihapus.');
    }

    public function reorder(Request $request, $menuId): RedirectResponse
    {
        $this->menuService->reorderMenuItems($request->input('items', []));
        return redirect()->route('admin.menus.show', $menuId)
            ->with('success', 'Urutan menu berhasil diperbarui.');
    }
}
