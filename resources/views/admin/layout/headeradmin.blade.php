<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Sidebar styling */
        #sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            height: 100vh;
            position: fixed;
            left: -250px;
            top: 0;
            transition: left 0.3s ease;
            padding: 15px;
            z-index: 1000;
        }

        #sidebar.show {
            left: 0;
        }

        /* Sidebar nav link styling */
        #sidebar .nav-link {
            color: #c2c7d0;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.2s, color 0.2s;
        }

        #sidebar .nav-link:hover {
            background-color: #495057;
            color: white;
        }

        /* Content area styling */
        #content {
            margin-left: 0;
            transition: margin-left 0.3s ease;
            padding: 20px;
            width: 100%;
        }

        #sidebar.show + #content {
            margin-left: 250px;
        }

        /* Toggle button styling */
        .toggle-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: background-color 0.2s, left 0.3s ease;
        }

        .toggle-btn:hover {
            background-color: #0056b3;
        }

        /* "X" button styling inside the sidebar */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: transparent;
            color: white;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        .close-btn:hover {
            color: #ff4d4d;
        }
    </style>
    <title>Admin Dashboard</title>
</head>

<body>
    <!-- Sidebar -->
    <div id="sidebar">
        <button class="close-btn" id="closeSidebarBtn">✖</button>
        <h4>Admin Menu</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="#">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('menus.index') }}">Category</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products.index') }}">Product</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.index') }}">Web</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('edit.index') }}">Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('slide.index') }}">SlideBar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Users</a>
            </li>
            
            <!-- Logout Button -->
            <li class="nav-item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link text-white" >Logout</button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Toggle Button -->
    <button class="btn toggle-btn" id="toggleSidebarBtn">☰</button>

    <!-- Main Content -->
    

    <script>
        const toggleBtn = document.getElementById('toggleSidebarBtn');
        const sidebar = document.getElementById('sidebar');
        const closeBtn = document.getElementById('closeSidebarBtn');

        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            toggleBtn.style.display = 'none'; // Hide the toggle button when sidebar is open
        });

        closeBtn.addEventListener('click', function () {
            sidebar.classList.remove('show');
            toggleBtn.style.display = 'block'; // Show the toggle button when sidebar is closed
        });
    </script>

    <!-- Include Bootstrap JS (optional for other interactions) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
