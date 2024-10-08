<?php


namespace App\Http\Services\Menu;


use App\Models\Menu;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class MenuService
{
    public function getParent()
    {
        return Menu::where('parent_id', 0)->get();
    }

    public function show()
    {
        return Menu::select('name', 'id')
            ->where('parent_id', 0)
            ->orderbyDesc('id')
            ->get();
    }

    public function getAll()
    {
        return Menu::orderbyDesc('id')->paginate(20);
    }

    public function create($request)
    {
        try {
            Menu::create([
                'name' => (string) $request->input('name'),
                'parent_id' => (int) $request->input('parent_id'),
                'description' => (string) $request->input('description'),
                'content' => (string) $request->input('content'),
                'active' => (int) $request->input('active'), // Chuyển đổi thành số nguyên
                'slug' => $request->input('slug') // Nếu bạn muốn lưu slug
            ]);

            Session::flash('success', 'Tạo Danh Mục Thành Công');
        } catch (\Exception $err) {
            \Log::error('Menu Create Error:', ['error' => $err->getMessage()]); // Ghi lại thông tin lỗi
            Session::flash('error', $err->getMessage());
            return false;
        }

        return true;
    }


    public function update($request, Menu $menu)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'parent_id' => 'integer|nullable',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'active' => 'required|boolean',
        ]);

        // Cập nhật dữ liệu vào cơ sở dữ liệu
        $menu->name = $request->input('name');
        $menu->slug = $request->input('slug');
        $menu->parent_id = $request->input('parent_id');
        $menu->description = $request->input('description');
        $menu->content = $request->input('content');
        $menu->active = $request->input('active');
        
        // Lưu vào cơ sở dữ liệu
        $menu->save();

        // Quay về trang danh sách và thông báo thành công
        return redirect()->route('menus.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy($request, $id)
    {
        // Kiểm tra xem menu có tồn tại không
        $menu = Menu::find($id);
        if ($menu) {
            // Xóa menu và các danh mục con (nếu cần)
            Menu::where('id', $id)->orWhere('parent_id', $id)->delete();
            return true; // Trả về true nếu xóa thành công
        }
        
        return false; // Trả về false nếu không tìm thấy danh mục
    }
    
    


    public function getId($id)
    {
        return Menu::where('id', $id)->where('active', 1)->firstOrFail();
    }

    public function getProduct($menu, $request)
    {
        $query = $menu->products()
            ->select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1);

        if ($request->input('price')) {
            $query->orderBy('price', $request->input('price'));
        }

        return $query
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();
    }
}
