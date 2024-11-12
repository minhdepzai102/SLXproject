<!DOCTYPE html>
<html lang="en">

<head>
    <title>Zay Shop - Product Listing Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <link rel="stylesheet" href="{{ asset('resources/views/user/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('resources/views/user/assets/css/templatemo.css')}}">
    <link rel="stylesheet" href="{{ asset('resources/views/user/assets/css/custom.css')}}">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="{{ asset('resources/views/user/assets/css/fontawesome.min.css')}}">
    <!--
    
TemplateMo 559 Zay Shop

https://templatemo.com/tm-559-zay-shop

-->
</head>
<style>
    .product-img {
        width: 100%;
        /* Makes the image fill the container width */
        height: 200px;
        /* Fixed height for consistency */
        object-fit: cover;
        /* Ensures the image covers the area without distortion */
    }

    .card-img {
        width: 100%;
        /* Ensure the image container takes up the full width of the card */
        height: 200px;
        /* Fixed height for image consistency */
        overflow: hidden;
        /* Ensures any excess parts of the image are hidden */
    }

    .product-wap {
        height: 350px;
        /* Set a fixed height for the whole card */
    }

    .templatemo-accordion ul {
        display: none;
        /* Hide child menus by default */
        padding-left: 15px;
    }

    .templatemo-accordion .open>ul {
        display: block;
        /* Show child menus when open class is added */
    }

    .templatemo-accordion a .fa-chevron-circle-down {
        transition: transform 0.3s ease;
    }

    .templatemo-accordion .open>a .fa-chevron-circle-down {
        transform: rotate(180deg);
        /* Rotate arrow when open */
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-submenu').forEach(function (menuToggle) {
            menuToggle.addEventListener('click', function () {
                const parentLi = this.parentElement;
                parentLi.classList.toggle('open'); // Toggle the open class to show/hide child menu
            });
        });
    });

</script>


<!-- Start Top Nav -->
<nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="templatemo_nav_top">
    <div class="container text-light">
        <div class="w-100 d-flex justify-content-between">
            <div>
                <i class="fa fa-envelope mx-2"></i>
                <a class="navbar-sm-brand text-light text-decoration-none" href="mailto:{{ $shopDetails->email ?? 'info@company.com' }}">
                    {{ $shopDetails->email ?? 'info@company.com' }}
                </a>
                <i class="fa fa-phone mx-2"></i>
                <a class="navbar-sm-brand text-light text-decoration-none" href="tel:{{ $shopDetails->phone ?? '010-020-0340' }}">
                    {{ $shopDetails->phone ?? '010-020-0340' }}
                </a>
            </div>
            <div>
                <a class="text-light" href="{{ $shopDetails->facebook ?? '#' }}" target="_blank"><i class="fab fa-facebook-f fa-sm fa-fw me-2"></i></a>
                <a class="text-light" href="{{ $shopDetails->instagram ?? '#' }}" target="_blank"><i class="fab fa-instagram fa-sm fa-fw me-2"></i></a>
                <a class="text-light" href="{{ $shopDetails->twitter ?? '#' }}" target="_blank"><i class="fab fa-twitter fa-sm fa-fw me-2"></i></a>
                <a class="text-light" href="{{ $shopDetails->linkedin ?? '#' }}" target="_blank"><i class="fab fa-linkedin fa-sm fa-fw"></i></a>
            </div>
        </div>
    </div>
</nav>
<!-- Close Top Nav -->


<!-- Header -->
@include('user.header')
<!-- Close Header -->

