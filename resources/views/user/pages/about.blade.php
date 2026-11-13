@extends('layouts.user')

@section('title', 'Thông tin cửa hàng')

@push('styles')
<style>
/* Banner đầu trang */
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

/* Giới thiệu */
.about-points {
    margin: 1.2rem 0 0;
    padding: 0;
    list-style: none;
}

.about-points li {
    display: flex;
    align-items: flex-start;
    gap: .6rem;
    margin-bottom: .55rem;
    color: #334155;
    font-size: .93rem;
    font-weight: 600;
}

.about-points i {
    margin-top: .15rem;
    color: var(--toy-primary);
}

.about-intro img {
    width: 100%;
    height: 100%;
    min-height: 280px;
    object-fit: cover;
    border-radius: 1.4rem;
    background: #e0f2fe;
}

.about-intro h2 {
    font-size: 1.6rem;
    font-weight: 900;
    letter-spacing: -.03em;
}

.about-intro p {
    color: #475569;
    line-height: 1.8;
}

/* Số liệu */
.stat-box {
    padding: 1.4rem 1rem;
    border: 1px solid #e8eef5;
    border-radius: 1.2rem;
    background: #fff;
    text-align: center;
    box-shadow: 0 5px 16px rgba(15, 23, 42, .045);
}

.stat-box .stat-number {
    color: var(--toy-primary-dark);
    font-size: 2rem;
    font-weight: 900;
    letter-spacing: -.04em;
}

.stat-box .stat-label {
    color: #64748b;
    font-size: .85rem;
    font-weight: 700;
}

/* Giá trị cốt lõi */
.value-card {
    height: 100%;
    padding: 1.6rem 1.3rem;
    border: 1px solid #e8eef5;
    border-radius: 1.2rem;
    background: #fff;
    text-align: center;
    box-shadow: 0 5px 16px rgba(15, 23, 42, .045);
    transition: transform .2s ease, box-shadow .2s ease;
}

.value-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 13px 26px rgba(14, 165, 233, .12);
}

.value-card h5 {
    margin-top: 1rem;
    font-size: 1.05rem;
    font-weight: 850;
}

.value-card p {
    margin: 0;
    color: #64748b;
    font-size: .88rem;
    line-height: 1.7;
}

/* Lời kêu gọi */
.about-cta {
    position: relative;
    overflow: hidden;
    padding: 4rem 1.5rem;
    border-radius: 1.4rem;
    text-align: center;
    color: #fff;
    background-size: cover;
    background-position: center;
    box-shadow: 0 14px 34px rgba(15, 23, 42, .15);
}

.about-cta {
    background-image: var(--bg-img);
}

/* Lớp phủ tối để chữ dễ đọc */
.about-cta::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, rgba(3, 105, 161, .8), rgba(15, 23, 42, .55));
}

.about-cta-content {
    position: relative;
    z-index: 1;
}

.about-cta h4 {
    font-size: clamp(1.4rem, 3vw, 1.9rem);
    text-shadow: 0 2px 10px rgba(0, 0, 0, .3);
}

.about-cta p {
    color: #e0f2fe;
    font-weight: 600;
}

.about-photo {
    position: relative;
    aspect-ratio: 3 / 3;
    /* khung ngang 4:3 */
    overflow: hidden;
    border-radius: 1.4rem;
    box-shadow: 0 14px 34px rgba(15, 23, 42, .15);
}

.about-photo img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    /* tự cắt vừa khung */
    object-position: center 60%;
    /* ưu tiên giữ phần giữa-dưới của ảnh */
}

/* Lớp phủ tối dần ở đáy để chữ dễ đọc */
.about-photo::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(15, 23, 42, .7) 0%, rgba(15, 23, 42, 0) 55%);
    pointer-events: none;
}

.about-photo-caption {
    position: absolute;
    z-index: 1;
    left: 1.4rem;
    bottom: 1.2rem;
    display: flex;
    flex-direction: column;
    color: #fff;
    line-height: 1.1;
}

.about-photo-caption span {
    font-size: 1.7rem;
    font-weight: 900;
    letter-spacing: -.03em;
    text-shadow: 0 2px 10px rgba(0, 0, 0, .35);
}

.about-photo-caption b {
    color: #ffa94d;
}

.about-photo-caption small {
    margin-top: .35rem;
    font-size: .7rem;
    font-weight: 800;
    letter-spacing: .18em;
    text-transform: uppercase;
    opacity: .9;
}
</style>
@endpush

@section('content')

{{-- Banner --}}
<div class="page-hero mb-5">
    <h1>Về Toy Shop KNG</h1>
    <p>Nơi mỗi món đồ chơi là một người bạn nhỏ, đồng hành cùng bé khám phá và lớn khôn.</p>
</div>

