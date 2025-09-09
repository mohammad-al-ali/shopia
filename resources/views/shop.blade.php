@extends('layouts.app')
@section('content')
<style>
    .brand-list li, .category-list li {
        line-height: 40px;
    }
    body{

    }
    .brand-list li .chk-brand, .category-list li .chk-category{
        width: 1rem;
        height: 1rem;
        color: #e4e4e4;
        border: 0.125rem solid currentColor;
        border-radius: 0;
        margin-right: 0.75rem;
    }


    .shop-sidebar {
        background-color: var(--card-bg) !important;
        color: var(--text-primary) !important;
    }

    [data-theme="dark"] .shop-sidebar {
        background-color: var(--bg-primary) !important;
    }

    [data-theme="dark"] .accordion-item {
        background-color: var(--bg-primary) !important;
    }

    [data-theme="dark"] .accordion-button {
        background-color: var(--bg-primary) !important;
    }

    [data-theme="dark"] .accordion-body {
        background-color: var(--bg-primary) !important;
    }

    [data-theme="dark"] .product-card {
        background-color: var(--bg-primary) !important;
    }

    [data-theme="dark"] .slide-split_text {
        background-color: var(--bg-primary) !important;
    }

    [data-theme="dark"] .slideshow-bg {
        background-color: var(--bg-primary) !important;
    }

    [data-theme="dark"] .slide-split {
        background-color: var(--bg-primary) !important;
    }

    [data-theme="dark"] .swiper-slide {
        background-color: var(--bg-primary) !important;
    }

    [data-theme="dark"] .slideshow-text {
        background-color: var(--bg-primary) !important;
    }

    [data-theme="dark"] .aside-header {
        background-color: var(--bg-primary) !important;
    }

    [data-theme="dark"] .list-item {
        background-color: transparent !important;
    }

    [data-theme="dark"] .menu-link {
        background-color: transparent !important;
    }

    .accordion-item {
        background-color: var(--card-bg) !important;
        border-color: var(--border-color) !important;
    }

    .accordion-button {
        background-color: var(--card-bg) !important;
        color: var(--text-primary) !important;
    }

    .accordion-body {
        background-color: var(--card-bg) !important;
        color: var(--text-primary) !important;
    }

    .list-item {
        color: var(--text-primary) !important;
    }

    .menu-link {
        color: var(--text-primary) !important;
    }

    .menu-link:hover {
        color: var(--text-secondary) !important;
    }

    .shop-acs__select {
        background-color: var(--bg-primary) !important;
        color: var(--text-primary) !important;
        border-color: var(--border-color) !important;
    }

    .shop-acs__select:focus {
        background-color: var(--bg-primary) !important;
        color: var(--text-primary) !important;
        border-color: var(--text-secondary) !important;
    }

    .btn-link {
        color: var(--text-primary) !important;
    }

    .btn-link:hover {
        color: var(--text-secondary) !important;
    }

    .product-card {
        background-color: var(--card-bg) !important;
        color: var(--text-primary) !important;
    }

    .pc__title a {
        color: var(--text-primary) !important;
    }

    .pc__title a:hover {
        color: var(--text-secondary) !important;
    }

    .pc__category {
        color: var(--text-secondary) !important;
    }

    .money {
        color: var(--text-primary) !important;
    }

    .price-old {
        color: var(--text-muted) !important;
    }

    .reviews-note {
        color: var(--text-secondary) !important;
    }

    .breadcrumb a {
        color: var(--text-primary) !important;
    }

    .breadcrumb a:hover {
        color: var(--text-secondary) !important;
    }

    .breadcrumb-separator {
        color: var(--text-secondary) !important;
    }

    .slide-split_text {
        background-color: var(--bg-secondary) !important;
    }

    .slideshow-text h1,
    .slideshow-text h2,
    .slideshow-text p {
        color: var(--text-primary) !important;
    }

    .price-range-slider {
        background-color: var(--bg-primary) !important;
    }

    .price-range__info span {
        color: var(--text-primary) !important;
    }

    .price-range__min,
    .price-range__max {
        color: var(--text-primary) !important;
    }

    /* Improved price filter for dark mode */
    .price-range-slider {
        background: var(--border-color) !important;
        border: none !important;
        border-radius: 10px !important;
        height: 8px !important;
        margin: 20px 0 !important;
        outline: none !important;
        -webkit-appearance: none !important;
    }

    .price-range-slider::-webkit-slider-thumb {
        background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%) !important;
        border: 2px solid #007bff !important;
        border-radius: 50% !important;
        width: 22px !important;
        height: 22px !important;
        cursor: pointer !important;
        box-shadow: 0 3px 8px rgba(0,123,255,0.4), 0 0 0 3px rgba(0,123,255,0.1) !important;
        -webkit-appearance: none !important;
        transition: all 0.3s ease !important;
    }

    .price-range-slider::-webkit-slider-thumb:hover {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
        border-color: #ffffff !important;
        transform: scale(1.15) !important;
        box-shadow: 0 4px 12px rgba(0,123,255,0.6), 0 0 0 4px rgba(0,123,255,0.2) !important;
    }

    .price-range-slider::-webkit-slider-thumb:active {
        background: linear-gradient(135deg, #0056b3 0%, #004085 100%) !important;
        transform: scale(1.1) !important;
        box-shadow: 0 2px 6px rgba(0,123,255,0.8), 0 0 0 2px rgba(0,123,255,0.3) !important;
    }

    .price-range-slider::-moz-range-thumb {
        background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%) !important;
        border: 2px solid #007bff !important;
        border-radius: 50% !important;
        width: 22px !important;
        height: 22px !important;
        cursor: pointer !important;
        box-shadow: 0 3px 8px rgba(0,123,255,0.4), 0 0 0 3px rgba(0,123,255,0.1) !important;
        -moz-appearance: none !important;
        transition: all 0.3s ease !important;
    }

    .price-range-slider::-moz-range-thumb:hover {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
        border-color: #ffffff !important;
        transform: scale(1.15) !important;
        box-shadow: 0 4px 12px rgba(0,123,255,0.6), 0 0 0 4px rgba(0,123,255,0.2) !important;
    }

    .price-range-slider::-moz-range-thumb:active {
        background: linear-gradient(135deg, #0056b3 0%, #004085 100%) !important;
        transform: scale(1.1) !important;
        box-shadow: 0 2px 6px rgba(0,123,255,0.8), 0 0 0 2px rgba(0,123,255,0.3) !important;
    }

    .price-range-slider::-webkit-slider-track {
        background: linear-gradient(90deg, #404040 0%, #606060 50%, #404040 100%) !important;
        border-radius: 10px !important;
        height: 8px !important;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.3) !important;
    }

    .price-range-slider::-moz-range-track {
        background: linear-gradient(90deg, #404040 0%, #606060 50%, #404040 100%) !important;
        border-radius: 10px !important;
        height: 8px !important;
        border: none !important;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.3) !important;
    }

    /* Price range info styling */
    .price-range__info {
        background: var(--bg-primary) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 8px !important;
        padding: 10px 15px !important;
        margin-top: 15px !important;
    }

    .price-range__min,
    .price-range__max {
        color: var(--text-primary) !important;
        font-weight: bold !important;
        font-size: 14px !important;
    }

    /* Clean sidebar without separators */
    .shop-sidebar {
        position: relative;
        border: none;
        box-shadow: none;
    }

    .shop-list {
        position: relative;
        border: none;
        box-shadow: none;
    }

    /* Enhanced accordion styling */
    .accordion-button {
        background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 8px !important;
        margin-bottom: 10px !important;
        transition: all 0.3s ease !important;
    }

    .accordion-button:hover {
        background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-primary) 100%) !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2) !important;
    }

    .accordion-button:not(.collapsed) {
        background: linear-gradient(135deg, var(--text-secondary) 0%, var(--bg-primary) 100%) !important;
        color: var(--text-primary) !important;
    }

    .accordion-item {
        border: 1px solid var(--border-color) !important;
        border-radius: 8px !important;
        margin-bottom: 15px !important;
        overflow: hidden !important;
    }
