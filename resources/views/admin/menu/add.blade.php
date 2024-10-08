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

        <div class="card">
            <div class="card-body">
                <form action="{{ route('menus.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên danh mục:</label>
                        <input placeholder="Nhập tên danh mục" type="text" id="name" name="name" class="form-control"
                            required oninput="generateSlug()">
                    </div>
                    <div class="mb-3">
                        <input hidden type="text" id="slug" name="slug" class="form-control"
                            placeholder="Slug sẽ tự động được tạo" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Danh Mục Cha</label>
                        <select class="form-select" id="parent_id" name="parent_id">
                            <option value="0" selected>Chọn danh mục cha</option>
                            <!-- Thêm các tùy chọn danh mục cha ở đây -->
                            <option value="1">Danh mục 1</option>
                            <option value="2">Danh mục 2</option>
                            <option value="3">Danh mục 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                        <!-- Đổi từ desc sang description -->
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Mô tả chi tiết</label>
                        <textarea name="content" id="content" class="form-control" rows="4"></textarea>
                        <!-- Đổi từ detail_desc sang content -->
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kích hoạt</label>
                        <div class="form-check">
                            <input class="form-check-input" value="1" id="active" name="active" type="radio" required>
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


        <!-- Bootstrap JS (optional) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <!-- CKEditor Initialization -->
        <script>
            ClassicEditor
                .create(document.querySelector('#detail_desc'))
                .catch(error => {
                    console.error(error);
                });

            function generateSlug() {
                let nameInput = document.querySelector('#name');
                let slugInput = document.querySelector('#slug');
                // Replace spaces with dashes and convert to lowercase
                slugInput.value = nameInput.value.trim().toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
            }
        

        </script>
</body>

</html>