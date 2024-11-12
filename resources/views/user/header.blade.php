<nav class="navbar navbar-expand-lg navbar-light shadow">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand text-success logo h1 align-self-center" href="{{ route('user.index') }}">
        {{ $shopDetails->name ?? 'Error' }}
        </a>
        <style>
            .logout-btn {
                color: #333;
                /* Dark text color */
                background-color: transparent;
                /* Transparent background to blend with dropdown */
                border: none;
                /* Remove any border */
                padding: 8px 20px;
                /* Padding to make it consistent with other dropdown items */
                text-align: left;
                /* Align text to the left */
                width: 100%;
                /* Full width to make it span the entire dropdown */
                font-size: 16px;
                /* Adjust font size for better readability */
                transition: background-color 0.3s ease, color 0.3s ease;
                /* Smooth transition for hover */
            }

            .logout-btn:hover {
                background-color: #f8f9fa;
                /* Light background on hover */
                color: #007bff;
                /* Blue text color on hover */
                cursor: pointer;
                /* Pointer cursor */
            }

            .logout-btn:focus {
                outline: none;
                /* Remove focus outline */
                box-shadow: none;
                /* No shadow on focus */
            }
        </style>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between"
            id="templatemo_main_nav">
            <div class="flex-fill">
                <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.shop') }}">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact</a>
                    </li>
                </ul>
            </div>
            <div class="navbar align-self-center d-flex">
                <div class="d-lg-none flex-sm-fill mt-3 mb-4 col-7 col-sm-auto pr-3">
                    <div class="input-group">
                        <input type="text" class="form-control" id="inputMobileSearch" placeholder="Search ...">
                        <div class="input-group-text">
                            <i class="fa fa-fw fa-search"></i>
                        </div>
                    </div>
                </div>
                <a class="nav-icon d-none d-lg-inline" href="#" data-bs-toggle="modal"
                    data-bs-target="#templatemo_search">
                    <i class="fa fa-fw fa-search text-dark mr-2"></i>
                </a>
                <a class="nav-icon position-relative text-decoration-none" href="{{route('cart.index')}}">
                    <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
                    <span
                        class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">7</span>
                </a>

                <!-- Check if user is authenticated -->
                @if(Auth::check())
                    <div class="dropdown">
                        <a class="nav-icon position-relative text-decoration-none" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-fw fa-user text-dark mr-3"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <!-- Hiển thị nút Admin nếu người dùng là admin -->
                            @if(Auth::user()->role == 1)
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin') }}">Admin</a>
                                </li>
                            @endif
                            <!-- Logout Link -->
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>

                    </div>
                @else
                    <!-- Liên kết tới trang đăng nhập -->
                    <a class="nav-icon position-relative text-decoration-none" href="{{ route('login') }}">
                        <i class="fa fa-fw fa-user text-dark mr-3"></i>
                    </a>
                @endif

            </div>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>