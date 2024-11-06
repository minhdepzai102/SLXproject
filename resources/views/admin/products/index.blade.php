@include('admin.layout.headeradmin')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <!-- Bootstrap CSS --><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CKEditor CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.0/classic/ckeditor.js"></script>
</head>

<body>
    @include('admin.menu.error') <!-- Ensure this partial exists and handles error messages -->

    <div class="container mt-5">
        <h1 class="mb-4">{{ $title }}</h1>

        <!-- Button to trigger modal for adding a new product -->
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="bi bi-plus-circle"></i> Thêm sản phẩm
        </button>

        <!-- Search form -->
        <form action="{{ route('products.index') }}" method="GET" class="mb-3">
            <input type="text" name="search" placeholder="Tìm sản phẩm..." value="{{ request()->input('search') }}" class="form-control" style="width: 300px; display: inline-block;">
            <button type="submit" class="btn btn-info">Tìm kiếm</button>
        </form>

        <!-- Table to display products -->
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th>Giá Sale</th>
                    <th>Kích hoạt</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
        @if($product->thumb)
            <img src="{{ asset('public/storage/' . $product->thumb) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 100px; height: auto;">
        @else
            <img src="{{ asset('path/to/default/image.jpg') }}" alt="No Image" class="img-thumbnail" style="width: 100px; height: auto;">
        @endif
    </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ number_format($product->price) }} VNĐ</td>
                        <td>{{ number_format($product->price_sale) }} VNĐ</td>
                        <td>{{ $product->active ? 'Có' : 'Không' }}</td>
                        <td>
                            <!-- Button to trigger modal for editing -->
                            <button class="btn btn-warning btn-sm" onclick="openEditModal({{ json_encode($product) }})">
                                <i class="bi bi-pencil"></i> Sửa
                            </button>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div>
            {{ $products->links() }} <!-- Pagination links -->
        </div>

        <!-- Add Product Modal -->
<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Thêm sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="addProductForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên sản phẩm:</label>
                        <input placeholder="Nhập tên sản phẩm" type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung</label>
                        <textarea name="content" id="content" class="form-control" rows="4" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="price" class="form-label">Giá</label>
                        <input type="number" id="price" name="price" class="form-control" required>
                    </div>
                    <div class="mb-3">
    <label for="price_sale" class="form-label">Giá Sale</label>
    <input type="number" id="price_sale" name="price_sale" class="form-control" required>
</div>

                    <div class="mb-3">
    <label for="category_id" class="form-label">Danh mục</label>
    <select name="menu_id" id="menu_id" class="form-select" required>
        <option value="">Chọn danh mục</option>
        @foreach($menus as $menu)
            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
        @endforeach
    </select>
</div>

                    <div class="mb-3">
                        <label for="thumb" class="form-label">Hình thu nhỏ (Thumbnail)</label>
                        <input type="file" id="thumb" name="thumb" class="form-control" accept="image/*" required>
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
                    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Sửa sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" id="editProductForm">
                    @csrf
                    @method('PUT') <!-- Change to PUT for update -->
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Tên sản phẩm:</label>
                        <input placeholder="Nhập tên sản phẩm" type="text" id="edit_name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Mô tả</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_content" class="form-label">Nội dung</label>
                        <textarea name="content" id="edit_content" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Giá</label>
                        <input type="number" id="edit_price" name="price" class="form-control" required>
                    </div>
                    <div class="mb-3">
    <label for="edit_price_sale" class="form-label">Giá Sale</label>
    <input type="number" id="edit_price_sale" name="price_sale" class="form-control" required>
</div>

                    <div class="mb-3">
    <label for="category_id" class="form-label">Danh mục</label>
    <select name="menu_id" id="menu_id" class="form-select" required>
        <option value="">Chọn danh mục</option>
        @foreach($menus as $menu)
            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
        @endforeach
    </select>
</div>

                    <div class="mb-3">
                        <label for="edit_thumb" class="form-label">Hình thu nhỏ (Thumbnail)</label>
                        <input type="file" id="edit_thumb" name="thumb" class="form-control" accept="image/*">
                        <small>Chọn hình mới nếu bạn muốn thay thế hình hiện tại.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kích hoạt</label>
                        <div class="form-check">
                            <input class="form-check-input" value="1" id="edit_active" name="active" type="radio" required>
                            <label class="form-check-label" for="edit_active">Có</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" value="0" id="edit_no_active" name="active" type="radio">
                            <label class="form-check-label" for="edit_no_active">Không</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
                </form>
            </div>
        </div>
    </div>
</div>



    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ClassicEditor
        //     .create(document.querySelector('#content'))
        //     .catch(error => {
        //         console.error(error);
        //     });
        // ClassicEditor
        //     .create(document.querySelector('#edit_content'))
        //     .catch(error => {
        //         console.error(error);
        //     });

        function openEditModal(product) {
            // Kiểm tra xem biến product có giá trị hay không
            if (product) {
                // Set the form action to the correct route
                document.getElementById('editProductForm').action = `{{ route('products.update', '') }}/${product.id}`; // Set the route with product ID
                // Set the input values for the modal
                document.getElementById('edit_name').value = product.name;
                document.getElementById('edit_description').value = product.description;
                document.getElementById('edit_price').value = product.price;
                document.getElementById('edit_price_sale').value = product.price_sale;
                document.getElementById('edit_content').value = product.content;
                // Set the active state
                document.getElementById('edit_active').checked = product.active == 1;
                document.getElementById('edit_no_active').checked = product.active == 0;

                // Open the modal
                var editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                editModal.show();
            } else {
                console.error('Product không hợp lệ');
            }
        }

        function confirmDelete() {
            return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?'); // Show confirmation dialog
        }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    const productTableBody = document.querySelector('table tbody');

    searchInput.addEventListener('input', debounce(function() {
        const query = this.value;

        fetch(`/api/products/search?query=${query}`)
            .then(response => response.json())
            .then(products => {
                productTableBody.innerHTML = '';

                products.forEach((product, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>
                            <img src="{{ asset('storage/') }}/${product.thumb || 'path/to/default/image.jpg'}" alt="${product.name}" class="img-thumbnail" style="width: 100px; height: auto;">
                        </td>
                        <td>${product.name}</td>
                        <td>${product.description}</td>
                        <td>${new Intl.NumberFormat().format(product.price)} VNĐ</td>
                        <td>${new Intl.NumberFormat().format(product.price_sale)} VNĐ</td>
                        <td>${product.active ? 'Có' : 'Không'}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="openEditModal(${JSON.stringify(product)})">
                                <i class="bi bi-pencil"></i> Sửa
                            </button>
                            <form action="{{ route('products.destroy', '') }}/${product.id}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Xóa</button>
                            </form>
                        </td>
                    `;
                    productTableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching products:', error));
    }, 300));
});

function debounce(func, delay) {
    let timeout;
    return function(...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), delay);
    };
}


</script>

</body>

</html>
