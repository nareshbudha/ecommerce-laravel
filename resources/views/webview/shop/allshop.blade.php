@extends('layouts.app')
@section('container')
<main class="pt-90">
    <section class="shop-main container d-flex pt-4 pt-xl-5">
        {{-- Sidebar Filters --}}
        <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
            <div class="aside-header d-flex d-lg-none align-items-center">
                <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
                <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
            </div>
            <div class="pt-4 pt-lg-0"></div>
            {{-- Categories --}}
          <div class="accordion" id="categories-list">
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-1">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true" aria-controls="accordion-filter-1">
                            Product Categories
                        </button>
                    </h5>
                    <div id="accordion-filter-1" class="accordion-collapse collapse show border-0" aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
                        <div class="accordion-body px-0 pb-0 pt-3">
                            <ul class="list list-inline mb-0">
                                @foreach ($categories as $category)
                                <li class="list-item">
                                    <a href="{{ url('/shop/all?' . http_build_query(array_merge(request()->all(), ['category' => $category->slug]))) }}" class="menu-link py-1 {{ request('category') == $category->slug ? 'text-primary fw-bold' : '' }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Subcategories --}}
            <div class="accordion" id="subcategories-list">
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-2">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-filter-2" aria-expanded="true" aria-controls="accordion-filter-2">
                            Product Sub Categories
                        </button>
                    </h5>
                    <div id="accordion-filter-2" class="accordion-collapse collapse show border-0" aria-labelledby="accordion-heading-2" data-bs-parent="#subcategories-list">
                        <div class="accordion-body px-0 pb-0 pt-3">
                            <ul class="list list-inline mb-0">
                                @foreach ($subcategories as $subcategory)
                                <li class="list-item">
                                    <a href="{{ url('/shop/all?' . http_build_query(array_merge(request()->all(), ['subcategory' => $subcategory->slug]))) }}" class="menu-link py-1 {{ request('subcategory') == $subcategory->slug ? 'text-primary fw-bold' : '' }}">
                                        {{ $subcategory->name }}({{ $subcategory->products_count }})
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Colors --}}
            <div class="accordion" id="color-filters">
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-color">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-filter-color" aria-expanded="true" aria-controls="accordion-filter-color">
                            Color
                        </button>
                    </h5>
                    <div id="accordion-filter-color" class="accordion-collapse collapse show border-0" aria-labelledby="accordion-heading-color" data-bs-parent="#color-filters">
                        <div class="accordion-body px-0 pb-0">
                            @php
                            $colorsClean = str_replace(['[', ']','{','}'], '', $colors);
                            $colorArray = explode(',', $colorsClean);
                            $cleanedColors = array_map(function($color) {
                            $color = trim($color);
                            $color = str_replace('"', '', $color);
                            $color = str_ireplace('and', '', $color);
                            return trim($color);
                            }, $colorArray);
                            $uniqueColors = array_unique($cleanedColors);
                            @endphp
                            <div class="d-flex flex-wrap">
                                @foreach ($uniqueColors as $color)
                                <div class="color-item text-center m-1">
                                    <a href="{{ url('/shop/all?' . http_build_query(array_merge(request()->all(), ['color' => $color]))) }}" style="background-color: {{ $color }}; width: 20px; height: 20px; display: inline-block; border-radius: 50%; border: 1px solid #ccc;">
                                    </a>
                                    <div class="color-name" style="font-size: 0.75rem; margin-top: 4px;">
                                        {{ $color }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sizes --}}
            <div class="accordion" id="size-filters">
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-size">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-filter-size" aria-expanded="true" aria-controls="accordion-filter-size">
                            Sizes
                        </button>
                    </h5>
                    <div id="accordion-filter-size" class="accordion-collapse collapse show border-0" aria-labelledby="accordion-heading-size" data-bs-parent="#size-filters">
                        <div class="accordion-body px-0 pb-0">
                            <div class="d-flex flex-wrap">
                                @foreach ($sizes as $size)
                                <a href="{{ url('/shop/all?' . http_build_query(array_merge(request()->all(), ['size' => $size]))) }}" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3">{{ $size }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Brands --}}
            <div class="accordion" id="brand-filters">
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-brand">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-filter-brand" aria-expanded="true" aria-controls="accordion-filter-brand">
                            Brands
                        </button>
                    </h5>
                    <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0" aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
                        <div class="search-field multi-select accordion-body px-0 pb-0">
                            <ul class="multi-select__list list-unstyled">
                                @foreach ($brands as $brand)
                                <li class="search-suggestion__item multi-select__item text-primary">
                                    <a href="{{ url('/shop/all?' . http_build_query(array_merge(request()->all(), ['brand' => $brand->slug]))) }}">
                                        <span class="me-auto">{{ $brand->name }}</span>
                                        <span class="text-secondary">{{ $brand->products_count }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Price --}}
            <div class="accordion" id="price-filters">
                <div class="accordion-item mb-4">
                    <h5 class="accordion-header mb-2" id="accordion-heading-price">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-filter-price" aria-expanded="true" aria-controls="accordion-filter-price">
                            Price
                        </button>
                    </h5>
                    <div id="accordion-filter-price" class="accordion-collapse collapse show border-0" aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
                        <form method="GET" action="{{ url('/shop/all') }}">
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                            <input type="hidden" name="brand_id" value="{{ request('brand_id') }}">
                            <input type="hidden" name="size" value="{{ request('size') }}">
                            <input type="hidden" name="color" value="{{ request('color') }}">

                            <input class="price-range-slider" type="text" name="price_range" data-slider-min="10" data-slider-max="1000" data-slider-step="5" data-slider-value="[{{ request('min_price', 250) }},{{ request('max_price', 450) }}]" data-currency="Rs" />

                            <div class="price-range__info d-flex align-items-center mt-2">
                                <div class="me-auto">
                                    <span class="text-secondary">Min Price: </span>
                                    <span class="price-range__min">Rs{{ request('min_price', 10) }}</span>
                                </div>
                                <div>
                                    <span class="text-secondary">Max Price: </span>
                                    <span class="price-range__max">Rs{{ request('max_price', 10000) }}</span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary mt-2">Apply</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        {{-- Shop List and Products --}}
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
                    @foreach ($categories as $cat)
                    <div class="swiper-slide">
                        <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                            <div class="slide-split_text position-relative d-flex align-items-center"
                                style="background-color: #f5e6e0; flex: 1 1 50%;">
                                <div class="slideshow-text container p-3 p-xl-5">
                                    <h2 class="text-uppercase section-title fw-normal mb-3">
                                        {{ $cat->name }}

                                    </h2>
                                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5">Accessories
                                        are the
                                        best way to
                                        update your look. Add a title edge with new styles and new colors, or go for
                                        timeless pieces.</p>
                                </div>
                            </div>
                            <div class="slide-split_media position-relative" style="flex: 1 1 50%;">
                                <div class="slideshow-bg"
                                    style="background-color: #f5e6e0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    <a href="{{ route('shop', ['with' => $cat->slug]) }}"
                                        style="width: 100%; height: 100%; display: block;">
                                        <img loading="lazy" src="{{ asset('storage/' . $cat->image) }}"
                                            alt="{{ $cat->name }}"
                                            style="width: 100%; height: auto; max-height: 100%; object-fit: contain; display: block;">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="container p-3 p-xl-5">
                    <div class="slideshow-pagination d-flex align-items-center position-absolute bottom-0 mb-4 pb-xl-2">
                    </div>

                </div>
            </div>
            <div class="mb-3 pb-2 pb-xl-3"></div>
            <div class="d-flex justify-content-between mb-4 pb-md-2">
                <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                    <a href="/" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                </div>
                <div
                    class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                    <select id="sortSelect" class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0"
                        aria-label="Sort Items" name="sort">
                        <option value="" {{ request('sort')=='' ? 'selected' : '' }}>Default Sorting</option>
                        <option value="featured" {{ request('sort')=='featured' ? 'selected' : '' }}>Featured
                        </option>
                
                        <option value="name_asc" {{ request('sort')=='name_asc' ? 'selected' : '' }}>Alphabetically,
                            A-Z
                        </option>
                        <option value="name_desc" {{ request('sort')=='name_desc' ? 'selected' : '' }}>
                            Alphabetically,
                            Z-A</option>
                        <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Price, High
                            to
                            Low</option>
                        <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Price, Low
                            to
                            High</option>
                        <option value="date_old" {{ request('sort')=='date_old' ? 'selected' : '' }}>Date, old to
                            new
                        </option>
                        <option value="date_new" {{ request('sort')=='date_new' ? 'selected' : '' }}>Date, new to
                            old
                        </option>
                    </select>
                    <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div>
                    <div class="col-size align-items-center order-1 d-none d-lg-flex">
                        <span class="text-uppercase fw-medium me-2">View</span>
                        <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid"
                            data-cols="2">2</button>
                        <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid"
                            data-cols="3">3</button>
                        <button class="btn-link fw-medium js-cols-size" data-target="products-grid"
                            data-cols="4">4</button>
                    </div>
                    <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
                        <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside"
                            data-aside="shopFilter">
                            <svg class="d-inline-block align-middle me-2" width="14" height="10" viewBox="0 0 14 10"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_filter" />
                            </svg>
                            <span class="text-uppercase fw-medium d-inline-block align-middle">Filter</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
                @if ($products->count() > 0)
                @foreach ($products as $product)
                <div class="product-card-wrapper">
                    <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                        <div class="pc__img-wrapper">
                            <div class="swiper-container background-img js-swiper-slider"
                                data-settings='{"resizeObserver": true}'>
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <a href="{{ route('product-detail', ['slug' => $product->slug]) }}"
                                            style="display: block; width: 100%; max-width: 400px; margin: 0 auto;">
                                            <img loading="lazy" src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name }}" class="pc__img"
                                                style="width: 100%; height: auto; aspect-ratio: 400 / 541; object-fit: contain; background-color: #f9f9f9; display: block;">
                                        </a>
                                    </div>
                                    <div class="swiper-slide">
                                        @php
                                        $images = is_string($product->images)
                                        ? json_decode($product->images, true)
                                        : $product->images;
                                        $images = array_map(function ($image) {
                                        return str_replace('\\', '/', $image);
                                        }, $images ?? []);
                                        @endphp

                                        @if (!empty($images) && isset($images[0]))
                                        <a href="{{ route('product-detail', ['slug' => $product->slug]) }}"
                                            style="display: block; width: 100%; max-width: 400px; margin: 0 auto;">
                                            <img loading="lazy" src="{{ asset('storage/' . $images[0]) }}"
                                                alt="{{ $product->name }}" class="pc__img"
                                                style="width: 100%; height: auto; aspect-ratio: 400 / 541; object-fit: contain; background-color: #f9f9f9; display: block;">
                                        </a>
                                        @else
                                        <p>No image available</p>
                                        @endif
                                    </div>
                                </div>
                                <span class="pc__img-prev">
                                    <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_sm" />
                                    </svg>
                                </span>
                                <span class="pc__img-next">
                                    <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_sm" />
                                    </svg>
                                </span>
                            </div>
                            @php
                            $inCart = \App\Models\CartItem::where('user_id', auth()->id())
                            ->where('product_id', $product->id)
                            ->exists();
                            @endphp
                            @if ($inCart)
                            <a href="{{ route('cart.index') }}"
                                class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium btn-warning mb-3">
                                Go To Cart
                            </a>
                            @else
                            <button type="button"
                                class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium"
                                data-bs-toggle="modal" data-bs-target="#productOptionModal"
                                data-product-id="{{ $product->id }}"
                                data-product-image="{{ is_array($product->image) ? $product->image[0] : $product->image }}"
                                data-action="{{ route('cart.add') }}">
                                Add To Cart
                            </button>
                            @endif
                        </div>
                        <div class="pc__info position-relative">
                            {{-- <p class="pc__category">{{ $product->category->name }}</p> --}}
                            <h6 class="pc__title">{{ $product->name }}</h6>
                            <div class="product-card__price d-flex">
                                <span class="money price">
                                    @if ($product->sale_price)
                                    <s>Rs{{ $product->regular_price }}</s> Rs{{ $product->sale_price }}
                                    @else
                                    Rs{{ $product->regular_price }}
                                    @endif
                                </span>
                            </div>
                            <div class="product-card__review d-flex align-items-center">
                                @php
                                $productReviews = $product->reviews; // Only reviews for this product
                                $averageRating = $productReviews->avg('rating');
                                @endphp
                                @for ($i = 1; $i <= 5; $i++) <svg class="review-star" viewBox="0 0 9 9"
                                    xmlns="http://www.w3.org/2000/svg"
                                    style="fill: {{ $i <= round($averageRating) ? '#ffc107' : '#e4e5e9' }};">
                                    <use href="#icon_star" />
                                    </svg>
                                    @endfor
                                    <span class="reviews-note text-lowercase text-secondary ms-1">
                                        {{ $productReviews->count() }}
                                        review{{ $productReviews->count() > 1 ? 's' : '' }}
                                    </span>
                            </div>
                            <button
                                class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                title="Add To Wishlist">
                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_heart" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-12 text-center py-5">
                    <h4 class="text-secondary">No products found for your selected filters.</h4>
                    <p class="text-muted">Try changing the filters or <a href="{{ route('shop') }}">view all
                            products</a>.</p>
                </div>
                @endif

            </div>
            <nav class="shop-pages d-flex justify-content-between mt-3" aria-label="Page navigation">
                {{-- Previous --}}
                @if ($products->onFirstPage())
                <span class="btn-link d-inline-flex align-items-center text-muted">
                    <svg class="me-1" width="7" height="11">
                        <use href="#icon_prev_sm" />
                    </svg>
                    <span class="fw-medium">PREV</span>
                </span>
                @else
                <a href="{{ $products->previousPageUrl() }}" class="btn-link d-inline-flex align-items-center">
                    <svg class="me-1" width="7" height="11">
                        <use href="#icon_prev_sm" />
                    </svg>
                    <span class="fw-medium">PREV</span>
                </a>
                @endif
                {{-- Page Numbers --}}
                <ul class="pagination mb-0">
                    @foreach ($products->links()->elements[0] as $page => $url)
                    <li class="page-item">
                        <a href="{{ $url }}"
                            class="btn-link px-1 mx-2 {{ $products->currentPage() == $page ? 'btn-link_active' : '' }}">
                            {{ $page }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                {{-- Next --}}
                @if ($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" class="btn-link d-inline-flex align-items-center">
                    <span class="fw-medium me-1">NEXT</span>
                    <svg width="7" height="11">
                        <use href="#icon_next_sm" />
                    </svg>
                </a>
                @else
                <span class="btn-link d-inline-flex align-items-center text-muted">
                    <span class="fw-medium me-1">NEXT</span>
                    <svg width="7" height="11">
                        <use href="#icon_next_sm" />
                    </svg>
                </span>
                @endif
            </nav>

        </div>
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
        // Initialize main Swiper
        const swiperEl = document.querySelector('.js-swiper-slider');
        const swiper = new Swiper(swiperEl, {
            autoplay: {
                delay: 5000
            }
            , slidesPerView: 1
            , effect: 'fade'
            , loop: true
            , pagination: {
                el: '.slideshow-pagination'
                , type: 'bullets'
                , clickable: true
            }
        });

        // Slide to selected category
        const selectedCategoryId = "{{ request('with') }}";
        if (selectedCategoryId) {
            const slides = swiperEl.querySelectorAll(
                '.swiper-slide:not(.swiper-slide-duplicate)'); // ignore duplicates
            slides.forEach((slide, index) => {
                const link = slide.querySelector('a');
                if (link && link.href.includes('with=' + selectedCategoryId)) {
                    swiper.slideToLoop(index, 0); // instantly jump to correct slide
                }
            });
        }
    });


    document.addEventListener('DOMContentLoaded', function() {
        const sortSelect = document.getElementById('sortSelect');
        sortSelect.addEventListener('change', function() {
            const selected = this.value;
            const url = new URL(window.location.href);
            if (selected) {
                url.searchParams.set('sort', selected);
            } else {
                url.searchParams.delete('sort');
            }
            window.location.href = url.toString();
        });
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
                })
                .catch(err => console.error('Error fetching variants:', err));
        });
    });

</script>


@endsection
