@php
$coupon = session('coupon');
@endphp
@extends('layouts.app')

@section('container')

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
        <h2 class="page-title">Buy Now</h2>
        <div class="checkout-steps">
            <a href="javascript:void(0)" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Buy Now</span>
                    <em>Confirm Your Selected Item</em>
                </span>
            </a>

            <a href="javascript:void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Shipping and Checkout</span>
                    <em>Checkout Your Items List</em>
                </span>
            </a>

            <a href="javascript:void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">04</span>
                <span class="checkout-steps__item-title">
                    <span>Confirmation</span>
                    <em>Review and Submit Your Order</em>
                </span>
            </a>
        </div>

        <div class="shopping-cart">
            <div class="cart-table__wrapper">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th></th>
                            <th style="padding-left: 5px; padding-right: 5px;">Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr data-product-id="{{ $buyItem->id }}">
                            <td>
                                <div class="shopping-cart__product-item">
                                    <img loading="lazy" src="{{ asset('storage/' . $buyItem->image) }}" width="120"
                                        height="120" alt="{{ $buyItem->name }}">
                                </div>
                            </td>
                            <td>
                                <div class="shopping-cart__product-item__detail">
                                    <h4>{{ $buyItem->name }}</h4>
                                    <ul class="shopping-cart__product-item__options">
                                        <li>Color: {{ $buyItem->color }}</li>
                                        <li>Size: {{ $buyItem->size }}</li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <span class="shopping-cart__product-price" data-price="{{ $buyItem->price }}">
                                    Rs{{ $buyItem->price }}
                                </span>
                            </td>
                            <td>
                                <div class="qty-control position-relative">
                                    <form action="{{ route('buy.qty.decrease', ['rowId' => $buyItem->id]) }}"
                                        method="POST" class="qty-form">
                                        @csrf
                                        @method('PUT')
                                        <div class="qty-control__reduce">-</div>
                                    </form>

                                    <input type="number" name="quantity_display" value="{{ $buyItem->quantity }}"
                                        min="1" class="qty-control__number text-center" readonly>

                                    <form action="{{ route('buy.qty.increase', ['rowId' => $buyItem->id]) }}"
                                        method="POST" class="qty-form">
                                        @csrf
                                        @method('PUT')
                                        <div class="qty-control__increase">+</div>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <span class="shopping-cart__subtotal row-subtotal">
                                    Rs{{ number_format($buyItem->price * $buyItem->quantity, 2) }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="shopping-cart__totals-wrapper">
                <div class="sticky-content">
                    <div class="shopping-cart__totals">
                        <h3>Item Totals</h3>
                        <table class="cart-totals">
                            <tbody>
                                <tr>
                                    <th>Subtotal ({{ $buyItem->quantity }} item{{ $buyItem->quantity > 1 ? 's' : '' }})
                                    </th>
                                    <td id="selected-items-total">Rs{{ number_format($buyItem->price *
                                        $buyItem->quantity, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td><span class="shopping-cart__total total">Rs0.00</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mobile_fixed-btn_wrapper">
                        <div class="button-wrapper container">
                            <a href="/checkout" class="btn btn-primary btn-checkout">PROCEED TO CHECKOUT</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</main>
@endsection

@push('scripts')

<script>
    function updateCartTotals() {
    let total = 0;
    $("tr[data-product-id]").each(function() {
        const price = parseFloat($(this).find(".shopping-cart__product-price").data("price"));
        const quantity = parseInt($(this).find(".qty-control__number").val());
        const subtotal = price * quantity;
        $(this).find(".row-subtotal").text("Rs" + subtotal.toFixed(2));
        total += subtotal;
    });
    $(".shopping-cart__total.total").text("Rs" + total.toFixed(2));
    $("#selected-items-total").text("Rs" + total.toFixed(2));
}

$(".qty-control__increase, .qty-control__reduce").click(function(e) {
    e.preventDefault();
    const form = $(this).closest("form");
    const inputDisplay = $(this).closest(".qty-control").find(".qty-control__number");

    $.ajax({
        url: form.attr("action"),
        type: "PUT",
        data: {},
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(res) {
            if(res.success){
                inputDisplay.val(res.quantity);
                $(form).closest("tr").find(".row-subtotal").text("Rs" + res.subtotal.toFixed(2));
                updateCartTotals();
            } else {
                alert("Failed to update quantity.");
            }
        },
        error: function(err) {
            console.log(err);
            alert("AJAX failed.");
        }
    });
});

$(document).ready(function() {
    updateCartTotals();
});
</script>

@endpush