</style>
    <main class="pt-90">
        <section class="shop-main container d-flex pt-4 pt-xl-5">
            <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
                <div class="aside-header d-flex d-lg-none align-items-center">
                    <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
                    <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
                </div>

                <div class="pt-4 pt-lg-0"></div>

                <div class="accordion" id="categories-list">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-1">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accordion-filter-1" aria-expanded="true" aria-controls="accordion-filter-1">
                                Product Categories
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
                             aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
                            <div class="accordion-body px-0 pb-0 pt-3 category-list">
                                <ul class="list list-inline mb-0">
                                    @foreach($categories as $category)
                                    <li class="list-item">
                                     <span class="menu-link py-1">
                                                <input type="checkbox" class="chk-category" name="categories" value="{{$category->id}}"
                                                       @if(in_array($category->id,explode(',',$f_categories))) checked="checked" @endif/>
                                                {{$category->name}}
                                            </span>
                                        <span class="text-right float-end">
                                                {{$category->products->count()}}
                                            </span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion" id="brand-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-brand">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accordion-filter-brand" aria-expanded="true" aria-controls="accordion-filter-brand">
                                Brands
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0" aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
                            <div class="search-field multi-select accordion-body px-0 pb-0">
                                <u1 class="list list-inline mb-0 brand-list">
                                @foreach ($brands as $brand)
                                    <li class="list-item">
                                            <span class="menu-link py-1">
                                                <input type="checkbox" name="brands" value="{{$brand->id}}" class="chk-brand"
                                                @if(in_array($brand->id,explode(',',$f_brands))) checked="checked" @endif/>
                                                {{$brand->name}}
                                            </span>
                                                                                <span class="text-right float-end">
                                                {{$brand->products->count()}}
                                            </span>
                                    </li>
                                @endforeach
                                </u1>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="accordion" id="price-filters">
                    <div class="accordion-item mb-4 pb-3">
                        <h5 class="accordion-header" id="accordion-heading-price">
                            <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accordion-filter-price" aria-expanded="true" aria-controls="accordion-filter-price">
                                Price Range
                                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                        <path
                                            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                    </g>
                                </svg>
                            </button>
                        </h5>
                        <div id="accordion-filter-price" class="accordion-collapse collapse show border-0"
                             aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
                            <div class="accordion-body px-0 pb-0 pt-3">
                                <input class="price-range-slider" type="text" name="price_range" value="" data-slider-min="1"
                                    data-slider-max="2100" data-slider-step="5" data-slider-value="[1,2100]" data-currency="$" />
                                <div class="price-range__info d-flex align-items-center mt-3">
                                    <div class="me-auto">
                                        <span class="text-secondary">Min Price: </span>
                                        <span class="price-range__min fw-bold">$1</span>
                                    </div>
                                    <div>
                                        <span class="text-secondary">Max Price: </span>
                                        <span class="price-range__max fw-bold">$2100</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>



            <div class="shop-list flex-grow-1">
                <div class="swiper-container js-swiper-slider slideshow slideshow_small slideshow_split" data-settings='{
            "autoplay": {
              "delay": 5000
            },
            "slidesPerView": 1,
            "effect": "fade",
            "loop": true,
            "pagination": {
              "el": ".slideshow-pagination",
              "type": "bullets",
              "clickable": true
            }
          }'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                     style="background-color:#f5e6e0;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h1> BUY easily</h1 >
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">You can pay with your credit card
                                            ,your paybal or even cash  .</h6>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color: #f5e6e0;">
                                        <img loading="lazy" src="assets/images/shop/shop_banner3.jpg" width="430" height="550"
                                             alt="Women's accessories" class="slideshow-bg__img object-fit-cover" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                     style="background-color: #f5e6e0;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h2
                                            class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                             <br /><strong>Visit us</strong></h2>
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">visit us in our markets
                                            in Damascus,Aleppo and Homs.</h6>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color:#f5e6e0;">
                                        <img loading="lazy" src="assets/images/shop/shop_banner3.jpg" width="730" height="450"
                                             alt="Women's accessories" class="slideshow-bg__img object-fit-cover" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                                <div class="slide-split_text position-relative d-flex align-items-center"
                                     style="background-color:#f5e6e0;">
                                    <div class="slideshow-text container p-3 p-xl-5">
                                        <h2
                                            class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                                             <br /><strong>%10 OFF</strong></h2>
                                        <p class="mb-0 animate animate_fade animate_btt animate_delay-5">See our latest offer and make your
                                            bid now.</h6>
                                    </div>
                                </div>
                                <div class="slide-split_media position-relative">
                                    <div class="slideshow-bg" style="background-color: #f5e6e0;">
                                        <img loading="lazy" src="assets/images/shop/shop_banner3.jpg" width="730" height="450"
                                             alt="Women's accessories" class="slideshow-bg__img object-fit-cover" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container p-3 p-xl-5">
                        <div class="slideshow-pagination d-flex align-items-center position-absolute bottom-0 mb-4 pb-xl-2"></div>

                    </div>
                </div>

                <div class="mb-3 pb-2 pb-xl-3"></div>

                <div class="d-flex justify-content-between mb-4 pb-md-2">
                    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                        <a href="{{route('home.index')}}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
                    </div>

                    <div class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1" >
                        <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0" aria-label="Sort Items" name="orderby" id="orderby">
                            <option value="1" {{$order ==-1 ? 'selected' : ''}}>Default </option>
                            <option value="1" {{$order ==1 ? 'selected' : ''}}>Date ,New To Old</option>
                            <option value="2" {{$order ==2 ? 'selected' : ''}}>Date ,Old To New</option>
                            <option value="3" {{$order ==3 ? 'selected' : ''}}>Price ,Low To High</option>
                            <option value="4" {{$order ==4 ? 'selected' : ''}}>Price ,High To Low</option>

                        </select>

                        <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0" aria-label="Page Size" id="pagesize" name="pagesize" style="margin-right: 20px;">
                            <option value="12" {{$size == 12 ? 'selected':''}}>Show</option>
                            <option value="24"  {{$size == 24 ? 'selected':''}}>24</option>
                            <option value="48" {{$size == 48 ? 'selected':''}}>48</option>
                            <option value="102" {{$size == 102 ? 'selected':''}}>102</option>
                        </select>

                        <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div>

                        <div class="col-size align-items-center order-1 d-none d-lg-flex">
                            <span class="text-uppercase fw-medium me-2">View</span>
                            <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid" data-cols="2">2</button>
                            <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid" data-cols="3">3</button>
                            <button class="btn-link fw-medium js-cols-size" data-target="products-grid" data-cols="4">4</button>
                        </div>

                        <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
                            <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside" data-aside="shopFilter">
                                <svg class="d-inline-block align-middle me-2" width="14" height="10" viewBox="0 0 14 10" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_filter" />
                                </svg>
                                <span class="text-uppercase fw-medium d-inline-block align-middle">Filter</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
                    @foreach($products as $product)
                    <div class="product-card-wrapper">
                        <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                            <div class="pc__img-wrapper">
                                <div class="swiper-container background-img js-swiper-slider" data-settings='{"resizeObserver": true}'>
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <a href="{{route('product.details',['slug'=>$product->slug])}}"><img loading="lazy" src="{{asset('storage/products_image/' . $product->image)}}" width="530" height="500" alt="{{$product->name}}"></a>
                                        </div>
                                     @foreach(explode(',',$product->images) as $img)
                                            <div class="swiper-slide">
                                                <a href="{{route('product.details',['slug'=>$product->slug])}}"><img loading="lazy" src="{{asset('storage/products_image/gallery/' . $img)}}"  alt="{{$product->name}}" width="530" height="400" class="pc__img"></a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <span class="pc__img-prev"><svg width="9" height="11" viewBox="1 0 7 11"
                                                                    xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_prev_sm" />
                    </svg>
                                    </span>
                                    <span class="pc__img-next"><svg width="7" height="11" viewBox="0 0 7 11"
                                                                    xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_next_sm" />
                    </svg></span>
                                </div>
                                @if(Cart::instance('cart')->content()->where('id',$product->id)->count()>0)
                                    <a href="{{route('cart.index')}}" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium btn-warning mb-3">Go To Cart</a>
                                @else
