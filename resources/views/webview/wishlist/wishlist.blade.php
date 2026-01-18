@extends('layouts.app')
@section('container')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
        <h2 class="page-title">Wish List</h2>
        <div class="checkout-steps">
            <a href="javascript:void(0)" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Wish List</span>
                    <em>Manage Your Wish Item</em>
                </span>
            </a>
            <a href="{{ url('/checkout') }}" class="checkout-steps__item">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title">
                    <span>Shipping and Checkout</span>
                    <em>Enter Shipping Details</em>
                </span>
            </a>
            <a href="javascript:void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Confirmation</span>
                    <em>Review and Submit Your Order</em>
                </span>
            </a>
        </div>

        <div class="shopping-cart">
            @if ($buyItem->count() > 0)
            <div class="cart-table__wrapper">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Product</th>
                            <th></th>
                            <th style="padding-left: 5px; padding-right: 5px;">Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($buyItem as $item)
                        <tr data-row-id="{{ $item->id }}" data-product-id="{{ $item->product->id }}">
                            <td>
                                <input type="checkbox" class="item-checkbox" data-price="{{ $item->price }}"
                                    data-quantity="{{ $item->quantity }}">
                            </td>
                            <td>
                                <div class="shopping-cart__product-item">
                                    <img loading="lazy" src="{{ asset('storage/' . $item->product->image) }}"
                                        width="120" height="120" alt="{{ $item->product->name }}">
                                </div>
                            </td>
                            <td>
                                <div class="shopping-cart__product-item__detail">
                                    <h4>{{ $item->product->name }}</h4>
                                    <ul class="shopping-cart__product-item__options">
                                        <li>Color: {{ $item->color }}</li>
                                        <li>Size: {{ $item->size }}</li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <span class="shopping-cart__product-price"
                                    data-price="{{ $item->product->sale_price ?? $item->product->regular_price }}">
                                    Rs{{ $item->product->sale_price ?? $item->product->regular_price }}
                                </span>
                            </td>
                            <td>
                                <div class="qty-control position-relative">
                                    <form action="{{ route('buy.qty.decrease', ['rowId' => $item->id]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <div class="qty-control__reduce">-</div>
                                    </form>

                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                        class="qty-control__number text-center" readonly>

                                    <form action="{{ route('buy.qty.increase', ['rowId' => $item->id]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <div class="qty-control__increase">+</div>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <span class="shopping-cart__subtotal">
                                    Rs{{ ($item->product->sale_price ?? $item->product->regular_price) * $item->quantity
                                    }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('remove.wise', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="cart-table-footer">
                    <form action="{{ route('empty.wise') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-light">CLEAR WISH</button>
                    </form>
                </div>
            </div>

            <div class="shopping-cart__totals-wrapper">
                <div class="sticky-content">
                    <div class="shopping-cart__totals">
                        <h3>Item Totals</h3>
                        <table class="cart-totals">
                            <tbody>
                                <tr>
                                    <th>Subtotal (<span id="selected-items-count">{{ $buyItem->sum('quantity') }}</span>
                                        items)</th>
                                    <td id="selected-items-total">
                                        Rs{{ number_format($buyItem->sum(fn($i) => $i->price * $i->quantity), 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td id="total-amount">
                                        Rs{{ number_format($buyItem->sum(fn($i) => $i->price * $i->quantity), 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mobile_fixed-btn_wrapper">
                        <div class="button-wrapper container">
                            <form id="checkout-form" action="{{ route('checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-checkout">
                                    PROCEED TO CHECKOUT
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md text-center pt-5 pb-5">
                    <p>No Items Found in Your Wish</p>
                    <a href="{{ url('/shop/all') }}" class="btn btn-info">Shop Now</a>
                </div>
            </div>
            @endif
        </div>
    </section>
    ```

</main>
@endsection

@push('scripts')

<script>
    $(function () {
        // Increase or decrease quantity
        $(".qty-control__increase, .qty-control__reduce").on("click", function (e) {
            e.preventDefault();

            let form = $(this).closest('form');
            let row = form.closest('tr');
            let qtyInput = row.find('.qty-control__number');
            let isIncrease = $(this).hasClass('qty-control__increase');
            let currentQty = parseInt(qtyInput.val());
            let newQty = isIncrease ? currentQty + 1 : Math.max(1, currentQty - 1);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize() + '&quantity=' + newQty,
                success: function (response) {
                    qtyInput.val(response.quantity);
                    row.find('.shopping-cart__subtotal').text('Rs' + response.subtotal.toFixed(2));
                    row.find('.item-checkbox').data('quantity', response.quantity);
                    updateTotal();
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Update totals
        function updateTotal() {
            let total = 0;
            let selectedCount = 0;

            $('.item-checkbox:checked').each(function () {
                let price = parseFloat($(this).data('price'));
                let quantity = parseInt($(this).data('quantity'));
                total += price * quantity;
                selectedCount += quantity;
            });

            $('#selected-items-total').text('Rs' + total.toFixed(2));
            $('#selected-items-count').text(selectedCount);
            $('#total-amount').text('Rs' + total.toFixed(2));
        }

        // Checkbox selection
        $('#select-all').on('change', function () {
            $('.item-checkbox').prop('checked', this.checked);
            updateTotal();
        });

      $('.item-checkbox, #select-all').on('change', function() {
    $('#select-all').prop('checked', $('.item-checkbox:checked').length === $('.item-checkbox').length);
    updateTotal();

    // Remove checkout error if at least one item is selected
    if ($('.item-checkbox:checked').length > 0) {
        $('.checkout-error').fadeOut(200, function() {
            $(this).remove();
        });
    }
});


$('#checkout-form').on('submit', function(e) {
    e.preventDefault(); // prevent default submit first

    let form = $(this);
    form.find('input[name="items[]"]').remove();
    $('.checkout-error').remove();

    $('.item-checkbox:checked').each(function() {
        let rowId = $(this).closest('tr').data('row-id');
        form.append('<input type="hidden" name="items[]" value="' + rowId + '">');
    });

    if ($('.item-checkbox:checked').length === 0) {
        $('<div class="checkout-error  mt-3" style="color:red; font-weight: 500; text-align: center;">Please select at least one item to checkout.</div>')
            .insertBefore(form);
        return;
    }
    this.submit();
});

        // Initial total calculation
        updateTotal();
    });
</script>

@endpush
