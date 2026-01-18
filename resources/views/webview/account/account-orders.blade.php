@extends('layouts.app')

@section('container')
<main class="pt-90" style="padding-top: 0px;">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Orders</h2>
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
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 80px">OrderNo</th>
                                    <th>Name</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Subtotal</th>
                                    <th class="text-center">Tax</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Order Date</th>
                                    <th class="text-center">Items</th>
                                    <th class="text-center">Delivered On</th>
                                    <th class="text-center">Action</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                    @foreach($orders as $order)
                                    <tr>
                                        <td class="text-center">{{ $order->id }}</td>
                                        <td>{{ $order->name }}</td>
                                        <td class="text-center">{{ $order->mobile_num }}</td>
                                        <td class="text-center">Rs {{ number_format($order->subtotal, 2) }}</td>
                                        <td class="text-center">Rs {{ number_format($order->tax, 2) }}</td>
                                        <td class="text-center">Rs {{ number_format($order->total, 2) }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $order->status == 'Canceled' ? 'bg-danger' : ($order->status == 'Ordered' ? 'bg-warning' : 'bg-success') }}">{{ $order->status }}</span>
                                        </td>
                                        <td class="text-center">{{ $order->created_at }}</td>
                                        <td class="text-center">{{ $order->items->count() }}</td>
                                        <td class="text-center">{{ $order->delivered_on ?? '' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('account.orders.details', ['id' => $order->id]) }}">
                                                <div class="list-icon-function view-icon">
                                                    <div class="item eye">
                                                        <i class="fa fa-eye"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination"></div>
            </div>

        </div>
    </section>
</main>

@endsection



