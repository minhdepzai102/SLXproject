<!-- Modal Search -->
<div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="w-100 pt-1 mb-5 text-right">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="get" class="modal-content modal-body border-0 p-0">
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                <button type="submit" class="input-group-text bg-success text-light">
                    <i class="fa fa-fw fa-search text-white"></i>
                </button>
            </div>
        </form>
        <!-- Kết quả tìm kiếm sẽ được hiển thị ở đây -->
       
    </div>
     <div id="search-results" class="mt-3">
            <!-- Kết quả tìm kiếm sẽ được thêm vào đây -->
        </div>
</div>

<!-- CSS for Product Cards and Modal -->
<style>
  /* CSS cho phần tử sản phẩm */
.product-result {
    width: 758px; /* Giới hạn chiều rộng */
    margin: 0 482px 15px auto; /* Căn giữa phần tử */
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 5px;
    background-color: #fff;
    transition: transform 0.3s ease;
    cursor: pointer;
    display: flex;
    justify-content: center; /* Đảm bảo nội dung của phần tử nằm giữa */
}


    .product-card {
        display: flex;
        align-items: center;
        width: 100%;
        padding: 10px;
    }

    .product-card img {
        max-width: 120px;
        margin-right: 15px;
    }

    .product-card p {
        margin: 0;
    }

    .product-card .price {
        font-weight: bold;
    }

    .product-card:hover {
        transform: scale(1.01);
    }

    .product-card .price span {
        text-decoration: none;
    }

    .product-card .price span.line-through {
        text-decoration: line-through;
    }
</style>

<!-- JavaScript for Product Search -->
<script>
    const assetUrl = "{{ route('api.products.search') }}";
    const productRoute = "{{ route('product.single', ['id' => '__ID__']) }}"; // Đặt placeholder cho product ID

    // Lắng nghe sự kiện nhập liệu vào ô tìm kiếm
    document.getElementById('inputModalSearch').addEventListener('input', function () {
        let query = this.value;

        // Nếu không có từ khóa tìm kiếm, xóa kết quả hiển thị
        if (query.length === 0) {
            document.getElementById('search-results').innerHTML = '';
            return;
        }

        // Gửi yêu cầu AJAX để tìm kiếm sản phẩm
        fetch(`${assetUrl}?q=${query}`)
            .then(response => response.json())
            .then(data => {
                let resultsContainer = document.getElementById('search-results');
                resultsContainer.innerHTML = ''; // Xóa kết quả cũ

                // Nếu có sản phẩm tìm thấy
                if (data.length > 0) {
                    data.forEach(product => {
                        let productDiv = document.createElement('div');
                        productDiv.classList.add('product-result');
                        let productUrl = productRoute.replace('__ID__', product.id);

                        // Cấu trúc HTML cho product-card
                        productDiv.innerHTML = `
                            <div class="product-card">
                                <img src="${product.product_image}" alt="${product.name}" class="img-fluid">
                                <div>
                                    <p><strong>${product.name}</strong></p>
                                    <p class="price">
                                        <span class="${product.price_sale ? 'line-through' : ''}">${product.price} VND</span>
                                        ${product.price_sale ? `<span style="color: red;">${product.price_sale} VND</span>` : ''}
                                    </p>
                                </div>
                            </div>
                        `;

                        // Gán sự kiện `click` để điều hướng tới sản phẩm
                        let productCard = productDiv.querySelector('.product-card');
                        productCard.style.cursor = 'pointer'; // Đảm bảo con trỏ thay đổi khi hover
                        productCard.addEventListener('click', () => {
                            window.location.assign(productUrl);
                        });

                        resultsContainer.appendChild(productDiv);
                    });
                } else {
                    resultsContainer.innerHTML = '<p>No products found</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>
