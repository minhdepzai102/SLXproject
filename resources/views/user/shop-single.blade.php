<!DOCTYPE html>
<html lang="en">

<head>
    <title>Zay Shop - Product Detail Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Icon Apple và Favicon -->
    <link rel="apple-touch-icon" href="{{ asset('resources/views/user/assets/img/apple-icon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('resources/views/user/assets/img/favicon.ico') }}">

    <!-- Các file CSS -->
    <link rel="stylesheet" href="{{ asset('resources/views/user/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/views/user/assets/css/templatemo.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/views/user/assets/css/custom.css') }}">

    <!-- Load fonts style sau khi render layout styles -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="{{ asset('resources/views/user/assets/css/fontawesome.min.css') }}">

    <!-- Slick -->
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/views/user/assets/css/slick.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/views/user/assets/css/slick-theme.css') }}">


    <style>
        .product-wap .card-img {
            width: 100%;
            /* Ensures the image takes up the full width of the card */
            height: 250px;
            /* Set a fixed height for all images */
            object-fit: cover;
            /* Ensures the image covers the entire container while maintaining aspect ratio */
        }
    </style>
</head>

<body>
    <!-- Start Top Nav -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="templatemo_nav_top">
        <div class="container text-light">
            <div class="w-100 d-flex justify-content-between">
                <div>
                    <i class="fa fa-envelope mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none"
                        href="mailto:{{ $shopDetails->email ?? 'info@company.com' }}">
                        {{ $shopDetails->email ?? 'info@company.com' }}
                    </a>
                    <i class="fa fa-phone mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none"
                        href="tel:{{ $shopDetails->phone ?? '010-020-0340' }}">
                        {{ $shopDetails->phone ?? '010-020-0340' }}
                    </a>
                </div>
                <div>
                    <a class="text-light" href="{{ $shopDetails->facebook ?? '#' }}" target="_blank"><i
                            class="fab fa-facebook-f fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="{{ $shopDetails->instagram ?? '#' }}" target="_blank"><i
                            class="fab fa-instagram fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="{{ $shopDetails->twitter ?? '#' }}" target="_blank"><i
                            class="fab fa-twitter fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="{{ $shopDetails->linkedin ?? '#' }}" target="_blank"><i
                            class="fab fa-linkedin fa-sm fa-fw"></i></a>
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
    <!-- Open Content -->
    <section class="bg-light">
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-5 mt-5">
                    <div class="card mb-3">
                        @php
                            $thumbs = json_decode($product->thumb); // Giải mã JSON từ mảng hình ảnh
                        @endphp

                        <!-- Kiểm tra nếu có hình ảnh, lấy hình đầu tiên -->
                        @if($thumbs && count($thumbs) > 0)
                            <img class="card-img img-fluid" src="{{ asset('public/storage/' . $thumbs[0]) }}"
                                alt="{{ $product->name }}" id="product-detail"
                                style="width: 522px; height: 522px; object-fit: cover;">
                        @endif

                    </div>
                    <div class="row">
                        <!--Start Controls-->
                        <div class="col-1 align-self-center">
                            <a href="#multi-item-example" role="button" data-bs-slide="prev">
                                <i class="text-dark fas fa-chevron-left"></i>
                                <span class="sr-only">Previous</span>
                            </a>
                        </div>
                        <!--End Controls-->
                        <!--Start Carousel Wrapper-->
                        <div id="multi-item-example" class="col-10 carousel slide carousel-multi-item"
                            data-bs-ride="carousel">
                            <!--Start Slides-->
                            <div class="carousel-inner product-links-wap" role="listbox">

                                <!--First slide-->
                                @foreach(array_chunk($thumbs, 3) as $chunk)
                                    <div class="carousel-item @if($loop->first) active @endif">
                                        <div class="row">
                                            @foreach($chunk as $thumb)
                                                <div class="col-4">
                                                    <a href="#">
                                                        <img class="card-img img-fluid"
                                                            src="{{ asset('public/storage/' . $thumb) }}"
                                                            style="width: 150px; height: 150px;" alt="Product Image">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                <!--/.First slide-->
                                <!--/.Third slide-->
                            </div>
                            <!--End Slides-->
                        </div>
                        <!--End Carousel Wrapper-->
                        <!--Start Controls-->
                        <div class="col-1 align-self-center">
                            <a href="#multi-item-example" role="button" data-bs-slide="next">
                                <i class="text-dark fas fa-chevron-right"></i>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <!--End Controls-->
                    </div>
                </div>
                <!-- col end -->

                <div class="col-lg-7 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="h2">{{ $product->name }}</h1>
                            @if($product->price_sale && $product->price_sale < $product->price)
                                                        @php
                                                            $discountPercentage = round((($product->price - $product->price_sale) / $product->price) * 100);
                                                        @endphp
                                                        <p class="h3 py-2">
                                                            <span class="text-danger">{{ number_format($product->price_sale, 0, ',', '.') }}
                                                                VND</span>
                                                            <span
                                                                class="text-muted text-decoration-line-through">{{ number_format($product->price, 0, ',', '.') }}
                                                                VND</span>
                                                            <span class="badge bg-success ms-2">-{{ $discountPercentage }}%</span>
                                                        </p>
                            @else
                                <p class="h3 py-2">{{ number_format($product->price, 0, ',', '.') }} VND</p>
                            @endif

                            <p class="py-2">
                                <!-- Star rating -->
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star" data-index="{{ $i }}" data-product-id="{{ $product->id }}"
                                        class="star-rating {{ $i <= $product->averageRating() ? 'text-warning' : 'text-secondary' }}"
                                        style="cursor: pointer;"></i>
                                @endfor
                                <span class="list-inline-item text-dark">
                                    Rating: <span
                                        id="rating-value">{{ number_format($product->averageRating(), 1) }}</span> |
                                    <span id="comment-count">{{ $product->ratings->count() }}</span> Comments
                                </span>
                            </p>

                            <script>
                                // JavaScript to handle star click
                                document.querySelectorAll('.star-rating').forEach(star => {
                                    star.addEventListener('click', function () {
                                        let rating = this.getAttribute('data-index');
                                        let productId = this.getAttribute('data-product-id');

                                        console.log(`Clicked on star: ${rating} for product ID: ${productId}`);

                                        // Gọi function để update rating qua AJAX
                                        updateRating(rating, productId);
                                    });
                                });

                                function updateRating(rating, productId) {
                                    // Send AJAX request to update rating
                                    fetch(`http://127.0.0.1/SLXproject/user/product/${productId}/rate`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({ rating: rating })
                                    })

                                        .then(response => response.json())
                                        .then(data => {
                                            // Update the UI with the new rating
                                            if (data.success) {
                                                let stars = document.querySelectorAll('.star-rating');
                                                stars.forEach(star => {
                                                    if (star.getAttribute('data-index') <= rating) {
                                                        star.classList.add('text-warning');
                                                        star.classList.remove('text-secondary');
                                                    } else {
                                                        star.classList.add('text-secondary');
                                                        star.classList.remove('text-warning');
                                                    }
                                                });

                                                // Update rating value
                                                document.getElementById('rating-value').innerText = data.new_rating;
                                                document.getElementById('comment-count').innerText = data.comment_count;
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                        });
                                }
                            </script>


                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6>Brand:</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted"><strong>{{ $product->description }}</strong></p>
                                </li>
                            </ul>

                            <h6>Description:</h6>
                            <p>{{ $product->content }}</p>

                            <form action="" method="GET">
                                <input type="hidden" name="product-title" value="{{ $product->name }}">
                                <div class="row">
                                    <div class="col-auto">
                                        <ul class="list-inline pb-3">
                                            <li class="list-inline-item">Size:
                                                <input type="hidden" name="product-size" id="product-size"
                                                    value="{{ implode(',', $sizes) }}">
                                            </li>
                                            @foreach ($sizes as $size)
                                                <li class="list-inline-item">
                                                    <span class="btn btn-success btn-size">{{ $size }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <div class="col-auto">
                                        <ul class="list-inline pb-3">
                                            <li class="list-inline-item text-right">
                                                Quantity
                                                <input type="hidden" name="product-quanity" id="product-quanity"
                                                    value="1">
                                            </li>
                                            <li class="list-inline-item"><span class="btn btn-success"
                                                    id="btn-minus">-</span></li>
                                            <li class="list-inline-item"><span class="badge bg-secondary"
                                                    id="var-value">1</span></li>
                                            <li class="list-inline-item"><span class="btn btn-success"
                                                    id="btn-plus">+</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Form để xử lý thêm vào giỏ hàng và mua ngay -->
                                <div class="row pb-3">
                                    <div class="col d-grid">
                                        <button type="submit" class="btn btn-success btn-lg" name="submit"
                                            value="buy">Buy Now</button>
                                    </div>
                                    <div class="col d-grid">
                                        <button type="submit" class="btn btn-success btn-lg" name="submit"
                                            value="addtocard">Add To Cart</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Close Content -->

    <!-- Start Article -->
    <section class="py-5">
        <div class="container">
            <div class="row text-left p-2 pb-3">
                <h4>Related Products</h4>
            </div>

            <!--Start Carousel Wrapper-->
            <div id="carousel-related-product">

                @foreach ($relatedProducts as $product)
                                <div class="col-md-4 p-2 pb-3">
                                    <div class="product-wap card rounded-0 h-100 d-flex flex-column">
                                        <div class="card rounded-0">
                                            @php
                                                $thumbs = json_decode($product->thumb); // Giải mã JSON từ mảng hình ảnh
                                            @endphp

                                            <!-- Hiển thị hình ảnh đầu tiên nếu có -->
                                            @if($thumbs && count($thumbs) > 0)
                                                <img class="card-img rounded-0 img-fluid" src="{{ asset('public/storage/' . $thumbs[0]) }}">
                                            @else
                                                <!-- Hiển thị hình mặc định nếu không có ảnh -->
                                                <img class="card-img rounded-0 img-fluid" src="path/to/default/image.jpg"
                                                    alt="Default Image">
                                            @endif

                                            <div
                                                class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <a class="btn btn-success text-white" href="#">
                                                            <i class="far fa-heart"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="btn btn-success text-white mt-2"
                                                            href="{{ route('product.single', $product->id) }}">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="btn btn-success text-white mt-2" href="#">
                                                            <i class="fas fa-cart-plus"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column h-100">
                                            <a href="{{ route('product.single', $product->id) }}"
                                                class="h3 text-decoration-none">{{ $product->name }}</a>
                                            <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                                <li class="pt-2">
                                                    <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                                    <span
                                                        class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                                    <span
                                                        class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                                    <span
                                                        class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                                    <span
                                                        class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                                </li>
                                            </ul>

                                            <!-- Hiển thị giá sản phẩm -->
                                            <div class="price-container">
                                                @if($product->price_sale && $product->price_sale != $product->price)
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
                                                    <p class="text-left mb-0">{{ number_format($product->price, 0, ',', '.') }} VND</p>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                @endforeach

            </div>


        </div>
    </section>
    <!-- End Article -->


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
                            <a class="text-light text-decoration-none" target="_blank"
                                href="https://www.instagram.com/"><i class="fab fa-instagram fa-lg fa-fw"></i></a>
                        </li>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="https://twitter.com/"><i
                                    class="fab fa-twitter fa-lg fa-fw"></i></a>
                        </li>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank"
                                href="https://www.linkedin.com/"><i class="fab fa-linkedin fa-lg fa-fw"></i></a>
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
                            | Designed by <a rel="sponsored" href="https://templatemo.com"
                                target="_blank">TemplateMo</a>
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

    <script src="{{ asset('resources/views/user/assets/js/templatemo.js')}}"></script>
    <script src="{{ asset('resources/views/user/assets/js/custom.js')}}"></script>
    <!-- End Script -->

    <!-- Start Slider Script -->
    <script src="{{ asset('resources/views/user/assets/js/slick.min.js')}}"></script>
    <script>
        $('#carousel-related-product').slick({
            infinite: true,
            arrows: false,
            slidesToShow: 4,
            slidesToScroll: 3,
            dots: true,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 3
                }
            }
            ]
        });
    </script>
    <!-- End Slider Script -->

</body>
<style>
    .price-container {
        min-height: 100px;
        /* Tùy chỉnh chiều cao theo nhu cầu */
    }
</style>

</html>