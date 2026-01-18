@extends('layouts.app')
@section('container')

<main>
    {{-- spell chatbot --}}
    {{-- <script src="https://bot.spell.com.np/static/chatbot.js" data-company="TES001"></script> --}}
    <section class="swiper-container js-swiper-slider swiper-number-pagination slideshow" data-settings='{
        "autoplay": {
          "delay": 5000
        },
        "slidesPerView": 1,
        "effect": "fade",
        "loop": true
      }'>

        <style>
            /* Default (for small/medium screens) */
            .large-only-style {
                width: auto;
                margin-left: 0;
            }

            /* Apply only for large screens (e.g., >= 992px) */
            @media (min-width: 992px) {
                .large-only-style {
                    width: 60%;
                    margin-left: 10px;
                }
            }

            .modal-body .form-check-label {
                cursor: pointer;
                padding: 4px 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
                margin-right: 8px;
            }

            .modal-body .form-check-input:checked+.form-check-label {
                background-color: #662d91;
                color: white;
                border-color: #662d91;
            }
        </style>

        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
            <div class="swiper-slide">
                <div class="overflow-hidden position-relative h-100 ">
                    <div class="slideshow-character position-absolute bottom-0 pos_right-center">
                        <img loading="lazy" src="{{ asset('storage/' . $slider->image) }}" width="600" height="733"
                            alt="{{ $slider->name }}"
                            class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
                        <div class="character_markup type2">
                            <p
                                class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mt-10">
                                {{ $slider->tagline }}</p>
                        </div>
                    </div>
                    <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                        <h6
                            class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                            New Arrivals</h6>
                        <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5 large-only-style">
                            {{ $slider->title }}
                        </h2>
                        <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5 large-only-style">
                            {{ $slider->subtitle }}</h2>
                        <a href="{{ $slider->link }}"
                            class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Shop
                            Now</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="container">
            <div
                class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5">
            </div>
        </div>
    </section>

    <div class="container mw-1620 bg-white border-radius-10">
        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

        @php
        $hotproduct = $products->where('brand_id', true);
        @endphp
        @if ($hotproduct->isNotEmpty())
        <section class="category-carousel container">
            <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">Brands</h2>
            <div class="position-relative">
                <div class="swiper-container js-swiper-slider" data-settings='{"autoplay": {
                "delay": 5000
              },
              "slidesPerView": 8,
              "slidesPerGroup": 1,
              "effect": "none",
              "loop": true,
              "navigation": {
                "nextEl": ".products-carousel__next-1",
                "prevEl": ".products-carousel__prev-1"
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "slidesPerGroup": 2,
                  "spaceBetween": 15
                },
                "768": {
                  "slidesPerView": 4,
                  "slidesPerGroup": 4,
                  "spaceBetween": 30
                },
                "992": {
                  "slidesPerView": 6,
                  "slidesPerGroup": 1,
                  "spaceBetween": 45,
                  "pagination": false
                },
                "1200": {
                  "slidesPerView": 8,
                  "slidesPerGroup": 1,
                  "spaceBetween": 60,
                  "pagination": false
                }
              }
            }'>
                    <div class="swiper-wrapper">
                        @forelse ($brands as $subCategory)
                        @if ($subCategory->products->count() > 0)
                        <div class="swiper-slide text-center">
                            <a href="{{ route('shop-by-brand', $subCategory->slug) }}">
                                <img loading="lazy"
                                    src="{{ $subCategory->image ? asset('storage/' . $subCategory->image) : '/path/to/default/image.png' }}"
                                    alt="{{ $subCategory->name }}"
                                    style="width: 100px; height: 100px; border-radius: 100%; object-fit: contain; background-color: #f9f9f9; transition: transform 0.3s ease;">
                            </a>
                            <div class="text-center mt-2">
                                @php $words = explode(' ', $subCategory->name, 2); @endphp
                                <a href="{{ route('shop-by-brand', $subCategory->slug) }}" class="menu-link fw-medium">
                                    {!! $words[0] !!}
                                    @if (isset($words[1]))
                                    <br />{!! $words[1] !!}
                                    @endif
                                </a>
                            </div>
                        </div>

                        @endif
                        @empty
                        <p>No Brands available.</p>
                        @endforelse
                    </div>
                </div>

                <div
                    class="products-carousel__prev products-carousel__prev-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25">
                        <use href="#icon_prev_md" />
                    </svg>
                </div>
                <div
                    class="products-carousel__next products-carousel__next-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25">
                        <use href="#icon_next_md" />
                    </svg>
                </div>
            </div>
        </section>
        @endif

        {{-- ================= HOT DEALS ================= --}}
        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
        @php $hotproduct = $products->where('hot_deals', true); @endphp
        @if ($hotproduct->isNotEmpty())
        <section class="hot-deals container">
            <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Hot Deals</h2>
            <div class="row">
                <div
                    class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
                    <h2>Summer Sale</h2>
                    <h2 class="fw-bold">Up to 60% Off</h2>
                    <div class="position-relative d-flex align-items-center text-center pt-xxl-4 js-countdown mb-3"
                        data-date="18-3-2024" data-time="06:50">
                        <div class="day countdown-unit"><span class="countdown-num d-block"></span>
                            <span class="countdown-word text-uppercase text-secondary">Days</span>
                        </div>
                        <div class="hour countdown-unit"><span class="countdown-num d-block"></span>
                            <span class="countdown-word text-uppercase text-secondary">Hours</span>
                        </div>
                        <div class="min countdown-unit"><span class="countdown-num d-block"></span>
                            <span class="countdown-word text-uppercase text-secondary">Mins</span>
                        </div>
                        <div class="sec countdown-unit"><span class="countdown-num d-block"></span>
                            <span class="countdown-word text-uppercase text-secondary">Sec</span>
                        </div>
                    </div>
                    {{-- ✅ Completed "View All" --}}
                    <a href="{{ route('shop.hot-deals') }}"
                        class="btn-link default-underline text-uppercase fw-medium mt-3">View All</a>
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
                                @foreach ($products as $product)
                                @if ($product->hot_deals)
                                @php
                                $mainImages = is_array($product->image)
                                ? $product->image
                                : explode(',', $product->image);
                                $variantImages = [];
                                if (isset($product->variants) && count($product->variants) > 0) {
                                foreach ($product->variants as $variant) {
                                if (
                                isset($variant['images']) &&
                                is_array($variant['images'])
                                ) {
                                $variantImages = array_merge(
                                $variantImages,
                                $variant['images'],
                                );
                                }
                                }
                                }
                                $allImages = array_merge($mainImages, $variantImages);
                                @endphp
                                <div class="swiper-slide product-card product-card_style3">
                                    <div class="pc__img-wrapper"
                                        style="width: 100%; max-width: 260px; aspect-ratio: 26 / 30; display: flex; align-items: center; justify-content: center; background-color: #f9f9f9; overflow: hidden; position: relative;">
                                        <a href="/products/{{ $product->slug }}" style="display: contents;">
                                            @foreach ($allImages as $index => $image)
                                            <img loading="lazy" src="{{ asset('storage/' . $image) }}"
                                                alt="{{ $product->name }}"
                                                style="width: 100%; height: 100%; object-fit: contain; display: block;"
                                                class="pc__img {{ $index > 0 ? 'pc__img-second' : '' }}">
                                            @endforeach
                                        </a>
                                    </div>




                                    <div class="pc__info position-relative">
                                        <h6 class="pc__title"><a href="/products/{{ $product->slug }}">{{ $product->name
                                                }}</a>
                                        </h6>
                                        <div class="product-card__price d-flex">
                                            <span class="money price text-secondary">Rs
                                                {{ $product->regular_price }}</span>
                                        </div>
                                        <div
                                            class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">

                                            <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                                data-bs-toggle="modal" data-bs-target="#productOptionModal"
                                                data-product-id="{{ $product->id }}"
                                                data-product-image="{{ is_array($product->image) ? $product->image[0] : $product->image }}"
                                                data-action="{{ route('cart.add') }}">
                                                Add To Cart
                                            </button>
                                            <a href="{{ route('products.show', $product->slug) }}"
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium"
                                                title="Quick view">
                                                <span class="d-none d-xxl-block">Quick View</span>
                                                <span class="d-block d-xxl-none">
                                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon-eye"></use>
                                                    </svg>
                                                </span>
                                            </a>
                                            <button
                                                class="pc__btn-wl bg-transparent border-0 js-add-wishlist js-buy-now"
                                                data-bs-toggle="modal" data-bs-target="#productOptionModal"
                                                data-product-id="{{ $product->id }}"
                                                data-product-image="{{ is_array($product->image) ? $product->image[0] : $product->image }}"
                                                data-action="{{ route('buy.now') }}">

                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif

        {{-- ================= NEW ARRIVALS ================= --}}
        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
        @php $newarrival = $products->where('new_arrivals', true); @endphp
        @if ($newarrival->isNotEmpty())
        <section class="category-banner container">
            <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">New Arrivals Products</h2>
            <div class="row">
                {{-- ✅ Show only 5 products --}}
                @foreach ($newarrival->take(4) as $product)
                <div class="col-md-6">
                    <div class="category-banner__item border-radius-10 mb-5"
                        style=" text-align: center; position: relative; width: 100%; max-width: 690px;">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <div class="category-banner__img-wrapper"
                                style="width: 100%; aspect-ratio: 690 / 665; display: flex; align-items: center; justify-content: center; background-color: #f9f9f9; overflow: hidden;">
                                <img loading="lazy" src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    style="width: 100%; height: 100%; object-fit: contain; display: block;">
                            </div>
                        </a>
                        <div class="category-banner__item-mark"
                            style="position: absolute; top: 0; right: 0; left: auto; margin: 0.5rem; background-color: red; color: white; padding: 0.25rem 0.5rem; border-radius:100%;">
                            Starting at Rs {{ $product->sale_price ?? $product->regular_price }}
                        </div>

                        <div class="category-banner__item-content" style="margin-top: 0.5rem;">
                            <h3 class="mt-3">{{ $product->name }}</h3>
                            <a href="{{ route('products.show', $product->slug) }}"
                                class="btn-link default-underline text-uppercase fw-medium">
                                Shop Now
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {{-- ✅ Added View All link --}}
            <div class="text-center mt-3">
                <a href="{{ route('shop.new-arrivals') }}"
                    class="btn-link default-underline text-uppercase fw-medium">View All</a>
            </div>
        </section>
        @endif

        {{-- ================= FEATURED PRODUCTS ================= --}}
        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
        @php $featuredProducts = $products->where('featured', true); @endphp
        @if ($featuredProducts->isNotEmpty())
        <section class="products-grid container">
            <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Featured Products</h2>
            <div class="row">
                {{-- ✅ Limit to 8 products (2 rows) --}}
                @foreach ($featuredProducts->take(8) as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                        <div class="pc__img-wrapper"
                            style="width: 100%; max-width: 330px; aspect-ratio: 330 / 400; display: flex; align-items: center; justify-content: center; background-color: #f9f9f9; overflow: hidden; position: relative;">
                            <a href="{{ route('products.show', $product->slug) }}"
                                style="width: 100%; height: 100%; display: block;">
                                <img loading="lazy" src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}" class="pc__img"
                                    style="width: 100%; height: 100%; object-fit: contain; display: block;">
                            </a>

                            @if ($product->discount_coupon)
                            <div class="product-label bg-red text-white right-0 top-0 left-auto mt-2 mx-2"
                                style="position: absolute;">
                                -{{ $product->discount_coupon }}
                            </div>
                            @endif
                        </div>


                        <div class="pc__info position-relative">
                            <h6 class="pc__title">
                                <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                            </h6>
                            <div class="product-card__price d-flex align-items-center">
                                <span class="money price text-secondary">Rs
                                    {{ $product->regular_price }}</span>
                            </div>
                            <div
                                class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">

                                <button
                                    class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                    data-bs-toggle="modal" data-bs-target="#productOptionModal"
                                    data-product-id="{{ $product->id }}"
                                    data-product-image="{{ is_array($product->image) ? $product->image[0] : $product->image }}"
                                    data-action="{{ route('cart.add') }}">
                                    Add To Cart
                                </button>



                                <a href="{{ route('products.show', $product->slug) }}"
                                    class="btn-link btn-link_lg me-4 text-uppercase fw-medium" title="Quick view">
                                    <span class="d-none d-xxl-block">Quick View</span>
                                    <span class="d-block d-xxl-none">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon-eye"></use>
                                        </svg>
                                    </span>
                                </a>
                                <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist js-buy-now"
                                    data-bs-toggle="modal" data-bs-target="#productOptionModal"
                                    data-product-id="{{ $product->id }}"
                                    data-product-image="{{ is_array($product->image) ? $product->image[0] : $product->image }}"
                                    data-action="{{ route('buy.now') }}">

                                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_heart" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- ✅ Replaced Load More with View All --}}
            <div class="text-center mt-2">
                <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium"
                    href="{{ route('shop.featured') }}">
                    View All
                </a>
            </div>
        </section>
        @endif
    </div>
    <!-- Product Option Modal -->
    <div class="modal fade" id="productOptionModal" tabindex="-1" aria-labelledby="productOptionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('cart.add') }}" id="modal-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="productOptionModalLabel">Select Product Options</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="modal-product-id">
                        <input type="hidden" name="image" id="modal-product-image">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Color</label>
                            <select name="color" class="form-select" id="modal-color" required>
                                <option value="">Select Color</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Size</label>
                            <select name="size" class="form-select" id="modal-size" required>
                                <option value="">Select Size</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary text-uppercase fw-medium">Add To Cart</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('productOptionModal');
            const modalForm = document.getElementById('modal-form');
            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const productId = button.getAttribute('data-product-id');
                const productImage = button.getAttribute('data-product-image');
                const action = button.getAttribute('data-action');
                modalForm.action = action;
                document.getElementById('modal-product-id').value = productId;
                document.getElementById('modal-product-image').value = productImage;
                const colorSelect = document.getElementById('modal-color');
                const sizeSelect = document.getElementById('modal-size');
                colorSelect.innerHTML = '<option value="">Select Color</option>';
                sizeSelect.innerHTML = '<option value="">Select Size</option>';
                // Fetch variants
                fetch(`/products/${productId}/variants`)
                    .then(res => res.json())
                    .then(data => {
                        if (!data.variants || !data.variants.length) return;

                        const variants = data.variants;

                        // Populate colors
                        const colors = [...new Set(variants.map(v => v.color).filter(Boolean))];
                        colors.forEach(c => colorSelect.add(new Option(c, c)));

                        // When color changes, update size dropdown
                        colorSelect.addEventListener('change', function() {
                            const selectedColor = this.value;
                            sizeSelect.innerHTML = '<option value="">Select Size</option>';

                            // Filter sizes available for selected color
                            const availableSizes = variants
                                .filter(v => v.color === selectedColor)
                                .map(v => v.size)
                                .filter(Boolean);

                            // Remove duplicates
                            const uniqueSizes = [...new Set(availableSizes)];
                            uniqueSizes.forEach(s => sizeSelect.add(new Option(s, s)));
                        });

                        // Optionally, preselect the first color
                        // colorSelect.value = colors[0];
                        // colorSelect.dispatchEvent(new Event('change'));
                    })
                    .catch(err => console.error('Error fetching variants:', err));
            });
        });

</script>










@endsection
