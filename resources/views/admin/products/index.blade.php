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
    <style>
        .thumbnail-container {
            position: relative;
            display: inline-block;
            margin-right: 10px;
        }

        .thumbnail-container .img-thumbnail {
            width: 100px;
            height: auto;
        }

        .thumbnail-container span {
            position: absolute;
            top: 5px;
            right: 5px;
            color: red;
            font-size: 16px;
            cursor: pointer;
            background-color: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            padding: 2px 5px;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
        }

        .thumbnail-container span:hover {
            background-color: rgba(255, 255, 255, 0.9);
        }

        .product-thumbs {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .product-thumbs .img-thumbnail {
            width: 100px;
            /* Set the width for each thumbnail */
            height: auto;
            /* Keep the aspect ratio of the images */
            border: 1px solid #ddd;
            /* Optional: add a border around each image */
            padding: 5px;
            /* Optional: add padding inside the image */
            border-radius: 5px;
            /* Optional: add rounded corners to the images */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* Optional: add a soft shadow to the images */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            /* Optional: smooth transition for hover effect */
        }

        .product-thumbs .img-thumbnail:hover {
            transform: scale(1.1);
            /* Slightly enlarge the image on hover */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            /* Darker shadow on hover */
        }
    </style>
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
            <input type="text" name="search" placeholder="Tìm sản phẩm..." value="{{ request()->input('search') }}"
                class="form-control" style="width: 300px; display: inline-block;">
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
                                                        @php
                                                            $thumbs = json_decode($product->thumb); // Decode JSON to get the image array
                                                        @endphp
                                                        <div class="product-thumbs">
                                                            @foreach($thumbs as $thumb)
                                                                <img src="{{ asset('public/storage/' . $thumb) }}" alt="{{ $product->name }}"
                                                                    class="img-thumbnail">
                                                            @endforeach
                                                        </div>
                                    @else
                                        <img src="{{ asset('path/to/default/image.jpg') }}" alt="No Image" class="img-thumbnail">
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
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        style="display:inline;" onsubmit="return confirmDelete();">
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
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Thêm sản phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                            id="addProductForm">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên sản phẩm:</label>
                                <input placeholder="Nhập tên sản phẩm" type="text" id="name" name="name"
                                    class="form-control" required>
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
                                <label for="menu_id" class="form-label">Danh mục</label>
                                <select name="menu_id" id="menu_id" class="form-select" required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach($menus as $menu)
                                        <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="thumb" class="form-label">Hình thu nhỏ (Thumbnail)</label>
                                <input type="file" id="thumb" name="thumb[]" class="form-control" accept="image/*"
                                    multiple required>
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
                            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Product Modal -->
        <!-- Edit Product Modal -->
        <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
            aria-hidden="true">
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
                                <input placeholder="Nhập tên sản phẩm" type="text" id="edit_name" name="name"
                                    class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_description" class="form-label">Mô tả</label>
                                <textarea name="description" id="edit_description" class="form-control"
                                    rows="4"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="edit_content" class="form-label">Nội dung</label>
                                <textarea name="content" id="edit_content" class="form-control" rows="4"
                                    required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="edit_price" class="form-label">Giá</label>
                                <input type="number" id="edit_price" name="price" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_price_sale" class="form-label">Giá Sale</label>
                                <input type="number" id="edit_price_sale" name="price_sale" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_menu_id" class="form-label">Danh mục</label>
                                <select name="menu_id" id="edit_menu_id" class="form-select" required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach($menus as $menu)
                                        <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_thumb" class="form-label">Hình thu nhỏ (Thumbnail)</label>
                                <input type="file" id="edit_thumb" name="thumb[]" class="form-control" accept="image/*"
                                    multiple>

                                <!-- Display existing thumbnails -->
                                <div id="current-thumbnails" class="mt-2">
                                    <!-- Dynamically add images here via JavaScript -->
                                </div>
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
                            <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Optional JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js">

        </script>

        <script>
            const assetUrl = '{{ asset('public/storage') }}';
            function openEditModal(product) {
                document.getElementById('edit_name').value = product.name;
                document.getElementById('edit_description').value = product.description;
                document.getElementById('edit_content').value = product.content;
                document.getElementById('edit_price').value = product.price;
                document.getElementById('edit_price_sale').value = product.price_sale;
                document.getElementById('edit_menu_id').value = product.menu_id;
                document.getElementById(product.active == 1 ? 'edit_active' : 'edit_no_active').checked = true;

                // Update the form action for product update
                document.getElementById('editProductForm').action = `{{ route('products.update', '') }}/${product.id}`; // Set the route with product ID

                // Display existing thumbnails
                const currentThumbnails = document.getElementById('current-thumbnails');
                currentThumbnails.innerHTML = ''; // Clear previous thumbnails

                if (product.thumb) {
                    const thumbs = JSON.parse(product.thumb);
                    thumbs.forEach((thumb, index) => {
                        const div = document.createElement('div');
                        div.classList.add('thumbnail-container');
                        div.style.position = 'relative'; // Enable positioning of delete icon

                        const img = document.createElement('img');
                        img.src = assetUrl + '/' + thumb;
                        img.alt = 'Thumbnail';
                        img.classList.add('img-thumbnail');
                        img.style.width = '100px'; // Adjust size as needed
                        img.style.marginRight = '10px'; // Space between images

                        // Create delete icon
                        const deleteIcon = document.createElement('span');
                        deleteIcon.innerHTML = 'X';
                        deleteIcon.style.position = 'absolute';
                        deleteIcon.style.top = '5px';
                        deleteIcon.style.right = '5px';
                        deleteIcon.style.color = 'white';
                        deleteIcon.style.fontSize = '16px';
                        deleteIcon.style.cursor = 'pointer';
                        deleteIcon.style.zIndex = '10'; // Ensure it's on top of the image
                        deleteIcon.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
                        deleteIcon.style.borderRadius = '50%';
                        deleteIcon.style.padding = '2px 5px';

                        // Append delete icon and image to the div
                        div.appendChild(img);
                        div.appendChild(deleteIcon);

                        // Add delete functionality to the "X" icon
                        deleteIcon.addEventListener('click', function () {
                            // Remove the thumbnail from the preview
                            div.remove();

                            // Remove from form data by adding to the hidden input
                            let removedThumbnails = document.getElementById('removed-thumbnails');
                            if (!removedThumbnails) {
                                // Create a hidden input field to hold the removed image paths
                                removedThumbnails = document.createElement('input');
                                removedThumbnails.type = 'hidden';
                                removedThumbnails.name = 'removed_thumbnails[]'; // Use an array format to store multiple values
                                document.getElementById('editProductForm').appendChild(removedThumbnails);
                            }

                            // Add the removed thumbnail path to the hidden field
                            const thumbValue = thumb; // The value that you want to remove from the data
                            const inputValue = removedThumbnails.value ? removedThumbnails.value + ',' + thumbValue : thumbValue;
                            removedThumbnails.value = inputValue;
                        });

                        // Append the thumbnail container to the display section
                        currentThumbnails.appendChild(div);
                    });
                }

                // Manually trigger the modal to show it
                var myModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                myModal.show();
            }



        </script>

</body>

</html>