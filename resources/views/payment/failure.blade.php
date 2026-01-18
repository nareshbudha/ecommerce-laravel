@extends('layouts.app')
@section('container')
<main class="pt-90">
    <div style="display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background-color: #f8d7da;
    color: red;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <h2 style="color: white">Payment Failed</h2>
        <p>{{ $message ?? 'Your payment couldn’t be processed. Please try again.' }}</p>
        <a href="{{ route('cart.index') }}" style="color: #007bff; text-decoration: none;">Return to Cart</a>
    </div>
</main>
@endsection
