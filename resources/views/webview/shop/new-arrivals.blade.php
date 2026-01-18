@extends('layouts.app')

@section('container')
<main class="pt-90">
    @php
    $currentnewarrival = '/new-arrivals' ?? null;
    @endphp
    <section class="shop-main container d-flex pt-4 pt-xl-5">
        {{-- Sidebar Filters --}}
        <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
            {{-- Categories --}}
            <div class="accordion" id="categories-list">
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-1">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                            data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true"
                            aria-controls="accordion-filter-1">
                            Product Categories
                        </button>
                    </h5>
                    <div id="accordion-filter-1" class="border-0">
                        <div class="accordion-body px-0 pb-0 pt-3">
                            <ul class="list list-inline mb-0">
                                @foreach ($categories as $category)
                                @php
                                // Check if this category is active
                                $isActive = request('category') === $category->slug;

                                // Always include category in route params
                                $params = ['category' => $category->slug];
                                @endphp
                                <li class="list-item">
                                    <a href="{{ route('shop.new-arrivals', $params) }}"
                                        class="menu-link py-1 {{ $isActive ? 'fw-bold text-red' : '' }}">
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
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                            data-bs-toggle="collapse" data-bs-target="#accordion-filter-2" aria-expanded="true"
                            aria-controls="accordion-filter-2">
                            Product Sub Categories
                        </button>
                    </h5>
                    <div id="accordion-filter-2" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-2" data-bs-parent="#subcategories-list">
                        <div class="accordion-body px-0 pb-0 pt-3">
                            <ul class="list list-inline mb-0">
                                @foreach ($subcategories as $subcategory)
                                @php
                                $isActive = request('subcategory') === $subcategory->slug;
                                $params = ['subcategory' => $currentnewarrival];
                                if (!$isActive) {
                                $params['subcategory'] = $subcategory->slug;
                                }
                                @endphp
                                <li class="list-item">
                                    <a href="{{ route('shop.new-arrivals', $params) }}"
                                        class="menu-link py-1 {{ $isActive ? 'fw-bold text-red' : '' }}">
                                        {{ $subcategory->name }}
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
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                            data-bs-toggle="collapse" data-bs-target="#accordion-filter-color" aria-expanded="true"
                            aria-controls="accordion-filter-color">
                            Color
                        </button>
                    </h5>
                    <div id="accordion-filter-color" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-color" data-bs-parent="#color-filters">
                        <div class="accordion-body px-0 pb-0">
                            @php
                            $uniqueColors = collect($colors)->filter()->map(fn($c) => trim($c, '"'))->unique();
                            @endphp
                            <div class="d-flex flex-wrap">
                                @foreach ($uniqueColors as $color)
                                <div class="color-item text-center m-1">
                                    <a href="{{ url('/shop/new-arrivals?' . http_build_query(array_merge(request()->all(), ['color' => $color]))) }}"
                                        style="background-color: {{ $color }}; width: 20px; height: 20px; display: inline-block; border-radius: 50%; border: 1px solid #ccc;">
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
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                            data-bs-toggle="collapse" data-bs-target="#accordion-filter-size" aria-expanded="true"
                            aria-controls="accordion-filter-size">
                            Sizes
                        </button>
                    </h5>
                    <div id="accordion-filter-size" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-size" data-bs-parent="#size-filters">
                        <div class="accordion-body px-0 pb-0">
                            <div class="d-flex flex-wrap">
                                @foreach ($sizes as $size)
                                <a href="{{ url('/shop/new-arrivals?' . http_build_query(array_merge(request()->all(), ['size' => $size]))) }}"
                                    class="swatch-size btn btn-sm btn-outline-light mb-3 me-3">{{ $size }}</a>
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
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                            data-bs-toggle="collapse" data-bs-target="#accordion-filter-brand" aria-expanded="true"
                            aria-controls="accordion-filter-brand">
                            Brands
                        </button>
                    </h5>
                    <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
                        <div class="accordion-body px-0 pb-0 pt-3">
                            <ul class="list list-inline mb-0">
                                @foreach ($brands as $brand)
                                @php
                                $isActive = request('brand') === $brand->slug;
                                $params = ['brand' => $currentnewarrival];
                                if (!$isActive) {
                                $params['brand'] = $brand->slug;
                                }
                                @endphp
                                <li class="list-item">
                                    <a href="{{ route('shop.new-arrivals', $params) }}"
                                        class="menu-link py-1 {{ $isActive ? 'fw-bold text-red' : '' }}">
                                        {{ $brand->name }}
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
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                            data-bs-toggle="collapse" data-bs-target="#accordion-filter-price" aria-expanded="true"
                            aria-controls="accordion-filter-price">
                            Price <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                xmlns="http://www.w3.org/2000/svg">
                                <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                    <path
                                        d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                </g>
                            </svg>
                        </button>
                    </h5>
                    <div id="accordion-filter-price" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
                        <div
                            style="padding: 20px;border: 2px solid #662d91;border-radius: 10px;max-width: 400px;margin: 20px auto;background: #fff;box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                            <form method="GET" action="{{ route('shop.new-arrivals') }}"
                                style="display: flex; flex-direction: column; gap: 15px;">
                                <label for="min_price" style="font-weight: bold;">Minimum
                                    Price</label>
                                <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}"
                                    placeholder="Enter minimum price"
                                    style="padding: 10px;border: 1px solid #ccc;border-radius: 5px;font-size: 14px;width: 100%;box-sizing: border-box;">

                                <label for="max_price" style="font-weight: bold;">Maximum
                                    Price</label>
                                <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}"
                                    placeholder="Enter maximum price"
                                    style="padding: 10px;border: 1px solid #ccc;border-radius: 5px;font-size: 14px;width: 100%;box-sizing: border-box;">

                                <button type="submit" class="btn btn-sm btn-primary mt-2">Apply</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="shop-list flex-grow-1">
            <div class="d-flex justify-content-between mb-4 pb-md-2">
                <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                    <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                    <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                    <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
                </div>

                <div
                    class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                    <select id="sortSelect" class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0"
                        aria-label="Sort Items" name="sort">
                        <option value="" {{ request('sort')=='' ? 'selected' : '' }}>Default Sorting</option>
                        <option value="featured" {{ request('sort')=='featured' ? 'selected' : '' }}>Featured</option>
                        {{-- <option value="bestselling" {{ request('sort')=='bestselling' ? 'selected' : '' }}>Best
                            selling
                        </option> --}}
                        <option value="name_asc" {{ request('sort')=='name_asc' ? 'selected' : '' }}>Alphabetically, A-Z
                        </option>
                        <option value="name_desc" {{ request('sort')=='name_desc' ? 'selected' : '' }}>Alphabetically,
                            Z-A</option>
                        <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Price, High to
                            Low</option>
                        <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Price, Low to
                            High</option>
                        <option value="date_old" {{ request('sort')=='date_old' ? 'selected' : '' }}>Date, old to new
                        </option>
                        <option value="date_new" {{ request('sort')=='date_new' ? 'selected' : '' }}>Date, new to old
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
              <h2 class="section-title text-center mt-4">New Arrivals</h2>

            <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
                @if($products->count() > 0)
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
                                    <div class="swiper-slide" style="object-fit: contain;">
                                        @php
                                        $images = is_string($product->images)
                                        ? json_decode($product->images, true)
                                        : $product->images;
                                        $images = array_map(function ($image) {
                                        return str_replace('\\', '/', $image);
                                        }, $images ?? []);
                                        @endphp

                                        @if (!empty($images) && isset($images[0]))
                                        <a href="{{ route('product-detail', ['slug' => $product->slug]) }}">
                                            <img loading="lazy" src="{{ asset('storage/' . $images[0]) }}" width="330"
                                                height="400" alt="{{ $product->name }}" class="pc__img">
                                        </a>
                                        @else

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
                            @if (Cart::instance('cart')->content()->where('id', $product->id)->count() > 0)
                            <a href="{{ route('cart.index') }}"
                                class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium  btn-warning mb-3">Go
                                To Cart</a>
                            @else
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ $product->name }}">
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="quantity" value="1">
                                <!-- Assuming 1 quantity for now -->
                                <input type="hidden" name="price" value="{{ $product->sale_price }}">
                                <button type="submit"
                                    class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium"
                                    data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                            </form>
                            @endif

                        </div>

                        <div class="pc__info position-relative">
                            {{-- <p class="pc__category">{{ $product->category->name }}</p> --}}
                            <h6 class="pc__title">{{ $product->name }}</h6>
                            <p class="pc__brand">{{ $product->brand->name }}</p>
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
                                        {{ $productReviews->count() }} review{{ $productReviews->count() > 1 ? 's' : ''
                                        }}
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
        </div>
    </section>

    ?
</main>
<script>
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


</script>



@endsection
