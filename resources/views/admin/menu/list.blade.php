@include('admin.layout.headeradmin')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CKEditor CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.0/classic/ckeditor.js"></script>
</head>

<body>
    @include('admin.menu.error') <!-- Ensure this partial exists and handles error messages -->

    <div class="container mt-5">
        <h1 class="mb-4">{{ $title }}</h1>

        <!-- Button to trigger modal for adding a new menu -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addMenuModal">
            Thêm danh mục
        </button>

        <!-- Table to display menus -->
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên danh mục</th>
                    <th>Danh mục cha</th>
                    <th>Mô tả</th>
                    <th>Kích hoạt</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $index => $menu)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $menu->name }}</td>
                        <td>{{ $menu->parent_id }}</td>
                        <td>{{ $menu->description }}</td>
                        <td>{{ $menu->active ? 'Có' : 'Không' }}</td>
                        <td>
                            <!-- Button to trigger modal for editing -->
                            <button class="btn btn-warning btn-sm" onclick="openEditModal({{ $menu }})">
                                Sửa
                            </button>
                            <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" style="display:inline;"
                                onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal for adding a new menu -->
        <div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMenuModalLabel">Thêm danh mục</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('menus.store') }}" method="POST" id="addMenuForm">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên danh mục:</label>
                                <input placeholder="Nhập tên danh mục" type="text" id="name" name="name"
                                    class="form-control" required oninput="generateSlug()">
                            </div>
                            <div class="mb-3">
                                <input hidden type="text" id="slug" name="slug" class="form-control"
                                    placeholder="Slug sẽ tự động được tạo" readonly>
                            </div>
                            <!-- Trong modal thêm -->
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Danh Mục Cha</label>
                                <select class="form-select" id="parent_id" name="parent_id">
                                    <option value="0" selected>Chọn danh mục cha</option>
                                    @foreach ($parentMenus as $parentMenu)
                                        <option value="{{ $parentMenu->id }}">{{ $parentMenu->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Mô tả chi tiết</label>
                                <textarea name="content" id="content" class="form-control" rows="4"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kích hoạt</label>
                                <div class="form-check">
                                    <input class="form-check-input" value="1" id="active" name="active" type="radio"
                                        required>
                                    <label class="form-check-label" for="active">Có</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" value="0" id="no-active" name="active" type="radio">
                                    <label class="form-check-label" for="no-active">Không</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Thêm danh mục</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for editing a menu -->
        <!-- Modal for editing a menu -->
        <div class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="editMenuModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMenuModalLabel">Sửa danh mục</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" id="editMenuForm">
                            @csrf
                            @method('POST') <!-- Đảm bảo phương thức là POST -->
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Tên danh mục:</label>
                                <input placeholder="Nhập tên danh mục" type="text" id="edit_name" name="name"
                                    class="form-control" required oninput="generateSlug()">
                            </div>
                            <div class="mb-3">
                                <input hidden type="text" id="edit_slug" name="slug" class="form-control"
                                    placeholder="Slug sẽ tự động được tạo" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="edit_parent_id" class="form-label">Danh Mục Cha</label>
                                <select class="form-select" id="edit_parent_id" name="parent_id">
                                    <option value="0" selected>Chọn danh mục cha</option>
                                    @foreach ($parentMenus as $parentMenu)
                                        <option value="{{ $parentMenu->id }}">{{ $parentMenu->name }}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="mb-3">
                                <label for="edit_description" class="form-label">Mô tả</label>
                                <textarea name="description" id="edit_description" class="form-control"
                                    rows="4"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="edit_content" class="form-label">Mô tả chi tiết</label>
                                <textarea name="content" id="edit_content" class="form-control" rows="4"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kích hoạt</label>
                                <div class="form-check">
                                    <input class="form-check-input" value="1" id="edit_active" name="active"
                                        type="radio" required>
                                    <label class="form-check-label" for="edit_active">Có</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" value="0" id="edit_no_active" name="active"
                                        type="radio">
                                    <label class="form-check-label" for="edit_no_active">Không</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Cập nhật danh mục</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CKEditor Initialization -->
    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#edit_content'))
            .catch(error => {
                console.error(error);
            });

        function generateSlug() {
            let nameInput = document.querySelector('#name');
            let slugInput = document.querySelector('#slug');
            // Replace spaces with dashes and convert to lowercase
            slugInput.value = nameInput.value.trim().toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
        }
        function removeDuplicateOptions(selectElement, currentMenuId) {
            const options = Array.from(selectElement.options);
            const uniqueOptions = [...new Map(options.map(option => [option.value, option])).values()];

            selectElement.innerHTML = ''; // Xóa tất cả các tùy chọn hiện tại

            uniqueOptions.forEach(option => {
                // Bỏ qua tùy chọn nếu nó trùng với id của menu hiện tại
                if (option.value !== currentMenuId) {
                    selectElement.appendChild(option); // Thêm lại các tùy chọn duy nhất
                }
            });
        }
        function openEditModal(menu) {
            // Set the form action to the correct route
            document.getElementById('editMenuForm').action = `/menus/${menu.id}`; // Adjust to your route

            // Set the input values for the modal
            document.getElementById('edit_name').value = menu.name;
            document.getElementById('edit_slug').value = menu.slug;
            document.getElementById('edit_parent_id').value = menu.parent_id;
            document.getElementById('edit_description').value = menu.description;
            document.getElementById('edit_content').value = menu.content;

            // Set the active state
            document.getElementById('edit_active').checked = menu.active == 1;
            document.getElementById('edit_no_active').checked = menu.active == 0;

            // Xóa giá trị trùng lặp trước khi mở modal
            const parentSelect = document.getElementById('edit_parent_id');
            removeDuplicateOptions(parentSelect, menu.id);
            // Open the modal
            var editModal = new bootstrap.Modal(document.getElementById('editMenuModal'));
            editModal.show();
            document.getElementById('editMenuForm').action = "{{ url('admin/menus/update') }}/" + menu.id;
        }
        document.getElementById('editMenuForm').addEventListener('submit', function (event) {
            // Lấy giá trị của trường mô tả chi tiết
            var editContent = document.getElementById('edit_content').value.trim();

            // Kiểm tra xem có bỏ trống không
            if (editContent === '') {
                event.preventDefault(); // Ngăn không cho gửi biểu mẫu
                alert('Mô tả chi tiết không được để trống!'); // Hiển thị thông báo lỗi
            }
        });
        function confirmDelete() {
            return confirm('Bạn có chắc chắn muốn xóa danh mục này không?'); // Hiển thị hộp thoại xác nhận
        }
    </script>
</body>

</html>