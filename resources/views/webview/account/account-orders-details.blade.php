
@extends('layouts.app')
@section('container')
<main class="pt-90" style="padding-top: 0px;">

    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
      <h2 class="page-title">Order's Details</h2>
      <div class="row">
        <div class="col-lg-2">
            <ul class="account-nav">
                <li><a href="/my-account" class="checkout-steps__item menu-link menu-link_us-s">Dashboard</a></li>
                <li><a href="/account-details" class="checkout-steps__item menu-link menu-link_us-s active">Account Details</a></li>
                <li><a href="/account_order" class="checkout-steps__item menu-link menu-link_us-s">Orders</a></li>
                <li><a href="/account-wishlist" class="checkout-steps__item menu-link menu-link_us-s">Wishlist</a></li>
                <li><a href="/account_order" class="checkout-steps__item menu-link menu-link_us-s">Orders</a></li>
                <li><a href="{{ route('password.reset') }}" class="checkout-steps__item menu-link menu-link_us-s">Change Password</a></li>
            </ul>
        </div>

        <div class="col-lg-10">
          <div class="wg-box mt-5 mb-5">
            <div class="row">
              <div class="col-6">
                <h5>Ordered Details</h5>
              </div>
              <div class="col-6 text-right">
                <a class="btn btn-sm btn-danger" href="http://localhost:8000/account-orders">Back</a>
              </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-transaction">
                    <tbody>
                      <tr>
                        <th>Order No</th>
                        <td>{{ $order->id }}</td>
                        <th>Mobile</th>
                        <td>{{ $order->mobile_num }}</td>
                        <th>Pin/Zip Code</th>
                        <td>{{ $order->postal_code }}</td>
                      </tr>
                      <tr>
                        <th>Order Date</th>
                        <td>{{ $order->created_at }}</td>
                        <th>Delivered Date</th>
                        <td>{{ $order->delivered_date }}</td>
                        <th>Canceled Date</th>
                        <td>{{ $order->canceled_date }}</td>
                      </tr>
                      <tr>
                        <th>Order Status</th>
                        <td colspan="5">
                          @if($order->status == 'delivered')
                            <span class="badge bg-success">Delivered</span>
                          @elseif($order->status == 'canceled')
                            <span class="badge bg-danger">Canceled</span>
                          @else
                            <span class="badge bg-warning">Pending</span>
                          @endif
                        </td>
                      </tr>
                    </tbody>
                  </table>

            </div>
          </div>
          <div class="wg-box wg-table table-all-user">
            <div class="row">
              <div class="col-6">
                <h5>Ordered Items</h5>
              </div>
              <div class="col-6 text-right">

              </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">SKU</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Brand</th>

                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($orderItems as $item)
                        <tr>
                            <td class="text-center">{{ $item->product->name }}</td>
                          <td class="text-center">Rs {{ $item->price }}</td>
                          <td class="text-center">{{ $item->quantity }}</td>
                          <td class="text-center">{{ $item->product->sku }}</td>
                          <td class="text-center">
                            @if($item->product->category)
                              {{ $item->product->category->name }}
                            @else
                              N/A
                            @endif
                          </td>
                          <td class="text-center">
                            @if($item->product->brand)
                              {{ $item->product->brand->name }}
                            @else
                              N/A
                            @endif
                          </td>
                          <td class="text-center"></td>


                        </tr>
                      @endforeach
                    </tbody>
                  </table>

            </div>
          </div>
          <div class="divider"></div>
          <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

          </div>

          <div class="wg-box mt-5">
            <h5>Shipping Address</h5>
            <div class="my-account__address-item col-md-6">
              <div class="my-account__address-item__detail">
                <p><strong>Name:</strong> {{ $order->name }}</p>
                <p><strong>House No:</strong> {{ $order->house_no_building }}, {{ $order->road_area_colony }}</p>
                <p><strong>City:</strong> {{ $order->town_city }}, {{ $order->district }}</p>
                <p><strong>State:</strong> {{ $order->state }}</p>
                <p><strong>Pin/Zip Code:</strong> {{ $order->postal_code }}</p>
                <br>
                <p><strong>Mobile:</strong> {{ $order->mobile_num }}</p>
              </div>
            </div>
          </div>


          <div class="wg-box mt-5">
            <h5>Transactions</h5>
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-transaction">
                <tbody>
                  <tr>
                    <th>Subtotal</th>
                    <td>Rs {{ number_format($order->subtotal, 2) }}</td>
                    <th>Tax</th>
                    <td>Rs {{ number_format($order->tax, 2) }}</td>
                    <th>Discount</th>
                    <td>Rs {{ number_format($order->discount, 2) }}</td>
                  </tr>
                  <tr>
                    <th>Total</th>
                    <td>Rs {{ number_format($order->total, 2) }}</td>
                    <th>Payment Mode</th>
                    <td>{{ $transaction->mode }}</td>
                    <th>Status</th>
                    <td>{{ $transaction->status }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>


          <div class="wg-box mt-5 text-right">
            <form action="" method="POST">
              @csrf
              @method('PUT')
              <button type="submit" class="btn btn-danger">Cancel Order</button>
            </form>
          </div>

        </div>

      </div>
    </section>
  </main>


@endsection




