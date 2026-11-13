@extends('layouts.user')

@section('title', 'Liên hệ')

@push('styles')
<style>
/* Banner đầu trang (cùng kiểu trang Thông tin cửa hàng) */
.page-hero {
    padding: 2.8rem 2rem;
    border-radius: 1.6rem;
    background: linear-gradient(120deg, #0369a1, #38bdf8);
    color: #fff;
    text-align: center;
    box-shadow: 0 14px 34px rgba(14, 165, 233, .22);
}

.page-hero h1 {
    margin: 0 0 .6rem;
    font-size: clamp(1.7rem, 3.5vw, 2.5rem);
    font-weight: 900;
    letter-spacing: -.04em;
}

.page-hero p {
    max-width: 620px;
    margin: 0 auto;
    color: #e0f2fe;
    font-weight: 600;
}

/* Thẻ thông tin liên hệ */
.contact-card {
    height: 100%;
    padding: 1.5rem 1.2rem;
    border: 1px solid #e8eef5;
    border-radius: 1.2rem;
    background: #fff;
    text-align: center;
    box-shadow: 0 5px 16px rgba(15, 23, 42, .045);
    transition: transform .2s ease, box-shadow .2s ease;
}

.contact-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 13px 26px rgba(14, 165, 233, .12);
}

.contact-card h5 {
    margin: 1rem 0 .4rem;
    font-size: 1rem;
    font-weight: 850;
}

.contact-card p {
    margin: 0;
    color: #64748b;
    font-size: .9rem;
    line-height: 1.6;
}

/* Form và bản đồ */
.contact-panel {
    height: 100%;
    padding: 1.8rem;
    border: 1px solid #e8eef5;
    border-radius: 1.4rem;
    background: #fff;
    box-shadow: 0 6px 20px rgba(15, 23, 42, .05);
}

.contact-panel h4 {
    font-size: 1.3rem;
    font-weight: 900;
    letter-spacing: -.03em;
}

.contact-map {
    width: 100%;
    height: 100%;
    min-height: 320px;
    border: 0;
    border-radius: 1rem;
}

/* Giờ mở cửa */
.hours-list {
    margin: 0;
    padding: 0;
    list-style: none;
}

.hours-list li {
    display: flex;
    justify-content: space-between;
    padding: .55rem 0;
    border-bottom: 1px dashed #e2e8f0;
    font-size: .9rem;
    color: #475569;
}

.hours-list li:last-child {
    border-bottom: 0;
}

.hours-list strong {
    color: #1e293b;
}
</style>
@endpush

@section('content')

{{-- Banner --}}
<div class="page-hero mb-5">
    <h1>Liên hệ với chúng tôi</h1>
    <p>Bạn cần tư vấn chọn đồ chơi cho bé? Toy Shop KNG luôn sẵn sàng hỗ trợ.</p>
</div>

{{-- 4 thẻ thông tin --}}
<div class="row g-3 mb-5">
    <div class="col-sm-6 col-lg-3">
        <div class="contact-card">
            <div class="category-icon icon-0"><i class="bi bi-geo-alt"></i></div>
            <h5>Địa chỉ</h5>
            <p>123 Chu Văn An, Bình Thạnh,<br>TP. Hồ Chí Minh</p>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="contact-card">
            <div class="category-icon icon-1"><i class="bi bi-telephone"></i></div>
            <h5>Hotline</h5>
            <p>0123 456 789<br>Hỗ trợ cả cuối tuần</p>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="contact-card">
            <div class="category-icon icon-3"><i class="bi bi-envelope"></i></div>
            <h5>Email</h5>
            <p>lekhang1510@shopkng.vn<br>Phản hồi trong 24 giờ</p>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="contact-card">
            <div class="category-icon icon-2"><i class="bi bi-facebook"></i></div>
            <h5>Mạng xã hội</h5>
            <p>facebook.com/shopkng<br>zalo: 0123 456 789</p>
        </div>
    </div>
</div>

{{-- Form + Bản đồ --}}
<div class="row g-4 mb-5">
    <div class="col-lg-6">
        <div class="contact-panel">
            <h4 class="mb-1">Gửi tin nhắn cho chúng tôi</h4>
            <p class="text-muted small mb-4">Điền thông tin bên dưới, chúng tôi sẽ liên hệ lại sớm nhất.</p>

            <form action="#" method="POST" onsubmit="return false;">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" placeholder="Nguyễn Văn A">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" placeholder="0123 456 789">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="email@example.com">
                </div>
                <div class="mb-3">
                    <label class="form-label">Chủ đề</label>
                    <select class="form-select">
                        <option>Tư vấn sản phẩm</option>
                        <option>Hỗ trợ đơn hàng</option>
                        <option>Góp ý, khiếu nại</option>
                        <option>Hợp tác kinh doanh</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nội dung</label>
                    <textarea rows="4" class="form-control" placeholder="Nhập nội dung bạn cần hỗ trợ..."></textarea>
                </div>
                <button type="submit" class="btn btn-toy px-4 py-2">
                    <i class="bi bi-send"></i> Gửi tin nhắn
                </button>
            </form>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="contact-panel d-flex flex-column">
            <h4 class="mb-3">Tìm đường đến cửa hàng</h4>
            <iframe class="contact-map flex-grow-1 mb-4"
                src="https://www.google.com/maps?q=Nguy%E1%BB%85n+Hu%E1%BB%87,+Qu%E1%BA%ADn+1,+H%E1%BB%93+Ch%C3%AD+Minh&output=embed"
                loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"
                title="Bản đồ cửa hàng"></iframe>

            <h6 class="fw-bold mb-2">Giờ mở cửa</h6>
            <ul class="hours-list">
                <li><span>Thứ 2 - Thứ 6</span><strong>8:00 - 21:00</strong></li>
                <li><span>Thứ 7 - Chủ nhật</span><strong>8:00 - 22:00</strong></li>
            </ul>
        </div>
    </div>
</div>

@endsection