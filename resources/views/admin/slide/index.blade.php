<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
@include('admin.layout.headeradmin')

<div class="container mt-5">
    <h1 class="mb-4">{{ $title }}</h1>
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addSlideModal">
        Thêm slide
    </button>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Hình ảnh</th>
                <th>Tên</th>
                <th>URL</th>
                <th>Mô tả</th>
                <th>Sắp xếp</th>
                <th>Kích hoạt</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($slides as $index => $slide)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <img src="{{ asset('public/storage/' . $slide->thumb) }}" alt="{{ $slide->name }}" class="img-thumbnail" style="width: 100px;">
                    </td>
                    <td>{{ $slide->name }}</td>
                    <td>{{ $slide->url ?? 'N/A' }}</td>
                    <td>{{ $slide->desc }}</td>
                    <td>{{ $slide->sort_by }}</td>
                    <td>{{ $slide->active ? 'Có' : 'Không' }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="openEditModal({{ json_encode($slide) }})">
                            Sửa
                        </button>
                        <form action="{{ route('slide.destroy', $slide->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>{{ $slides->links() }}</div>

    <!-- Add Slide Modal -->
    <div class="modal fade" id="addSlideModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm slide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('slide.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="name" class="form-control mb-3" placeholder="Tên slide" required>
                        <input type="text" name="url" class="form-control mb-3" placeholder="URL (tùy chọn)">
                        <textarea name="desc" class="form-control mb-3" placeholder="Mô tả"></textarea>
                        <input type="file" name="thumb" class="form-control mb-3" accept="image/*" required>
                        <input type="number" name="sort_by" class="form-control mb-3" placeholder="Sắp xếp" required>
                        <label>Kích hoạt:</label>
                        <div class="form-check">
                            <input type="radio" name="active" value="1" required> Có
                            <input type="radio" name="active" value="0"> Không
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Thêm slide</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Slide Modal -->
    <div class="modal fade" id="editSlideModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa slide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editSlideForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="text" name="name" id="edit_name" class="form-control mb-3" required>
                        <input type="text" name="url" id="edit_url" class="form-control mb-3">
                        <textarea name="desc" id="edit_desc" class="form-control mb-3"></textarea>
                        <input type="file" name="thumb" id="edit_thumb" class="form-control mb-3" accept="image/*">
                        <input type="number" name="sort_by" id="edit_sort_by" class="form-control mb-3" required>
                        <label>Kích hoạt:</label>
                        <div class="form-check">
                            <input type="radio" name="active" id="edit_active" value="1" required> Có
                            <input type="radio" name="active" id="edit_no_active" value="0"> Không
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Cập nhật slide</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openEditModal(slide) {
        // Generate the update route correctly using Laravel's route helper
        const updateRoute = `{{ route('slide.update', ':slide') }}`;
        document.getElementById('editSlideForm').action = updateRoute.replace(':slide', slide.id); // Replace placeholder with actual ID
        
        document.getElementById('edit_name').value = slide.name;
        document.getElementById('edit_url').value = slide.url || '';
        document.getElementById('edit_desc').value = slide.desc || '';
        document.getElementById('edit_sort_by').value = slide.sort_by;
        document.getElementById('edit_active').checked = slide.active == 1;
        document.getElementById('edit_no_active').checked = slide.active == 0;
        
        // Show the modal
        new bootstrap.Modal(document.getElementById('editSlideModal')).show();
    }

    function confirmDelete() {
        return confirm('Bạn có chắc chắn muốn xóa slide này không?');
    }
</script>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>
</html>