{{-- Giới thiệu --}}
<div class="row g-4 align-items-center about-intro mb-5">
    <div class="col-lg-5">
        <div class="about-photo">
            <img src="{{ asset('images/img-page/nen-about2.jpg') }}" alt="Cửa hàng Toy Shop KNG">
            <div class="about-photo-caption">
                <span>Toy Shop <b>KNG</b></span>
                <small>Kids &amp; Toys</small>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <h2>Câu chuyện của chúng tôi</h2>
        <p>
            Toy Shop KNG được thành lập với mong muốn mang đến cho các bé những món đồ chơi
            an toàn, sáng tạo và giàu giá trị giáo dục. Chúng tôi tin rằng chơi không chỉ là giải trí,
            mà còn là cách để trẻ học hỏi, rèn luyện tư duy và phát triển kỹ năng mỗi ngày.
        </p>
        <p>
            Từ bộ xếp hình, xe mô hình, búp bê, thú bông cho đến đồ chơi giáo dục và vận động,
            mỗi sản phẩm đều được chọn lọc kỹ càng về chất liệu, độ bền và độ an toàn
            trước khi đến tay các bé.
        </p>
        <p>
            Với bảng màu tươi sáng, hình dáng đáng yêu và chất liệu thân thiện với làn da non nớt,
            đồ chơi tại cửa hàng không chỉ khiến bé thích thú mà còn giúp ba mẹ hoàn toàn yên tâm
            khi đồng hành cùng con trong từng giờ chơi.
        </p>

        <ul class="about-points">
            <li><i class="bi bi-check-circle-fill"></i> Chất liệu nhựa và gỗ an toàn, không chứa chất độc hại</li>
            <li><i class="bi bi-check-circle-fill"></i> Thiết kế bo tròn, không cạnh sắc, phù hợp từng độ tuổi</li>
            <li><i class="bi bi-check-circle-fill"></i> Đa dạng chủ đề: xếp hình, xe mô hình, búp bê, đồ chơi giáo dục
            </li>
            <li><i class="bi bi-check-circle-fill"></i> Tư vấn tận tâm, đổi trả dễ dàng nếu sản phẩm lỗi</li>
        </ul>
    </div>
</div>

{{-- Số liệu --}}
<div class="row g-3 mb-5">
    <div class="col-6 col-lg-3">
        <div class="stat-box">
            <div class="stat-number">5+</div>
            <div class="stat-label">Danh mục đồ chơi</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-box">
            <div class="stat-number">500+</div>
            <div class="stat-label">Sản phẩm đa dạng</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-box">
            <div class="stat-number">10.000+</div>
            <div class="stat-label">Khách hàng tin tưởng</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-box">
            <div class="stat-number">100%</div>
            <div class="stat-label">Cam kết chính hãng</div>
        </div>
    </div>
</div>

{{-- Giá trị cốt lõi --}}
<div class="section-heading">
    <div>
        <h2>Vì sao chọn chúng tôi</h2>
        <p>Những giá trị Toy Shop KNG luôn theo đuổi</p>
    </div>
</div>

<div class="row g-3 mb-5">
    <div class="col-sm-6 col-lg-3">
        <div class="value-card">
            <div class="category-icon icon-0"><i class="bi bi-shield-check"></i></div>
            <h5>An toàn cho bé</h5>
            <p>Chất liệu lành tính, không độc hại, đạt tiêu chuẩn an toàn cho trẻ em.</p>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="value-card">
            <div class="category-icon icon-1"><i class="bi bi-lightbulb"></i></div>
            <h5>Khơi nguồn sáng tạo</h5>
            <p>Đồ chơi giúp bé phát triển tư duy, trí tưởng tượng và kỹ năng vận động.</p>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="value-card">
            <div class="category-icon icon-3"><i class="bi bi-award"></i></div>
            <h5>Chất lượng đảm bảo</h5>
            <p>Sản phẩm được chọn lọc kỹ, độ bền cao, nguồn gốc rõ ràng.</p>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="value-card">
            <div class="category-icon icon-2"><i class="bi bi-headset"></i></div>
            <h5>Hỗ trợ tận tâm</h5>
            <p>Đội ngũ tư vấn nhiệt tình, giúp bạn chọn món quà phù hợp cho bé.</p>
        </div>
    </div>
</div>

{{-- Lời kêu gọi --}}
{{-- cảnh báo không phải lỗi nha thầy --}}

<div class="about-cta" style="--bg-img: url('{{ asset('images/img-page/baner-3.avif') }}');">
    <div class="about-cta-content">
        <h4 class="fw-bold mb-2">Sẵn sàng chọn món quà cho bé?</h4>
        <p class="mb-3">Khám phá hàng trăm món đồ chơi vui nhộn và bổ ích.</p>
        <a href="{{ route('products.index') }}" class="btn btn-toy px-4 py-2">Xem tất cả sản phẩm</a>
        <a href="{{ route('contact') }}" class="btn btn-light px-4 py-2 ms-1">Liên hệ với chúng tôi</a>
    </div>
</div>

@endsection