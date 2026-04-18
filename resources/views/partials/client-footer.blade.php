<footer class="bg-dark text-light pt-4 pb-3 mt-5">
    <div class="container">
        <div class="row text-center text-md-start">
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-2">VỀ CHÚNG TÔI</h5>
                <p class="small">
                    Ra đời ngày 14/8/2004, Orchard.vn là website nước hoa đầu tiên tại Việt Nam,
                    cung cấp hơn 200 nhãn hiệu cao cấp. Định hướng trở thành nhà cung cấp nước hoa số 1 tại VN,
                    mang lại sự đa dạng, tiện lợi và hài lòng cho khách hàng.
                </p>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold mb-2">LIÊN KẾT NHANH</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('client.home') }}" class="text-light text-decoration-none">Trang chủ</a></li>
                    <li><a href="{{ route('client.products') }}" class="text-light text-decoration-none">Sản phẩm</a></li>
                    <li><a href="{{ route('client.orderslist') }}" class="text-light text-decoration-none">Đơn hàng</a></li>
                    <li><a href="{{ route('client.profile') }}" class="text-light text-decoration-none">Tài khoản</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold mb-2">NƯỚC HOA</h6>
                <ul class="list-unstyled small mb-3">
                    <li><a href="/nuoc-hoa-nam" class="text-light text-decoration-none">Nước hoa Nam</a></li>
                    <li><a href="/nuoc-hoa-nu" class="text-light text-decoration-none">Nước hoa Nữ</a></li>
                    <li><a href="/nuoc-hoa-niche" class="text-light text-decoration-none">Nước hoa Niche</a></li>
                    <li><a href="/nuoc-hoa-mini" class="text-light text-decoration-none">Nước hoa Mini</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold mb-2">KẾT NỐI CÙNG ORCHARD</h6>
                <div class="d-flex justify-content-center justify-content-md-start gap-3">
                    <a href="https://facebook.com" class="text-light fs-5"><i class="bi bi-facebook"></i></a>
                    <a href="https://instagram.com" class="text-light fs-5"><i class="bi bi-instagram"></i></a>
                    <a href="https://youtube.com" class="text-light fs-5"><i class="bi bi-youtube"></i></a>
                    <a href="https://zalo.me" class="text-light fs-5"><i class="bi bi-chat-dots"></i></a>
                </div>
            </div>
        </div>
        <div class="border-top border-secondary mt-3 pt-2 text-center">
            <p class="small mb-0">
                © {{ date('Y') }} Orchard.vn. Bản quyền nội dung thuộc về Orchard. Trích dẫn "orchard.vn" khi sử dụng thông tin từ website này.
            </p>
        </div>
    </div>
</footer>