<!-- Modal -->
@include('user.modalsearch');
<!-- Start Content -->
<div class="container py-5">
    <div class="row">

        <div class="col-lg-3">
            <h1 class="h2 pb-4">Categories</h1>
            <ul class="list-unstyled templatemo-accordion">
                @foreach ($menus->where('parent_id', 0) as $parentMenu)
                    <li class="pb-3">
                        <a class="d-flex justify-content-between h3 text-decoration-none toggle-submenu"
                            href="javascript:void(0);">
                            {{ $parentMenu->name }}
                            <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
                        </a>

                        @if ($menus->where('parent_id', $parentMenu->id)->count() > 0)
                            <ul class="list-unstyled pl-3">
                                @foreach ($menus->where('parent_id', $parentMenu->id) as $childMenu)
                                    <li>
                                        <a class="text-decoration-none" href="{{ route('shop.category', $childMenu->id) }}">
                                            {{ $childMenu->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="col-lg-9">
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-inline shop-top-menu pb-3 pt-1">
                        <li class="list-inline-item">
                            <a class="h3 text-dark text-decoration-none mr-3" href="{{ route('shop.all') }}">All</a>
                        </li>
                        @foreach ($menus->where('parent_id', 0) as $parentMenu)

                            <li class="list-inline-item">
                                <a class="h3 text-dark text-decoration-none mr-3"
                                    href="{{ route('shop.category', $parentMenu->id) }}">{{ $parentMenu->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6 pb-4">
                    <div class="d-flex">
                        <select class="form-control" onchange="window.location.href=this.value">
                            <!-- <option value="{{ route('shop.all') }}" {{ request()->sort_by == null ? 'selected' : '' }}>Featured</option>
                            <option value="{{ route('shop.all') }}?random=true" {{ request()->random == 'true' ? 'selected' : '' }}>Random</option> -->
                            <option value="{{ route('user.shop') }}?sort_by=a_to_z" {{ request()->sort_by == 'a_to_z' ? 'selected' : '' }}>A to Z</option>
                            <option value="{{ route('user.shop') }}?sort_by=z_to_a" {{ request()->sort_by == 'z_to_a' ? 'selected' : '' }}>Z to A</option>
                            <option value="{{ route('user.shop') }}?sort_by=price_low_to_high" {{ request()->sort_by == 'price_low_to_high' ? 'selected' : '' }}>Price Low to High</option>
                            <option value="{{ route('user.shop') }}?sort_by=price_high_to_low" {{ request()->sort_by == 'price_high_to_low' ? 'selected' : '' }}>Price High to Low</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($products as $product)
                                <div class="col-md-4">
                                    <div class="card mb-4 product-wap rounded-0">
                                        <div class="card rounded-0">
                                            @php
                                                $thumbs = json_decode($product->thumb); // Giải mã JSON từ mảng hình ảnh
                                            @endphp
                                            @if($thumbs && count($thumbs) > 0)
                                                <img class="img-fluid product-img" src="{{ asset('public/storage/' . $thumbs[0]) }}">
                                            @endif


                                            <div
                                                class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                                <ul class="list-unstyled">
                                                    <li><a class="btn btn-success text-white" href="shop-single.html"><i
                                                                class="far fa-heart"></i></a></li>
                                                    <a class="btn btn-success text-white mt-2"
                                                        href="{{ route('product.single', $product->id) }}">
                                                        <i class="far fa-eye"></i>
                                                    </a>

                                                    <li><a class="btn btn-success text-white mt-2" href="shop-single.html"><i
                                                                class="fas fa-cart-plus"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p>{{ $product->name }}</p>
                                            @if($product->price_sale && $product->price_sale != $product->price)
                                                <!-- Sale Price with Discount -->
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-muted" style="text-decoration: line-through;">
                                                        {{ number_format($product->price, 0, ',', '.') }} VND
                                                    </p>
                                                    <p class="text-success">
                                                        {{ round(((($product->price - $product->price_sale) / $product->price) * 100), 0) }}%
                                                        OFF
                                                    </p>
                                                </div>
                                                <p class="text-danger h5">
                                                    {{ number_format($product->price_sale, 0, ',', '.') }} VND
                                                </p>
                                            @else
                                                <!-- Regular Price -->
                                                <p class="text-left mb-0">{{ number_format($product->price, 0, ',', '.') }} VND</p>

                                            @endif
                                        </div>
                                    </div>
                                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>


<!-- End Content -->

<!-- Start Brands -->
<section class="bg-light py-5">
    <div class="container my-4">
        <div class="row text-center py-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Our Brands</h1>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    Lorem ipsum dolor sit amet.
                </p>
            </div>
            <div class="col-lg-9 m-auto tempaltemo-carousel">
                <div class="row d-flex flex-row">
                    <!--Controls-->
                    <div class="col-1 align-self-center">
                        <a class="h1" href="#multi-item-example" role="button" data-bs-slide="prev">
                            <i class="text-light fas fa-chevron-left"></i>
                        </a>
                    </div>
                    <!--End Controls-->

                    <!--Carousel Wrapper-->
                    <div class="col">
                        <div class="carousel slide carousel-multi-item pt-2 pt-md-0" id="multi-item-example"
                            data-bs-ride="carousel">
                            <!--Slides-->
                            <div class="carousel-inner product-links-wap" role="listbox">

                                <!--First slide-->
                                <div class="carousel-item active">
                                    <div class="row">
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_01.png"
                                                    alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_02.png"
                                                    alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_03.png"
                                                    alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_04.png"
                                                    alt="Brand Logo"></a>
                                        </div>
                                    </div>
                                </div>
                                <!--End First slide-->

                                <!--Second slide-->
                                <div class="carousel-item">
                                    <div class="row">
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_01.png"
                                                    alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_02.png"
                                                    alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_03.png"
                                                    alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_04.png"
                                                    alt="Brand Logo"></a>
                                        </div>
                                    </div>
                                </div>
                                <!--End Second slide-->

                                <!--Third slide-->
                                <div class="carousel-item">
                                    <div class="row">
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_01.png"
                                                    alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_02.png"
                                                    alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_03.png"
                                                    alt="Brand Logo"></a>
                                        </div>
                                        <div class="col-3 p-md-5">
                                            <a href="#"><img class="img-fluid brand-img" src="assets/img/brand_04.png"
                                                    alt="Brand Logo"></a>
                                        </div>
                                    </div>
                                </div>
                                <!--End Third slide-->

                            </div>
                            <!--End Slides-->
                        </div>
                    </div>
                    <!--End Carousel Wrapper-->

                    <!--Controls-->
                    <div class="col-1 align-self-center">
                        <a class="h1" href="#multi-item-example" role="button" data-bs-slide="next">
                            <i class="text-light fas fa-chevron-right"></i>
                        </a>
                    </div>
                    <!--End Controls-->
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Brands-->


<!-- Start Footer -->
<footer class="bg-dark" id="tempaltemo_footer">
    <div class="container">
        <div class="row">

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-success border-bottom pb-3 border-light logo">Zay Shop</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <li>
                        <i class="fas fa-map-marker-alt fa-fw"></i>
                        123 Consectetur at ligula 10660
                    </li>
                    <li>
                        <i class="fa fa-phone fa-fw"></i>
                        <a class="text-decoration-none" href="tel:010-020-0340">010-020-0340</a>
                    </li>
                    <li>
                        <i class="fa fa-envelope fa-fw"></i>
                        <a class="text-decoration-none" href="mailto:info@company.com">info@company.com</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-light border-bottom pb-3 border-light">Products</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <li><a class="text-decoration-none" href="#">Luxury</a></li>
                    <li><a class="text-decoration-none" href="#">Sport Wear</a></li>
                    <li><a class="text-decoration-none" href="#">Men's Shoes</a></li>
                    <li><a class="text-decoration-none" href="#">Women's Shoes</a></li>
                    <li><a class="text-decoration-none" href="#">Popular Dress</a></li>
                    <li><a class="text-decoration-none" href="#">Gym Accessories</a></li>
                    <li><a class="text-decoration-none" href="#">Sport Shoes</a></li>
                </ul>
            </div>

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-light border-bottom pb-3 border-light">Further Info</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <li><a class="text-decoration-none" href="#">Home</a></li>
                    <li><a class="text-decoration-none" href="#">About Us</a></li>
                    <li><a class="text-decoration-none" href="#">Shop Locations</a></li>
                    <li><a class="text-decoration-none" href="#">FAQs</a></li>
                    <li><a class="text-decoration-none" href="#">Contact</a></li>
                </ul>
            </div>

        </div>

        <div class="row text-light mb-4">
            <div class="col-12 mb-3">
                <div class="w-100 my-3 border-top border-light"></div>
            </div>
            <div class="col-auto me-auto">
                <ul class="list-inline text-left footer-icons">
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="http://facebook.com/"><i
                                class="fab fa-facebook-f fa-lg fa-fw"></i></a>
                    </li>
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="https://www.instagram.com/"><i
                                class="fab fa-instagram fa-lg fa-fw"></i></a>
                    </li>
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="https://twitter.com/"><i
                                class="fab fa-twitter fa-lg fa-fw"></i></a>
                    </li>
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="https://www.linkedin.com/"><i
                                class="fab fa-linkedin fa-lg fa-fw"></i></a>
                    </li>
                </ul>
            </div>
            <div class="col-auto">
                <label class="sr-only" for="subscribeEmail">Email address</label>
                <div class="input-group mb-2">
                    <input type="text" class="form-control bg-dark border-light" id="subscribeEmail"
                        placeholder="Email address">
                    <div class="input-group-text btn-success text-light">Subscribe</div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100 bg-black py-3">
        <div class="container">
            <div class="row pt-2">
                <div class="col-12">
                    <p class="text-left text-light">
                        Copyright &copy; 2021 Company Name
                        | Designed by <a rel="sponsored" href="https://templatemo.com" target="_blank">TemplateMo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</footer>
<!-- End Footer -->

<!-- Start Script -->
<script src="{{ asset('resources/views/user/assets/js/jquery-1.11.0.min.js')}}"></script>
<script src="{{ asset('resources/views/user/assets/js/jquery-migrate-1.2.1.min.js')}}"></script>
<script src="{{ asset('resources/views/user/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('resources/views/user/assets/js/templatemo.js')}}"></script>
<script src="{{ asset('resources/views/user/assets/js/custom.js')}}"></script>
<!-- End Script -->
</body>

</html>