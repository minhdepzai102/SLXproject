@include('admin.layout.headeradmin')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Shop Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Update Shop Details</h2>
        <form action="{{ route('shop-details.update') }}" method="POST">
            @csrf
            

            <div class="mb-3">
                <label for="name" class="form-label">Shop Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $shop->name ?? '' }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ $shop->email ?? '' }}" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $shop->phone ?? '' }}" required>
            </div>

            <div class="mb-3">
                <label for="facebook" class="form-label">Facebook URL</label>
                <input type="url" class="form-control" id="facebook" name="facebook" value="{{ $shop->facebook ?? '' }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Shop</button>
        </form>
    </div>
</body>
</html>