<form name="addtocart-form" method="post" action="{{route('cart.add')}}">
        @csrf
        <input type="hidden" name="id" value='{{$product->id}}' />
        <input type="hidden" name="quantity" value='1' />
        <input type="hidden" name="name" value='{{$product->name}}' />
        <input type="hidden" name="price" value='{{$product->sale_price == '' ? $product->regular_price : $product->sale_price}}' />

        <button type="submit" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium " data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
</form> @endif
                            </div>

                            <div class="pc__info position-relative">
                                <p class="pc__category">{{$product->category->name}}</p>
                                <h6 class="pc__title"><a href="{{route('product.details',['slug'=>$product->slug])}}">{{$product->name}}</a></h6>
                                <div class="product-card__price d-flex">
                                    <span class="money price">
                                        @if($product->sale_price)
                                            <s>${{$product->regular_price}}</s>${{$product->sale_price}}
                                               @else
                                            ${{$product->regular_price}}

                                            @endif
                                    </span>
                                </div>
                                <div class="product-card__review d-flex align-items-center">
                                    <div class="reviews-group d-flex">
                                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_star" />
                                        </svg>
                                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_star" />
                                        </svg>
                                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_star" />
                                        </svg>
                                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_star" />
                                        </svg>
                                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_star" />
                                        </svg>
                                    </div>
                                    <span class="reviews-note text-lowercase text-secondary ms-1">8k+ reviews</span>
                                </div>

                                <button class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                        title="Add To Wishlist">
                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_heart" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
    </main>
