<!-- Page Wrapper -->
<div id="page" class="">
    <div class="layout-wrap">
        <!-- Sidebar Section -->
        @include('dashboard.components.sidebar')

        <!-- Main Content Area -->
        <div class="section-content-right">
            <!-- Header Section -->
            <div class="header-dashboard">
                @include('dashboard.components.navbar')
            </div>

            <!-- Main Content Section -->
            <div class="main-content">
                <div class="wg-box mt-5" style="max-width: 400px; margin: 20px auto; padding: 20px; background: #f8f9fa; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
                    <h5 style="text-align: center; color: #333; margin-bottom: 5px;">Update Order Status</h5>
                    <form action="{{ route('order.status.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label style="font-weight: bold; margin-bottom: 10px; color: #555; font-size: 1.5rem; display: flex; justify-content: center; align-items: center;">
                            Order Id: {{ $order->id }}
                        </label>

                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <div class="form-group" style="margin-bottom: 15px;">
                            <label style="font-weight: bold; color: #555; font-size: 1.5rem; margin-bottom: 10px; display: flex; justify-content: center; align-items: center;">
                                Status
                            </label>
                            <select name="status" id="status" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; background: #007bff; color: #fff; padding: 10px; border: none; border-radius: 4px; cursor: pointer; transition: 0.3s;">
                            Update Status
                        </button>
                    </form>
                </div>



                <div class="bottom-page">
                    <div class="body-text">Copyright © 2024 Spell E-Commerce</div>
                </div>
            </div>
        </div>
    </div>
</div>
