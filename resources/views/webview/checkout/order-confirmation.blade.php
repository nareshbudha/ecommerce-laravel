@extends('layouts.app')

@section('container')

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
        <h2 class="page-title">Order Received</h2>

```
    <!-- Checkout Steps -->
    <div class="checkout-steps">
        <a href="javascript:void(0)" class="checkout-steps__item">Step 1</a>
        <a href="javascript:void(0)" class="checkout-steps__item">Step 2</a>
        <a href="javascript:void(0)" class="checkout-steps__item active">Step 3</a>
    </div>

    <!-- Order Complete Section -->
    <div class="order-complete">
        <div class="order-complete__message">
            <svg width="80" height="80"></svg>
            <h3>Your order is completed!</h3>
            <p>Thank you. Your order has been received.</p>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('order.pdf', $order->id) }}" class="btn btn-primary">
                Download PDF Of Order Details
            </a>
        </div>

        <!-- Order Info -->
        <div class="order-info">
            <div class="order-info__item"><label>Order Number</label><span>{{ $order->id }}</span></div>
            <div class="order-info__item"><label>Date</label><span>{{ $order->created_at }}</span></div>
            <div class="order-info__item"><label>Total</label><span>Rs {{ number_format($order->total, 2) }}</span></div>
            <div class="order-info__item"><label>Payment Method</label><span>
                    @if($order->transaction->mode === 'wallet')
                    {{ $order->transaction->wallet_mode }}
                    @else
                    {{ $order->transaction->mode }}
                    @endif
                </span></div>
        </div>

        <!-- Order Details -->
        <div class="checkout__totals-wrapper">
            <div class="checkout__totals">
                <h3>Order Details</h3>
                <table class="checkout-cart-items">
                    <thead>
                        <tr>
                            <th>PRODUCT</th>
                            <th>SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item )
                        <tr>
                            <td>{{ $item->product->name }} x {{ $item->quantity }}</td>
                            <td class="text-right">Rs {{ $item->price }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <table class="checkout-totals">
                    <tbody>
                        <tr>
                            <th>SUBTOTAL</th>
                            <td class="text-right">{{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <th>DISCOUNT</th>
                            <td class="text-right">{{ number_format($order->discount , 2) }}</td>
                        </tr>
                        <tr>
                            <th>SHIPPING</th>
                            <td class="text-right">Free shipping</td>
                        </tr>
                        <tr>
                            <th>VAT</th>
                            <td class="text-right">{{ number_format($order->tax, 2) }}</td>
                        </tr>
                        <tr>
                            <th>TOTAL</th>
                            <td class="text-right"> {{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Leave a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach($order->orderItems as $item)
                <div class="product-single__review-form mb-4">
                    <form method="POST" action="{{ route('reviews.store', $item->product->id) }}">
                        @csrf
                        <h5>Review for “{{ $item->product->name }}”</h5>
                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                        <select name="rating" class="form-control form-control_gray" required>
                            <option value="">Select rating</option>
                            <option value="5">★★★★★ (5)</option>
                            <option value="4">★★★★☆ (4)</option>
                            <option value="3">★★★☆☆ (3)</option>
                            <option value="2">★★☆☆☆ (2)</option>
                            <option value="1">★☆☆☆☆ (1)</option>
                        </select>
                        <textarea name="comment" class="form-control form-control_gray mt-3"
                            placeholder="Your Review" rows="4" required></textarea>
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
```

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reviewModalEl = document.getElementById('reviewModal');
    const orderId = "{{ $order->id }}";

    if (!reviewModalEl || localStorage.getItem('reviewSubmitted_' + orderId)) return;

    const reviewModal = new bootstrap.Modal(reviewModalEl);
    reviewModal.show();

    const forms = reviewModalEl.querySelectorAll('form');
    let submittedForms = 0;
    const totalForms = forms.length;

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);
            const productName = form.querySelector('h5').innerText.replace('Review for “','').replace('”','');

            // Show thank-you message
            const thankYouMsg = document.createElement('div');
            thankYouMsg.classList.add('alert', 'alert-success', 'mt-3');
            thankYouMsg.innerText = `Thank you for reviewing "${productName}"!`;

            form.parentNode.innerHTML = '';
            form.parentNode.appendChild(thankYouMsg);

            // Send POST request via fetch
            fetch(form.action, { method: 'POST', body: formData })
                .then(response => {
                    if (!response.ok) console.error('Failed to submit review for', productName);
                }).catch(err => console.error(err));

            submittedForms++;
            if (submittedForms === totalForms) {
                localStorage.setItem('reviewSubmitted_' + orderId, 'true');
            }
        });
    });
});
</script>

@endsection