<form id="frmfilter" method="GET" action="{{route('shop.index')}}">
    @csrf
    <input type="hidden" name="page" value="{{$products->currentPage()}}" />

    <input type="hidden" name="size" id="size" value="{{$size}}" />
    <input type="hidden" name="order" id="order" value="{{$order}}" />
    <input type="hidden" name="brands" id="hdnBrands" />
    <input type="hidden" name="categories" id="hdnCategories" />
    <input type="hidden" name="min" id="hdnMinPrice" value=""/>
    <input type="hidden" name="max" id="hdnMaxPrice" value=""/>
</form>
@endsection
@push('scripts')
    <script>
        $(function(){
            $("#pagesize").on("change", function(){

                $("#frmfilter").submit();
            });

            $("#orderby").on("change", function(){
                $("#order").val($("#orderby option:selected").val());
                $("#frmfilter").submit();
            });

            $(document).ready(function () {
                function updateFilters() {
                    var brands = $("input[name='brands']:checked").map(function () {
                        return $(this).val();
                    }).get().join(',');

                    var categories = $("input[name='categories']:checked").map(function () {
                        return $(this).val();
                    }).get().join(',');

                    $("#hdnBrands").val(brands);
                    $("#hdnCategories").val(categories);
                }

                $("input[name='brands'], input[name='categories']").on("change", function(){
                    updateFilters();
                    $("#frmfilter").submit();
                });

                $("[name='price_range']").on("change", function(){
                    var min = $(this).val().split(',')[0];
                    var max = $(this).val().split(',')[1];

                    $("#hdnMinPrice").val(min);
                    $("#hdnMaxPrice").val(max);

                    // تأكد من عدم إعادة ضبط القيم الأخرى عند تعديل السعر
                    updateFilters();

                    setTimeout(() => {
                        $("#frmfilter").submit();
                    }, 900);
                });
            });
        });
    </script>
@endpush
