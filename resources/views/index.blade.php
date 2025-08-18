@extends('layouts.app')
@section('content')
<style>
.image-slider {
  width: 100%;
  border:200px;
  overflow: hidden;
  aspect-ratio: 16 / 9;
  background: #f2f2f2;
  border-radius: 8px;

}
.image-slider img {
  width: 100%;
  height: 900px;
  object-fit: cover;
   margin-top:170px;
  display: none;
  top: 0;
  left: 0;
  z-index: auto;
}
.image-slider img.active {
  display: block;
}
@media (prefers-reduced-motion: no-preference) {
  .image-slider img {
    opacity: 0;
    transition: opacity 300ms ease-in-out;
  }
  .image-slider img.active {
    opacity: 1;
  }
}
</style>
<section class="image-slider" id="my-slider">
  <img loading="lazy" src="{{asset('assets/images/home/demo3/category_1.png')}}" class="active" />
  <img  loading="lazy" src="{{asset('assets/images/home/demo3/category_2.png')}}" />
</section>
<script>
(function () {
  const slider = document.getElementById('my-slider');
  const slides = Array.from(slider.querySelectorAll('img'));
  let index = 0;

  if (slides.length < 2) return;

  setInterval(() => {
    slides[index].classList.remove('active');
    index = (index + 1) % slides.length;
    slides[index].classList.add('active');
  }, 4200);
})();
</script>
    <main>

        <style>
            .hero-swiper { height: auto; }
            .hero-slide-img {
                width: 100%;
                height: auto;
                aspect-ratio: 1920 / 1200;
                object-fit: cover;
                display: block;
            }
            @media (min-width: 1200px) {
                .hero-swiper { max-height: 1200px; }
            }
        </style>



            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section class="hot-deals container">
                <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Hot Deals</h2>
                <div class="row">
                    <div
                        class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
                        <h2>Summer Sale</h2>
                        <h2 class="fw-bold">Up to 7% Off</h2>

                        <div class="position-relative d-flex align-items-center text-center pt-xxl-4 js-countdown mb-3"
                             data-date="18-3-2024" data-time="06:50">
                            <div class="day countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Days</span>
                            </div>

                            <div class="hour countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Hours</span>
                            </div>

                            <div class="min countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Mins</span>
                            </div>

                            <div class="sec countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Sec</span>
                            </div>
                        </div>

                        <a href="#" class="btn-link default-underline text-uppercase fw-medium mt-3">View All</a>
                    </div>
                    <div class="col-md-6 col-lg-8 col-xl-80per">
                        <div class="position-relative">
                            <div class="swiper-container js-swiper-slider" data-settings='{
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": 4,
                  "slidesPerGroup": 4,
                  "effect": "none",
                  "loop": false,
                  "breakpoints": {
                    "320": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 2,
                      "spaceBetween": 14
                    },
                    "768": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 3,
                      "spaceBetween": 24
                    },
                    "992": {
                      "slidesPerView": 3,
                      "slidesPerGroup": 1,
                      "spaceBetween": 30,
                      "pagination": false
                    },
                    "1200": {
                      "slidesPerView": 4,
                      "slidesPerGroup": 1,
                      "spaceBetween": 30,
                      "pagination": false
                    }
                  }
                }'>
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide product-card product-card_style3">
                                        <div class="pc__img-wrapper">
                                            <a href="{{asset('details.html')}}">
                                                <img loading="lazy" src="{{asset('assets/images/home/demo3/product-0-1.jpg')}}" width="258" height="313"
                                                     alt="Cropped Faux leather Jacket" class="pc__img">
                                                <img loading="lazy" src="{{asset('assets/images/home/demo3/product-0-2.jpg')}}" width="258" height="313"
                                                     alt="Cropped Faux leather Jacket" class="pc__img pc__img-second">
                                            </a>
                                        </div>

                                        <div class="pc__info position-relative">
                                            <h6 class="pc__title"><a href="{{asset('details.html')}}">ASUS ROG STRIX GF850HLXX10 VR2 Gaming</a></h6>
                                            <div class="product-card__price d-flex">
                                                <span class="money price text-secondary">4400$</span>
                                            </div>

                                            <div
                                                class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                                        data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                                        data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                                    <span class="d-none d-xxl-block">Quick View</span>
                                                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                                          xmlns="http://www.w3.org/2000/svg">
                              <use href="#icon_view" />
                            </svg></span>
                                                </button>
                                                <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_heart" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide product-card product-card_style3">
                                        <div class="pc__img-wrapper">
                                            <a href="{{asset('details.html')}}">
                                                <img loading="lazy" src="{{asset('assets/images/home/demo3/product-1-1.jpg')}}" width="258" height="313"
                                                     alt="Cropped Faux leather Jacket" class="pc__img">
                                                <img loading="lazy" src="{{asset('assets/images/home/demo3/product-1-2.jpg')}}" width="258" height="313"
                                                     alt="Cropped Faux leather Jacket" class="pc__img pc__img-second">
                                            </a>
                                        </div>

                                        <div class="pc__info position-relative">
                                            <h6 class="pc__title"><a href="{{asset('details.html')}}">ASUS ROG STRIX G18</a></h6>
                                            <div class="product-card__price d-flex">
                                                <span class="money price text-secondary">3850$</span>
                                            </div>

                                            <div
                                                class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                                        data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                                        data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                                    <span class="d-none d-xxl-block">Quick View</span>
                                                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                                          xmlns="http://www.w3.org/2000/svg">
                              <use href="#icon_view" />
                            </svg></span>
                                                </button>
                                                <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_heart" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide product-card product-card_style3">
                                        <div class="pc__img-wrapper">
                                            <a href="{{asset('details.html')}}">
                                                <img loading="lazy" src="{{asset('assets/images/home/demo3/product-2-1.jpg')}}" width="258" height="313"
                                                     alt="Cropped Faux leather Jacket" class="pc__img">
                                                <img loading="lazy" src="{{asset('assets/images/home/demo3/product-2-2.jpg')}}" width="258" height="313"
                                                     alt="Cropped Faux leather Jacket" class="pc__img pc__img-second">
                                            </a>
                                        </div>

                                        <div class="pc__info position-relative">
                                            <h6 class="pc__title"><a href="{{asset('details.html')}}">LENOVO LEGION i5irix</a></h6>
                                            <div class="product-card__price d-flex">
                                                <span class="money price text-secondary">2125$</span>
                                            </div>

                                            <div
                                                class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                                        data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                                        data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                                    <span class="d-none d-xxl-block">Quick View</span>
                                                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                                          xmlns="http://www.w3.org/2000/svg">
                              <use href="#icon_view" />
                            </svg></span>
                                                </button>
                                                <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_heart" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide product-card product-card_style3">
                                        <div class="pc__img-wrapper">
                                            <a href="{{asset('details.html')}}">
                                                <img loading="lazy" src="{{asset('assets/images/home/demo3/product-3-1.jpg')}}" width="258" height="313"
                                                     alt="Cropped Faux leather Jacket" class="pc__img">
                                                <img loading="lazy" src="{{asset('assets/images/home/demo3/product-3-2.jpg')}}" width="258" height="313"
                                                     alt="Cropped Faux leather Jacket" class="pc__img pc__img-second">
                                            </a>
                                        </div>

                                        <div class="pc__info position-relative">
                                            <h6 class="pc__title"><a href="{{asset('details.html')}}">DELL GAMING G16</a></h6>
                                            <div class="product-card__price d-flex align-items-center">
                                                <span class="money price-old">1840$</span>
                                                <span class="money price text-secondary">1720$</span>
                                            </div>

                                            <div
                                                class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                                        data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                                        data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                                    <span class="d-none d-xxl-block">Quick View</span>
                                                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                                          xmlns="http://www.w3.org/2000/svg">
                              <use href="#icon_view" />
                            </svg></span>
                                                </button>
                                                <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_heart" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide product-card product-card_style3">
                                        <div class="pc__img-wrapper">
                                            <a href="">
                                                <img loading="lazy" src="{{asset('assets/images/home/demo3/product-0-1.jpg')}}" width="258" height="313"
                                                     alt="Cropped Faux leather Jacket" class="pc__img">
                                                <img loading="lazy" src="{{asset('assets/images/home/demo3/product-0-2.jpg')}}" width="258" height="313"
                                                     alt="Cropped Faux leather Jacket" class="pc__img pc__img-second">
                                            </a>
                                        </div>

                                        <div class="pc__info position-relative">
                                            <h6 class="pc__title"><a href="{{asset('details.html')}}">ASUS ROG STRIX GF850HLXX10 VR2 Gaming</a></h6>
                                            <div class="product-card__price d-flex">
                                                <span class="money price text-secondary">4400$</span>
                                            </div>

                                            <div
                                                class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                                        data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                                        data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                                    <span class="d-none d-xxl-block">Quick View</span>
                                                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                                          xmlns="http://www.w3.org/2000/svg">
                              <use href="#icon_view" />
                            </svg></span>
                                                </button>
                                                <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_heart" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide product-card product-card_style3">
                                        <div class="pc__img-wrapper">
                                            <a href="{{asset('details.html')}}">
                                                <img loading="lazy" src="{{asset('assets/images/home/demo3/product-1-1.jpg')}}" width="258" height="313"
                                                     alt="Cropped Faux leather Jacket" class="pc__img">
                                                <img loading="lazy" src="{{asset('assets/images/home/demo3/product-1-2.jpg')}}" width="258" height="313"
                                                     alt="Cropped Faux leather Jacket" class="pc__img pc__img-second">
                                            </a>
                                        </div>

                                        <div class="pc__info position-relative">
                                            <h6 class="pc__title"><a href="{{asset('details.html')}}">ASUS ROG STRIX G18</a></h6>
                                            <div class="product-card__price d-flex">
                                                <span class="money price text-secondary">3850$</span>
                                            </div>

                                            <div
                                                class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                                        data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                                        data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                                    <span class="d-none d-xxl-block">Quick View</span>
                                                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                                          xmlns="http://www.w3.org/2000/svg">
                              <use href="#icon_view" />
                            </svg></span>
                                                </button>
                                                <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_heart" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide product-card product-card_style3">
                                        <div class="pc__img-wrapper">
                                            <a href="{{asset('details.html')}}">
                                                <img loading="lazy" src="{{asset('assets/images/home/demo3/product-2-1.jpg')}}" width="258" height="313"
                                                     alt="Cropped Faux leather Jacket" class="pc__img">
                                                <img loading="lazy" src="{{asset('assets/images/home/demo3/product-2-2.jpg')}}" width="258" height="313"
                                                     alt="Cropped Faux leather Jacket" class="pc__img pc__img-second">
                                            </a>
                                        </div>

                                        <div class="pc__info position-relative">
                                            <h6 class="pc__title"><a href="{{asset('details.html')}}">LENOVO LEGION i5irix</a></h6>
                                            <div class="product-card__price d-flex">
                                                <span class="money price text-secondary">2125$</span>
                                            </div>

                                            <div
                                                class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                                        data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                                        data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                                    <span class="d-none d-xxl-block">Quick View</span>
                                                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                                          xmlns="http://www.w3.org/2000/svg">
                              <use href="#icon_view" />
                            </svg></span>
                                                </button>
                                                <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_heart" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide product-card product-card_style3">
                                        <div class="pc__img-wrapper">
                                            <a href="{{asset('details.html')}}">
                                                <img loading="lazy" src="{{asset('assets/images/home/demo3/product-3-1.jpg')}}" width="258" height="313"
                                                     alt="Cropped Faux leather Jacket" class="pc__img">
                                                <img loading="lazy" src="{{asset('assets/images/home/demo3/product-3-2.jpg')}}" width="258" height="313"
                                                     alt="Cropped Faux leather Jacket" class="pc__img pc__img-second">
                                            </a>
                                        </div>

                                        <div class="pc__info position-relative">
                                            <h6 class="pc__title"><a href="{{asset('details.html')}}">DELL GAMING G16</a></h6>
                                            <div class="product-card__price d-flex align-items-center">
                                                <span class="money price-old">1840$</span>
                                                <span class="money price text-secondary">1720$</span>
                                            </div>

                                            <div
                                                class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                                        data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                                        data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                                    <span class="d-none d-xxl-block">Quick View</span>
                                                    <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                                          xmlns="http://www.w3.org/2000/svg">
                              <use href="#icon_view" />
                            </svg></span>
                                                </button>
                                                <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_heart" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.swiper-wrapper -->
                            </div><!-- /.swiper-container js-swiper-slider -->
                        </div><!-- /.position-relative -->
                    </div>
                </div>
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section class="category-banner container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="category-banner__item border-radius-10 mb-5">
                            <img loading="lazy" class="h-auto" src="{{asset('assets/images/home/demo3/category_9.jpg')}}" width="690" height="665"
                                 alt="" />
                            <div class="category-banner__item-mark">
                                Starting at $500
                            </div>
                            <div class="category-banner__item-content">
                                <h3 class="mb-0">PS5 SLIM</h3>
                                <a href="#" class="btn-link default-underline text-uppercase fw-medium">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="category-banner__item border-radius-10 mb-5">
                            <img loading="lazy" class="h-auto" src="{{asset('assets/images/home/demo3/category_10.jpg')}}" width="690" height="665"
                                 alt="" />
                            <div class="category-banner__item-mark">
                                Starting at $340
                            </div>
                            <div class="category-banner__item-content">
                                <h3 class="mb-0">PS4 NEW 1000GB</h3>
                                <a href="#" class="btn-link default-underline text-uppercase fw-medium">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section class="products-grid container">
                <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Featured Products</h2>

                <div class="row">
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                            <div class="pc__img-wrapper">
                                <a href="{{asset('details.html')}}">
                                    <img loading="lazy" src="{{asset('assets/images/home/demo3/product-4.jpg')}}" width="330" height="400"
                                         alt="Cropped Faux leather Jacket" class="pc__img">
                                </a>
                            </div>

                            <div class="pc__info position-relative">
                                <h6 class="pc__title"><a href="{{asset('details.html')}}">Roku Smart TV 2025 – 32-Inch Select Series, 1080p Full HD TV </a></h6>
                                <div class="product-card__price d-flex align-items-center">
                                    <span class="money price text-secondary">116$</span>
                                </div>

                                <div
                                    class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                    <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                    <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                        <span class="d-none d-xxl-block">Quick View</span>
                                        <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                              xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_view" />
                      </svg></span>
                                    </button>
                                    <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_heart" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                            <div class="pc__img-wrapper">
                                <a href="details.html">
                                    <img loading="lazy" src="assets/images/home/demo3/product-5.jpg" width="330" height="400"
                                         alt="Cropped Faux leather Jacket" class="pc__img">
                                </a>
                            </div>

                            <div class="pc__info position-relative">
                                <h6 class="pc__title"><a href="details.html">
