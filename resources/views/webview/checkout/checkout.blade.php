@php
$coupon = session('coupon'); // gets the applied coupon as array
@endphp

@extends('layouts.app')

@section('container')
<main class="pt-90">
    <style>
        #payment_options {
            width: 300px;
            padding: 10px;
            font-size: 16px;
        }

        .text-success {
            color: green !important;
        }

        .text-danger {
            color: red !important;
        }
    </style>


    <section class="shop-checkout container">
        <h2 class="page-title">Shipping and Checkout</h2>

        {{-- Checkout Steps --}}
        <div class="checkout-steps">
            <a href="javascript:void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title"><span>Shipping</span><em>Full Fill Your Shipping
                        Details</em></span>
            </a>
            <a href="javascript:void(0)" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title"><span>Shipping and Checkout</span><em>Checkout Your Items
                        List</em></span>
            </a>
            <a href="javascript:void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">04</span>
                <span class="checkout-steps__item-title"><span>Confirmation</span><em>Review And Submit Your
                        Order</em></span>
            </a>
        </div>

        <form name="checkout-form" action="{{ route('place.order') }}" method="POST">
            @csrf
            <div class="checkout-form">
                {{-- SHIPPING DETAILS --}}
                <div class="billing-info__wrapper">
                    <h4>SHIPPING DETAILS</h4>
                    <div class="row mt-5">
                        {{-- Name --}}
                        <div class="col-md-6">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $address->name ?? ($user->name ?? '')) }}" readonly>
                                <label for="name">Full Name *</label>
                            </div>
                        </div>
                        {{-- Email --}}
                        <div class="col-md-6">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="email"
                                    value="{{ old('email', $address->email ?? ($user->email ?? '')) }}" readonly>
                                <label for="email">Email</label>
                            </div>
                        </div>
                        {{-- Phone --}}
                        <div class="col-md-6">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="mobile_num"
                                    value="{{ old('mobile_num', $address->mobile_num ?? ($user->mobile_num ?? '')) }}"
                                    readonly>
                                <label for="mobile_num">Phone Number</label>
                            </div>
                        </div>
                        {{-- State / District / Town --}}
                        <div class="col-md-4">
                            <div class="form-floating my-3">
                                <select class="form-control" id="province" name="province" required>
                                    <option value="">------Select Province-----</option>
                                </select>
                                <label for="province">Province *</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating my-3">
                                <select class="form-control" id="district" name="district" required>
                                    <option value="">-------Select District-----</option>
                                </select>
                                <label for="district">District *</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating my-3">
                                <select class="form-control" id="local_level" name="local_level" required>
                                    <option value="">----Select Local Level----</option>
                                </select>
                                <label for="local_level">Local Level *</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" id="local_level_type" name="local_level_type"
                                    value="{{ old('local_level_type', $address->local_level_type ?? '') }}" required>
                                <label for="local_level_type">Local Level Type *</label>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="road_area_colony"
                                    value="{{ old('road_area_colony', $address->road_area_colony ?? '') }}" required>
                                <label for="road_area_colony">Road Name, Area, Colony *</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="landmark"
                                    value="{{ old('landmark', $address->landmark ?? '') }}">
                                <label for="landmark">Landmark</label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ORDER SUMMARY --}}
                <div class="checkout__totals-wrapper mt-4">

                    <div class="checkout__totals">
                        <h3>Your Order</h3>
                        <table class="cart-totals">
                            <tbody>
                                <tr>
                                    <th>Subtotal</th>
                                    <td>Rs{{ number_format($subtotal, 2) }}</td>
                                </tr>
                                @if ($coupon)
                                <tr>
                                    <th>Discount ({{ $coupon['code'] }})</th>
                                    <td>Rs{{ number_format($coupon['discount'], 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Subtotal After Discount</th>
                                    <td>Rs{{ number_format($subtotalAfterDiscount, 2) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>VAT (13%)</th>
                                    <td>Rs{{ number_format($vat, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td><strong>Rs{{ number_format($total, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-3">
                            @if ($coupon)
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $coupon['code'] }} (Applied)"
                                    readonly>
                                <button type="button" id="remove_coupon" class="btn btn-outline-danger">Remove</button>
                            </div>
                            @else
                            <div class="input-group">
                                <input type="text" name="code" id="coupon_code" class="form-control"
                                    placeholder="Enter Coupon Code">
                                <button type="button" id="apply_coupon" class="btn btn-outline-success">Apply</button>
                            </div>
                            @endif
                        </div>

                    </div>
                    {{-- PAYMENT METHODS --}}
                    <div class="checkout__payment-methods mt-4">
                        <h2>Choose Payment Type</h2>
                        <div id="payment-error" style="color:red; margin-top:10px; font-weight:500;"></div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mode" value="bank" id="mode1">
                            <label class="form-check-label" for="mode1">Direct Bank Transfer</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mode" value="COD" id="mode2">
                            <label class="form-check-label" for="mode2">Cash on Delivery</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mode" value="Wallet" id="select">
                            <label class="form-check-label" for="select">Wallet Payment</label>
                        </div>

                        <div id="wallet-options" style="display:none; margin-top:15px;">
                            <label for="payment_options" class="form-label">Select Wallet</label>
                            <select id="payment_options" class="form-select" name="wallet_mode">
                                <option value="0">-- Select Payment Method --</option>
                                <option value="e-sewa">E-Sewa</option>
                                <option value="khalti">Khalti</option>
                                <option value="nepal-pay">NepalPay</option>
                                <option value="namaste-pay">Namaste Pay</option>
                            </select>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-checkout mt-4">PLACE ORDER</button>
                </div>
            </div>
        </form>
    </section>


</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
            const walletRadioButton = document.getElementById('select');
            const walletOptions = document.getElementById('wallet-options');
            const paymentOptions = document.getElementById('payment_options');
            const placeOrderButton = document.querySelector('.btn-checkout');
            const errorContainer = document.getElementById('payment-error');

            function toggleWalletOptions() {
                walletOptions.style.display = walletRadioButton.checked ? 'block' : 'none';
                if (!walletRadioButton.checked) paymentOptions.value = "0";
                errorContainer.textContent = '';
            }

            document.querySelectorAll('input[name="mode"]').forEach(radio => {
                radio.addEventListener('change', toggleWalletOptions);
            });

            placeOrderButton.addEventListener('click', function(event) {
                errorContainer.textContent = '';
                const selectedMode = document.querySelector('input[name="mode"]:checked');
                if (!selectedMode) {
                    event.preventDefault();
                    errorContainer.textContent = " Please select a payment method.";
                    return;
                }
                if (walletRadioButton.checked && paymentOptions.value === "0") {
                    event.preventDefault();
                    errorContainer.textContent = "Please select a valid wallet.";
                }
            });

            toggleWalletOptions();
        });


        document.addEventListener('DOMContentLoaded', function() {
    const checkoutForm = document.querySelector('form[name="checkout-form"]');

    // Apply coupon
    const applyBtn = document.getElementById('apply_coupon');
    if (applyBtn) {
        applyBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const codeInput = document.getElementById('coupon_code');

            // Temporarily change form action to coupon apply route
            const originalAction = checkoutForm.action;
            checkoutForm.action = "{{ route('cart.coupon.apply') }}";
            checkoutForm.submit();
            checkoutForm.action = originalAction; // restore after reload
        });
    }

    // Remove coupon
    const removeBtn = document.getElementById('remove_coupon');
    if (removeBtn) {
        removeBtn.addEventListener('click', function(e) {
            e.preventDefault();

            // Temporarily change form action to coupon remove route
            const originalAction = checkoutForm.action;
            checkoutForm.action = "{{ route('cart.coupon.remove') }}";
            checkoutForm.method = "POST";

            // Add hidden _method input for DELETE
            let methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            checkoutForm.appendChild(methodInput);

            checkoutForm.submit();
            checkoutForm.action = originalAction;
        });
    }
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    let provinces = [], districts = [], local_levels = [], local_level_types = [];

    // Old or DB values
    const oldProvince = "{{ old('province', $address->province ?? '') }}";
    const oldDistrict = "{{ old('district', $address->district ?? '') }}";
    const oldLocalLevel = "{{ old('local_level', $address->local_level ?? '') }}";

    // Load JSON
    $.getJSON('/assets/data/provinces.json', data => { provinces = data; populateProvinces(); });
    $.getJSON('/assets/data/districts.json', data => { districts = data; });
    $.getJSON('/assets/data/local_levels.json', data => { local_levels = data; });
    $.getJSON('/assets/data/local_level_type.json', data => { local_level_types = data; });

    function populateProvinces() {
        provinces.forEach(p => {
            const selected = p.name === oldProvince ? 'selected' : '';
            $('#province').append(`<option value="${p.name}" ${selected}>${p.name}</option>`);
        });
        if (oldProvince) populateDistricts(oldProvince);
    }

    function populateDistricts(province_name) {
        $('#district').html('<option value="">-------Select District-----</option>');
        districts.filter(d => provinces.find(p => p.province_id === d.province_id).name === province_name)
                 .forEach(d => {
                     const selected = d.name === oldDistrict ? 'selected' : '';
                     $('#district').append(`<option value="${d.name}" ${selected}>${d.name}</option>`);
                 });
        if (oldDistrict) populateLocalLevels(oldDistrict);
    }

    function populateLocalLevels(district_name) {
        $('#local_level').html('<option value="">----Select Local Level----</option>');
        local_levels.filter(l => districts.find(d => d.district_id === l.district_id).name === district_name)
                    .forEach(l => {
                        const selected = l.name === oldLocalLevel ? 'selected' : '';
                        $('#local_level').append(`<option value="${l.name}" data-type-id="${l.local_level_type_id}" ${selected}>${l.name}</option>`);
                    });
        if (oldLocalLevel) {
            const type_id = $('#local_level option:selected').data('type-id');
            populateLocalLevelType(type_id);
        }
    }

    function populateLocalLevelType(type_id) {
        const type = local_level_types.find(t => t.local_level_type_id == type_id);
        $('#local_level_type').val(type ? type.name : '');
    }

    // Event listeners
    $('#province').change(function() {
        const province_name = $(this).val();
        if (province_name) populateDistricts(province_name);
        else {
            $('#district').html('<option value="">-------Select District-----</option>');
            $('#local_level').html('<option value="">----Select Local Level----</option>');
            $('#local_level_type').val('');
        }
    });

    $('#district').change(function() {
        const district_name = $(this).val();
        if (district_name) populateLocalLevels(district_name);
        else {
            $('#local_level').html('<option value="">----Select Local Level----</option>');
            $('#local_level_type').val('');
        }
    });

    $('#local_level').change(function() {
        const type_id = $('#local_level option:selected').data('type-id');
        if (type_id) populateLocalLevelType(type_id);
        else $('#local_level_type').val('');
    });
});


</script>

@endsection
