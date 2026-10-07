/**
 * Application JavaScript: jQuery & AJAX Handlers
 * Tích hợp AJAX Shopping Cart, Live Search, Filter và SweetAlert2
 */

$(document).ready(function() {
    // 1. AJAX Thêm vào giỏ hàng
    $(document).on('click', '.btn-add-cart-ajax', function(e) {
        e.preventDefault();
        const $btn = $(this);
        const productId = $btn.data('id');
        const quantity = parseInt($('#productQty').val()) || 1;
        const originalHtml = $btn.html();

        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Đang thêm...');

        $.ajax({
            url: 'index.php?r=cart/add',
            type: 'POST',
            dataType: 'json',
            data: {
                id: productId,
                quantity: quantity
            },
            success: function(res) {
                $btn.prop('disabled', false).html(originalHtml);
                if (res.success) {
                    $('#cartBadge').text(res.cartCount).removeClass('d-none');
                    Swal.fire({
                        icon: 'success',
                        title: 'Đã thêm vào giỏ!',
                        text: res.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true
                    });
                } else {
                    Swal.fire('Lỗi', res.message || 'Không thể thêm sản phẩm', 'error');
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html(originalHtml);
                Swal.fire('Lỗi', 'Không thể kết nối máy chủ.', 'error');
            }
        });
    });

    // 2. AJAX Cập nhật số lượng trong giỏ hàng
    $(document).on('change', '.cart-qty-input', function() {
        const $input = $(this);
        const productId = $input.data('id');
        const newQty = parseInt($input.val()) || 1;

        $.ajax({
            url: 'index.php?r=cart/update',
            type: 'POST',
            dataType: 'json',
            data: {
                id: productId,
                quantity: newQty
            },
            success: function(res) {
                if (res.success) {
                    $('#cartBadge').text(res.cartCount);
                    if (res.cartCount === 0) {
                        location.reload();
                    } else {
                        $input.closest('tr').find('.item-subtotal').text(res.itemSubtotal);
                        $('#cartTotalAmount').text(res.totalAmount);
                    }
                }
            }
        });
    });

    // 3. AJAX Live Search Dropdown
    let searchTimeout = null;
    const $searchInput = $('#headerSearchInput');
    const $searchDropdown = $('#searchDropdown');

    $searchInput.on('input', function() {
        const query = $(this).val().trim();
        clearTimeout(searchTimeout);

        if (query.length < 2) {
            $searchDropdown.hide().empty();
            return;
        }

        searchTimeout = setTimeout(function() {
            $.ajax({
                url: 'index.php?r=product/ajaxSearch',
                type: 'GET',
                dataType: 'json',
                data: { q: query },
                success: function(data) {
                    if (data && data.length > 0) {
                        let html = '';
                        data.forEach(function(item) {
                            const formattedPrice = new Intl.NumberFormat('vi-VN').format(item.price) + ' đ';
                            const imgSrc = 'uploads/' + item.image;
                            html += `
                                <a href="index.php?r=product/detail&id=${item.id}" class="search-item">
                                    <img src="${imgSrc}" onerror="this.src='assets/images/dell_vostro.jpg'" alt="${item.name}">
                                    <div class="flex-grow-1">
                                        <div class="fw-bold small text-truncate" style="max-width: 320px;">${item.name}</div>
                                        <div class="d-flex justify-content-between align-items-center mt-1">
                                            <span class="badge bg-light text-primary border">${item.brand}</span>
                                            <span class="text-danger fw-bold small">${formattedPrice}</span>
                                        </div>
                                    </div>
                                </a>
                            `;
                        });
                        $searchDropdown.html(html).show();
                    } else {
                        $searchDropdown.html('<div class="p-3 text-muted small text-center">Không tìm thấy sản phẩm phù hợp</div>').show();
                    }
                }
            });
        }, 250);
    });

    // Ẩn dropdown khi click bên ngoài
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.search-wrapper').length) {
            $searchDropdown.hide();
        }
    });

    // 4. Xác nhận xóa bảo mật (SweetAlert2 Confirm)
    $(document).on('click', '.btn-delete-confirm', function(e) {
        e.preventDefault();
        const $form = $(this).closest('form');
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa?',
            text: 'Thao tác này không thể hoàn tác!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Đồng ý xóa',
            cancelButtonText: 'Hủy bỏ'
        }).then((result) => {
            if (result.isConfirmed) {
                $form.submit();
            }
        });
    });
});