Xiaomi 108 cm (43 inch) FX Pro QLED Ultra HD</a></h6>
                                <div class="product-card__price d-flex align-items-center">
                                    <span class="money price text-secondary">500$</span>
                                </div>

                                <div
                                    class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                    <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                    <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                        <span class="d-none d-xxl-block">Quick View</span>
                                        <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                              xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_view" />
                      </svg></span>
                                    </button>
                                    <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_heart" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                            <div class="pc__img-wrapper">
                                <a href="details.html">
                                    <img loading="lazy" src="assets/images/home/demo3/product-6.jpg" width="330" height="400"
                                         alt="Cropped Faux leather Jacket" class="pc__img">
                                </a>

                            </div>

                            <div class="pc__info position-relative">
                                <h6 class="pc__title"><a href="details.html">
Xiaomi 138 cm (55 inch) FX Ultra HD 4K</a></h6>
                                <div class="product-card__price d-flex align-items-center">
                                    <span class="money price text-secondary">400$</span>
                                </div>

                                <div
                                    class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                    <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                    <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                        <span class="d-none d-xxl-block">Quick View</span>
                                        <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                              xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_view" />
                      </svg></span>
                                    </button>
                                    <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_heart" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                            <div class="pc__img-wrapper">
                                <a href="details.html">
                                    <img loading="lazy" src="assets/images/home/demo3/product-7.jpg" width="330" height="400"
                                         alt="Cropped Faux leather Jacket" class="pc__img">
                                </a>

                            </div>

                            <div class="pc__info position-relative">
                                <h6 class="pc__title">Panasonic 80 cm (32 inches) HD Ready Smart LED</h6>
                                <div class="product-card__price d-flex align-items-center">
                                    <span class="money price-old">$129</span>
                                    <span class="money price text-secondary">250$</span>
                                </div>

                                <div
                                    class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                    <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                    <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                        <span class="d-none d-xxl-block">Quick View</span>
                                        <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                              xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_view" />
                      </svg></span>
                                    </button>
                                    <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_heart" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                            <div class="pc__img-wrapper">
                                <a href="details.html">
                                    <img loading="lazy" src="assets/images/home/demo3/product-8.jpg" width="330" height="400"
                                         alt="Cropped Faux leather Jacket" class="pc__img">
                                </a>
                            </div>

                            <div class="pc__info position-relative">
                                <h6 class="pc__title"><a href="details.html">JBL Tune 770NC - Adaptive Noise Cancelling</a></h6>
                                <div class="product-card__price d-flex align-items-center">
                                    <span class="money price text-secondary">100$</span>
                                </div>

                                <div
                                    class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                    <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                    <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                        <span class="d-none d-xxl-block">Quick View</span>
                                        <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                              xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_view" />
                      </svg></span>
                                    </button>
                                    <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_heart" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                            <div class="pc__img-wrapper">
                                <a href="details.html">
                                    <img loading="lazy" src="assets/images/home/demo3/product-9.jpg" width="330" height="400"
                                         alt="Cropped Faux leather Jacket" class="pc__img">
                                </a>
                            </div>

                            <div class="pc__info position-relative">
                                <h6 class="pc__title"><a href="details.html">HLDIRECT 47 Inch Gaming Desk with LED Lights, Large RGB Computer</a></h6>
                                <div class="product-card__price d-flex align-items-center">
                                    <span class="money price text-secondary">179$</span>
                                </div>

                                <div
                                    class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                    <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                    <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                        <span class="d-none d-xxl-block">Quick View</span>
                                        <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                              xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_view" />
                      </svg></span>
                                    </button>
                                    <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_heart" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                            <div class="pc__img-wrapper">
                                <a href="details.html">
                                    <img loading="lazy" src="assets/images/home/demo3/product-10.jpg" width="330" height="400"
                                         alt="Cropped Faux leather Jacket" class="pc__img">
                                </a>
                            </div>

                            <div class="pc__info position-relative">
                                <h6 class="pc__title"><a href="details.html">Lufeiya L Shaped Computer Desk with Power Outlet Shelves, 47 Inch Corner Desk</a></h6>
                                <div class="product-card__price d-flex align-items-center">
                                    <span class="money price text-secondary">65$</span>
                                </div>

                                <div
                                    class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                    <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                    <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                        <span class="d-none d-xxl-block">Quick View</span>
                                        <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                              xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_view" />
                      </svg></span>
                                    </button>
                                    <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_heart" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                            <div class="pc__img-wrapper">
                                <a href="{{asset('details.html')}}">
                                    <img loading="lazy" src="{{asset('assets/images/home/demo3/product-11.jpg')}}" width="330" height="400"
                                         alt="Cropped Faux leather Jacket" class="pc__img">
                                </a>
                            </div>

                            <div class="pc__info position-relative">
                                <h6 class="pc__title">Laptop Stand for Desk, Adjustable Laptop Riser ABS+Silicone</h6>
                                <div class="product-card__price d-flex align-items-center">

                                    <span class="money price text-secondary">9$</span>
                                </div>

                                <div
                                    class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                    <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                            data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                    <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                            data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                        <span class="d-none d-xxl-block">Quick View</span>
                                        <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                              xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_view" />
                      </svg></span>
                                    </button>
                                    <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" title="Add To Wishlist">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_heart" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.row -->

                <div class="text-center mt-2">
                    <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" href="#">Load More</a>
                </div>
            </section>
        </div>

        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

    </main>
@endsection
