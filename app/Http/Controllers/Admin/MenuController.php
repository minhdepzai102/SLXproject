<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateFormRequest;
use App\Http\Services\Menu\MenuService;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index()
    {
        // Lấy tất cả danh mục
        $menus = Menu::all();
        // Lấy danh mục cha (có parent_id = 0)
        $parentMenus = Menu::where('parent_id', 0)->get();

        // Trả về view với các biến cần thiết
        return view('admin.menu.list', [
            'title' => 'Danh Sách Danh Mục',
            'menus' => $menus,
            'parentMenus' => $parentMenus // Truyền biến danh mục cha vào view
        ]);
    }


    public function create()
    {
        return view('admin.menu.add', [
            'title' => 'Thêm Danh Mục Mới',
            'menus' => $this->menuService->getParent()
        ]);
    }

    public function store(CreateFormRequest $request)
    {
        // Gọi đến phương thức create trong service để lưu danh mục
        $result = $this->menuService->create($request);

        // Kiểm tra kết quả trả về
        if ($result) {
            // Nếu thành công, chuyển hướng đến danh sách danh mục với thông báo thành công
            return redirect()->route('menus.index')->with('success', 'Danh mục đã được thêm thành công!');
        } else {
            // Nếu có lỗi xảy ra, quay lại với thông báo lỗi
            return back()->with('error', 'Đã xảy ra lỗi khi thêm danh mục.');
        }
    }


    public function edit(Menu $menu)
    {
        return view('admin.menu.edit', [
            'title' => 'Chỉnh Sửa Danh Mục: ' . $menu->name,
            'menu' => $menu,
            'menus' => $this->menuService->getParent()
        ]);
    }

    public function update(Menu $menu, CreateFormRequest $request)
    {
        $result = $this->menuService->update($request, $menu);

        if ($result) {
            return redirect()->route('menus.index')->with('success', 'Danh mục đã được cập nhật thành công!');
        } else {
            return back()->with('error', 'Đã xảy ra lỗi khi cập nhật danh mục.');
        }
    }

    public function destroy(Request $request, $id)
    {
        // Gọi phương thức destroy trong MenuService
        $result = $this->menuService->destroy($request, $id);

        if ($result) {
            return redirect()->route('menus.index')->with('success', 'Xóa thành công danh mục');
        }

        return redirect()->route('menus.index')->with('error', 'Không tìm thấy danh mục để xóa!');
    }

}
