@extends('layouts.app')
@section('container')
    <main class="pt-90">
        <div class="mb-md-1 pb-md-3"></div>
        <section class="product-single container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="product-single__media" data-media-type="vertical-thumbnail">
                        <div class="product-single__image">
                            <div class="swiper-container main-product-swiper">
                                <div class="swiper-wrapper custom-swiper">
                                    <style>
                                        /* 🔧 Core Swiper fix — enforce proper sizing */
                                        .product-single__image .swiper-container,
                                        .product-single__image .swiper {
                                            width: 100% !important;
                                            overflow: hidden !important;
                                        }

                                        .product-single__image .swiper-wrapper {
                                            width: 100% !important;
                                            height: auto !important;
                                            display: flex !important;
                                            transition-property: transform !important;
                                        }

                                        .product-single__image .swiper-slide {
                                            flex-shrink: 0 !important;
                                            width: 100% !important;
                                            height: auto !important;
                                            display: flex !important;
                                            align-items: center !important;
                                            justify-content: center !important;
                                            overflow: hidden !important;
                                        }

                                        .product-single__image .swiper-slide img {
                                            display: block;
                                            width: 100%;
                                            height: auto;
                                            object-fit: contain;
                                        }
                                    </style>
                                    <style>
                                        /* Fix for product main image swiper */
                                        .main-product-swiper {
                                            width: 100%;
                                            overflow: hidden !important;
                                        }

                                        .main-product-swiper .swiper-wrapper {
                                            display: flex;
                                            width: 100%;
                                            height: 100%;
                                        }

                                        .main-product-swiper .swiper-slide {
                                            width: 100% !important;
                                            flex-shrink: 0 !important;
                                            height: auto;
                                            overflow: hidden;
                                        }

                                        .main-product-swiper .swiper-slide img {
                                            width: 100%;
                                            height: auto;
                                            object-fit: contain;
                                            display: block;
                                        }
                                    </style>



                                    @foreach ($product->variants as $variant)
                                        @if (!empty($variant['images']))
                                            @foreach ($variant['images'] as $image)
                                                <div class="swiper-slide product-single__image-item">
                                                    <img loading="lazy" class="h-auto"
                                                        src="{{ asset('storage/' . $image) }}" alt="" />
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                                <div class="swiper-button-prev">
                                    <svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_sm" />
                                    </svg>
                                </div>
                                <div class="swiper-button-next">
                                    <svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_sm" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="product-single__thumbnail">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach ($product->variants as $variant)
                                        @if (!empty($variant['images']))
                                            @foreach ($variant['images'] as $image)
                                                <div class="swiper-slide product-single__image-item">
                                                    <img loading="lazy" class="h-auto"
                                                        src="{{ asset('storage/' . $image) }}" width="104" height="104"
                                                        alt="Product Image">
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <h1 class="product-single__name">{{ $product->name }}</h1>
                    <div class="product-single__rating">
                        @php
                            $averageRating = round($reviews->avg('rating') ?? 0, 1);
                            $totalReviews = $reviews->count();
                        @endphp
                        <div class="reviews-group d-flex">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="review-star {{ $i <= floor($averageRating) ? '' : 'text-muted' }}"
                                    viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_star" />
                                </svg>
                            @endfor
                        </div>
                        <span class="reviews-note text-lowercase text-secondary ms-1">
                            {{ number_format($averageRating, 1) }} ★ ({{ $totalReviews }} reviews)
                        </span>
                    </div>


                    <div class="product-single__price">
                        <span class="current-price">
                            @if ($product->sale_price)
                                <s>Rs{{ $product->regular_price }}</s> Rs{{ $product->sale_price }}
                            @else
                                Rs{{ $product->regular_price }}
                            @endif
                        </span>
                    </div>
                    <div class="product-single__short-desc">
                        <p>{{ $product->short_description }}</p>
                    </div>
                    @php
                        $rawVariants = is_string($product->variants)
                            ? json_decode($product->variants, true)
                            : $product->variants;
                        $variants = [];
                        foreach ($rawVariants as $v) {
                            $colors = array_map('trim', explode(',', $v['color']));
                            $sizes = array_map('trim', explode(',', $v['size']));
                            foreach ($colors as $color) {
                                foreach ($sizes as $size) {
                                    $variants[] = [
                                        'color' => strtolower($color),
                                        'size' => strtolower($size),
                                        'images' => $v['images'] ?? [],
                                        'quantity' => $v['quantity'] ?? 0,
                                    ];
                                }
                            }
                        }
                        $allColors = collect($variants)->pluck('color')->unique();
                        $allSizes = collect($variants)->pluck('size')->unique();
                        $firstColor = $allColors->first();
                    @endphp

                    <!-- Color Options -->
                    <div class="mb-3">
                        <label class="form-label fw-bold d-block">Select Color:</label>
                        @foreach ($allColors as $color)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input color-select" type="radio" name="color"
                                    id="color_{{ $color }}" value="{{ $color }}"
                                    {{ $color === $firstColor ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="color_{{ $color }}">{{ ucfirst($color) }}</label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Size Options -->
                    <div class="mb-3" id="size-options-wrapper">
                        <label class="form-label fw-bold d-block">Select Size:</label>
                        @foreach ($allSizes as $size)
                            <div class="form-check form-check-inline size-option-wrapper">
                                <input class="form-check-input size-select" type="radio" name="size"
                                    id="size_{{ $size }}" value="{{ $size }}">
                                <label class="form-check-label"
                                    for="size_{{ $size }}">{{ strtoupper($size) }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div id="variantError" style="display:none; color:red; margin-bottom:10px;"></div>


                    <!-- Buy / Add to Cart -->
                    <div style="display: flex; gap: 3px;" class="product-single__addtocart">
                        <form id="buyNowForm" action="{{ route('buy.now') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="color" id="selectedColor">
                            <input type="hidden" name="size" id="selectedSize">
                            <button type="submit" class="btn btn-warning mb-3"
                                style="background-color: purple;color: white;">Buy Now</button>
                        </form>

                        <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="color" id="selectedColorCart">
                            <input type="hidden" name="size" id="selectedSizeCart">
                            <input type="hidden" name="image" id="selectedVariantImage">

                            <input type="hidden" name="price"
                                value="{{ $product->sale_price ?? $product->regular_price }}">
                            <button type="submit" class="btn btn-warning mb-3"
                                style="background-color: black;color: white;">Add to Cart</button>
                        </form>
                    </div>

                    <!-- Product Meta Info -->
                    <div class="product-single__meta-info">
                        <div class="meta-item"><label>SKU:</label> <span>{{ $product->sku }}</span></div>
                        <div class="meta-item"><label>Brand:</label>
                            <span>{{ $product->brand?->name ?? 'Uncategorized' }}</span>
                        </div>
                        <div class="meta-item"><label>Categories:</label>
                            <span>{{ $product->category?->name ?? 'Uncategorized' }}</span>
                        </div>
                        <div class="meta-item"><label>Tags:</label> <span>{{ $product->slug }}</span></div>
                    </div>
                </div>
            </div>

            <!-- Tabs: Description, Info, Reviews -->
            <div class="product-single__details-tab">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab"
                            href="#tab-description" role="tab" aria-controls="tab-description"
                            aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore" id="tab-additional-info-tab" data-bs-toggle="tab"
                            href="#tab-additional-info" role="tab" aria-controls="tab-additional-info"
                            aria-selected="false">Additional Information</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore" id="tab-reviews-tab" data-bs-toggle="tab"
                            href="#tab-reviews" role="tab" aria-controls="tab-reviews" aria-selected="false">
                            Reviews ({{ $reviews->count() }})</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-description" role="tabpanel">
                        <div class="product-single__description">
                            <h3 class="block-title mb-4">{{ $product->short_description }}</h3>
                            <p class="content">{{ $product->description }}</p>
                            <div class="row">
                                {{-- <div class="col-lg-6">
                                <h3 class="block-title">Why choose product?</h3>
                                <ul class="list text-list">
                                    <li>Creat by cotton fibric with soft and smooth</li>
                                    <li>Simple, Configurable (e.g. size, color, etc.), bundled</li>
                                    <li>Downloadable/Digital Products, Virtual Products</li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <h3 class="block-title">Sample Number List</h3>
                                <ol class="list text-list">
                                    <li>Create Store-specific attrittbutes on the fly</li>
                                    <li>Simple, Configurable (e.g. size, color, etc.), bundled</li>
                                    <li>Downloadable/Digital Products, Virtual Products</li>
                                </ol>
                            </div> --}}
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-additional-info" role="tabpanel"
                        aria-labelledby="tab-additional-info-tab">
                        <div class="product-single__addtional-info">
                            <div class="item"><label
                                    class="h6">Weight</label><span>{{ $product->weight ?? 'N/A' }}</span>
                            </div>
                            <div class="item"><label
                                    class="h6">Dimensions</label><span>{{ $product->dimensions ?? 'N/A' }}</span>
                            </div>
                            @php
                                $sizes = implode(', ', array_column($product->variants, 'size'));
                                $colors = implode(', ', array_column($product->variants, 'color'));
                            @endphp

                            <div class="item">
                                <label class="h6">Size</label>
                                <span>{{ $sizes ?: 'N/A' }}</span>
                            </div>
                            <div class="item">
                                <label class="h6">Color</label>
                                <span>{{ $colors ?: 'N/A' }}</span>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-reviews" role="tabpanel">
                        <div class="product-single__reviews-list">
                            @forelse($reviews as $review)
                                <div class="product-single__reviews-item">
                                    <div class="customer-avatar">
                                        <img src="{{ $review->user?->image ? asset('storage/' . $review->user->image) : '/asset/images/avatar.jpg' }}"
                                            alt="{{ $review->user?->name ?? 'Guest' }}" />
                                    </div>
                                    <div class="customer-review">
                                        <div class="customer-name">
                                            <h6>{{ $review->user?->name ?? 'Guest' }}</h6>
                                            <div class="reviews-group d-flex">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="review-star" viewBox="0 0 9 9"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        style="fill: {{ $i <= $review->rating ? '#ffc107' : '#e4e5e9' }};">
                                                        <use href="#icon_star"></use>
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="review-date">{{ $review->created_at->format('F d, Y') }}</div>
                                        <div class="review-text">
                                            <p>{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>No reviews yet. Be the first to review this product!</p>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
            <section class="products-carousel container">
                <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Related <strong>Products</strong></h2>

                <div id="related_products" class="position-relative">
                    <div class="swiper-container js-swiper-slider"
                        data-settings='{
            "autoplay": false,
            "slidesPerView": 4,
            "slidesPerGroup": 4,
            "effect": "none",
            "loop": true,
            "pagination": {
              "el": "#related_products .products-pagination",
              "type": "bullets",
              "clickable": true
            },
            "navigation": {
              "nextEl": "#related_products .products-carousel__next",
              "prevEl": "#related_products .products-carousel__prev"
            },
            "breakpoints": {
              "320": {
                "slidesPerView": 2,
                "slidesPerGroup": 2,
                "spaceBetween": 14
              },
              "768": {
                "slidesPerView": 3,
                "slidesPerGroup": 3,
                "spaceBetween": 24
              },
              "992": {
                "slidesPerView": 4,
                "slidesPerGroup": 4,
                "spaceBetween": 30
              }
            }
          }'>
                        <div class="swiper-wrapper">
                            @forelse($relatedProducts as $related)
                                <div class="swiper-slide product-card">
                                    <div class="pc__img-wrapper"
                                        style="width: 100%; max-width: 400px; aspect-ratio: 400 / 541; display: flex; align-items: center; justify-content: center; position: relative; background-color: #f9f9f9; overflow: hidden; margin: 0 auto;">
                                        <a href="{{ route('products.show', $related->slug) }}"
                                            style="width: 100%; height: 100%; display: block;">
                                            <img src="{{ asset('storage/' . $related->image) }}"
                                                alt="{{ $related->name }}" class="pc__img"
                                                style="width: 100%; height: 100%; object-fit: contain; display: block;">
                                        </a>

                                        <button
                                            class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium js-add-cart js-open-aside"
                                            data-bs-toggle="modal" data-bs-target="#productOptionModal"
                                            data-product-id="{{ $related->id }}"
                                            data-product-image="{{ is_array($related->image) ? $related->image[0] : $related->image }}"
                                            data-action="{{ route('cart.add') }}"
                                            style="bottom: 10px; left: 50%; transform: translateX(-50%);">
                                            Add To Cart
                                        </button>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <p class="pc__category">{{ $related->category->name ?? 'Uncategorized' }}</p>
                                        <h6 class="pc__title">
                                            <a
                                                href="{{ route('products.show', $related->slug) }}">{{ $related->name }}</a>
                                        </h6>
                                        <div class="product-card__price d-flex">
                                            @if ($related->sale_price)
                                                <span class="money price">Rs {{ $related->sale_price }}</span>
                                                <span class="money price-old">Rs {{ $related->regular_price }}</span>
                                            @else
                                                <span class="money price">Rs {{ $related->regular_price }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <p>No related products found.</p>
                            @endforelse
                        </div>
                    </div><!-- /.swiper-container js-swiper-slider -->

                    <div
                        class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_prev_md" />
                        </svg>
                    </div><!-- /.products-carousel__prev -->
                    <div
                        class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_next_md" />
                        </svg>
                    </div>
                    <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
                </div>

            </section>
        </section>
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
            const thumbnails = document.querySelectorAll('.product-single__thumbnail img');
            const sizeOptions = document.querySelectorAll('.size-select');
            const colorOptions = document.querySelectorAll('.color-select');
            const mainSwiperWrapper = document.querySelector('.product-single__image .swiper-wrapper');
            const variants = @json($variants);

            let selectedColor = document.querySelector('input[name="color"]:checked')?.value || null;
            let selectedSize = null;

            // --- Initialize Swiper ---
            window.mainSwiper = new Swiper('.main-product-swiper', {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: false,
                centeredSlides: false,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
            window.addEventListener('load', () => {
                if (window.mainSwiper) {
                    window.mainSwiper.update();
                    window.mainSwiper.slideTo(0, 0); // reset to first image cleanly
                }
            });





            const mainSlides = mainSwiperWrapper.querySelectorAll('.swiper-slide img');
            mainSlides.forEach((img, idx) => img.dataset.variantIndex = idx);
            thumbnails.forEach((thumb, idx) => thumb.dataset.variantIndex = idx);

            function updateSizes(color) {
                const availableSizes = variants
                    .filter(v => v.color.toLowerCase() === color.toLowerCase())
                    .map(v => v.size);
                sizeOptions.forEach(size => {
                    const wrapper = size.closest('.size-option-wrapper');
                    if (availableSizes.includes(size.value)) {
                        size.disabled = false;
                        wrapper.style.display = 'inline-block';
                    } else {
                        size.disabled = true;
                        wrapper.style.display = 'none';
                        size.checked = false;
                    }
                });
                selectedSize = null;
            }

            function updateVariantSelection(variant) {
                if (!variant) return;
                selectedColor = variant.color;
                selectedSize = variant.size;
                colorOptions.forEach(c => c.checked = c.value.toLowerCase() === variant.color.toLowerCase());
                sizeOptions.forEach(s => s.checked = s.value.toLowerCase() === variant.size.toLowerCase());
                updateSizes(selectedColor);
            }
            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', function() {
                    const idx = parseInt(this.dataset.variantIndex);
                    const variant = variants[idx];
                    if (window.mainSwiper) {
                        // Force exact positioning
                        window.mainSwiper.slideToLoop ?
                            window.mainSwiper.slideToLoop(idx, 0) :
                            window.mainSwiper.slideTo(idx, 0);
                        // Recalculate size to prevent offset
                        setTimeout(() => window.mainSwiper.update(), 100);
                    }
                    thumbnails.forEach(t => t.classList.remove('active-thumbnail'));
                    this.classList.add('active-thumbnail');
                    updateVariantSelection(variant);
                });

            });
            if (window.mainSwiper) {
                window.mainSwiper.on('slideChange', function() {
                    const activeSlide = mainSlides[this.activeIndex];
                    if (!activeSlide) return;

                    const idx = parseInt(activeSlide.dataset.variantIndex);
                    const variant = variants[idx];
                    updateVariantSelection(variant);
                    thumbnails.forEach(t => {
                        t.classList.remove('active-thumbnail');
                        if (parseInt(t.dataset.variantIndex) === idx) t.classList.add(
                            'active-thumbnail');
                    });
                });
            }
            colorOptions.forEach(radio => {
                radio.addEventListener('change', function() {
                    selectedColor = this.value;
                    updateSizes(selectedColor);
                });
            });
            sizeOptions.forEach(sizeInput => {
                sizeInput.addEventListener('change', function() {
                    selectedSize = this.value;
                    if (selectedColor && selectedSize) {
                        const variant = variants.find(v =>
                            v.color.toLowerCase() === selectedColor.toLowerCase() &&
                            v.size.toLowerCase() === selectedSize.toLowerCase()
                        );
                        if (variant) {
                            const idx = variants.indexOf(variant);
                            if (idx >= 0 && window.mainSwiper) window.mainSwiper.slideTo(idx);
                        }
                    }
                });
            });

            function handleFormWithImage(formId, colorField, sizeField, imageField) {
                const form = document.getElementById(formId);
                form.addEventListener('submit', e => {
                    const color = document.querySelector('input[name="color"]:checked');
                    const size = document.querySelector('input[name="size"]:checked');

                    function showVariantError(message) {
                        const errorBox = document.getElementById('variantError');
                        errorBox.textContent = message;
                        errorBox.style.display = 'block';
                        setTimeout(() => {
                            errorBox.style.display = 'none';
                            errorBox.textContent = '';
                        }, 4000);
                    }
                    if (!color || !size) {
                        e.preventDefault();
                        showVariantError('Please select color and size.');
                        return;
                    }
                    document.getElementById(colorField).value = color.value;
                    document.getElementById(sizeField).value = size.value;
                    const variant = variants.find(v =>
                        v.color.toLowerCase() === color.value.toLowerCase() &&
                        v.size.toLowerCase() === size.value.toLowerCase()
                    );
                    if (variant && variant.images.length > 0) {
                        document.getElementById(imageField).value = variant.images[0];
                    } else {
                        document.getElementById(imageField).value = '{{ $product->image }}';
                    }
                });
            }
            handleFormWithImage('addToCartForm', 'selectedColorCart', 'selectedSizeCart', 'selectedVariantImage');
            handleFormWithImage('buyNowForm', 'selectedColor', 'selectedSize', 'selectedVariantImage');
            if (selectedColor) updateSizes(selectedColor);
        });
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
                fetch(`/products/${productId}/variants`)
                    .then(res => res.json())
                    .then(data => {
                        if (!data.variants || !data.variants.length) return;
                        const variants = data.variants;
                        const colors = [...new Set(variants.map(v => v.color).filter(Boolean))];
                        colors.forEach(c => colorSelect.add(new Option(c, c)));
                        colorSelect.addEventListener('change', function() {
                            const selectedColor = this.value;
                            sizeSelect.innerHTML = '<option value="">Select Size</option>';
                            const availableSizes = variants
                                .filter(v => v.color === selectedColor)
                                .map(v => v.size)
                                .filter(Boolean);
                            const uniqueSizes = [...new Set(availableSizes)];
                            uniqueSizes.forEach(s => sizeSelect.add(new Option(s, s)));
                        });
                    })
                    .catch(err => console.error('Error fetching variants:', err));
            });
        });
    </script>
@endsection
