<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>.notification {
        position: fixed;
        top: 20px;
        /* Distance from the top */
        left: 50%;
        transform: translateX(-50%);
        background-color: #f44336;
        /* Red background color */
        color: white;
        /* White text color */
        padding: 15px 20px;
        /* Padding */
        border-radius: 5px;
        /* Rounded corners */
        z-index: 1000;
        /* Make sure it is on top of other content */
        opacity: 1;
        /* Start fully visible */
        transition: opacity 0.5s ease;
        /* Transition for fading out */
        display: none;
        /* Hide by default */
    }

    .notification.show {
        display: block;
        /* Show the notification */
    }
</style>
    <title>Admin Dashboard</title>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const notification = document.querySelector('.notification');

        if (notification) {
            notification.classList.add('show'); // Show the notification

            setTimeout(() => {
                notification.style.opacity = '0'; // Start fading out
                setTimeout(() => {
                    notification.remove(); // Remove from DOM after fade out
                }, 500); // Match this to the transition duration in CSS
            }, 3000); // Display for 3 seconds
        }
    });
</script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('menus.index') }}">Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Settings</a>
                    </li>
                    <!-- Logout Button -->
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Include Bootstrap JS for navbar functionality -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
