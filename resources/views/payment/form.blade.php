@extends('layouts.app')
@section('container')
<main class="pt-90">

    <form action="{{ $esewaData['esewa_url']}}" method="POST" style="display: flex; flex-direction: column; gap: 15px; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); width: 400px; margin: auto;">
        <p>You will be redirected to your eSewa account to complete your payment:</p>
        <ul>
            <li>Login to your eSewa account using your eSewa ID and Password.</li>
            <li>Ensure your eSewa account is active and has sufficient balance.</li>
            <li>Enter the OTP (one-time password) sent to your registered mobile number.</li>
        </ul>
        <p>***Login with your eSewa mobile number and PASSWORD (not MPin).***</p>

        @csrf
        <input type="hidden" id="amount" name="amount" value="{{ $esewaData['amount'] }}" required>
        <input type="hidden" id="tax_amount" name="tax_amount" value="{{ $esewaData['tax_amount'] }}" required>
        <input type="hidden" id="total_amount" name="total_amount" value="{{ $esewaData['total_amount'] }}" required>
        <input type="hidden" id="transaction_uuid" name="transaction_uuid" value="{{ $esewaData['transaction_uuid'] }}" required> 
        <input type="hidden" id="product_code" name="product_code" value="{{ $esewaData['product_code'] }}" required>
        <input type="hidden" id="product_service_charge" name="product_service_charge" value="{{ $esewaData['product_service_charge'] }}" required>
        <input type="hidden" id="product_delivery_charge" name="product_delivery_charge" value="{{ $esewaData['product_delivery_charge'] }}" required>
        <input type="hidden" id="success_url" name="success_url" value="{{ $esewaData['success_url'] }}" required>
        <input type="hidden" id="failure_url" name="failure_url" value="{{ $esewaData['failure_url'] }}" required>
        <input type="hidden" id="signed_field_names" name="signed_field_names" value="{{$esewaData['signed_field_names']}}" required>
        <input type="hidden" id="signature" name="signature" value="{{$esewaData['signature']}}" required>

        <button type="submit" style="padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Pay Now</button>
    </form>

</main>
@endsection
