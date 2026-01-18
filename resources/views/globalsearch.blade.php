@extends('layouts.app')
@section('container')
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
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                            data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true"
                            aria-controls="accordion-filter-1">
                            Product Categories
                            <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                xmlns="http://www.w3.org/2000/svg">
                                <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                    <path
                                        d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                </g>
                            </svg>
                        </button>
                    </h5>
                    <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
                        <div class="accordion-body px-0 pb-0 pt-3">
                            <ul class="list list-inline mb-0">
                                @foreach($categories as $category)
                                <li class="list-item">
                                    <a href="{{ route('global.search', ['category' => $category->slug]) }}"
                                        class="menu-link py-1">{{ $category->name }}</a>
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
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button"
                            data-bs-toggle="collapse" data-bs-target="#accordion-filter-brand" aria-expanded="true"
                            aria-controls="accordion-filter-brand">
                            Brands
                            <svg class="accordion-button__icon type2" viewBox="0 0 10 6"
                                xmlns="http://www.w3.org/2000/svg">
                                <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                    <path
                                        d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                                </g>
                            </svg>
                        </button>
                    </h5>
                    <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0"
                        aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
                        <div class="accordion-body px-0 pb-0 pt-3">
                            <ul class="list list-inline mb-0">
                                @foreach($brands as $brand)
                                <li class="list-item">
                                    <a href="{{ route('global.search', ['brand' => $brand->slug]) }}"
                                        class="menu-link py-1">{{ $brand->name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="shop-list flex-grow-1">
            <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
                @if($productResults->isEmpty() && $categoryResults->isEmpty() && $brandResults->isEmpty() &&
                $userResults->isEmpty())
                <div class="no-products">
                    <p>No results found. Please try a different search term.</p>
                </div>
                @else
                @foreach($productResults as $product)
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


                @endif
            </div>


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
