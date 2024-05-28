@extends('layouts.main')

@section('title', 'Online Shop | Shopping Cart')

@section('content')
<div class="container">
    <h1>Your Shopping Cart</h1>
    @if (session('cart'))
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach (session('cart') as $product)
            <tr>
                <td>{{ $product['title'] }}</td>
                <td>{{ $product['price'] }}</td>
                <td>{{ $product['quantity'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Your cart is empty.</p>
    @endif
</div>
@endsection

@push('css')

<style>
    main {
        background: #ccc;
        background-attachment: fixed;
        width: 100%;
        height: 100vh;
        font-size: 62.5%;
    }

    .cs-title {
        font-size: 2rem;
        color: #333;
        font-weight: bold;
    }

    .box {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 170px;
        margin-top: 48px;

        .box-title {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ccc;
            width: 60%;
            height: 100px;
            border-radius: 50px;
            background: radial-gradient(ellipse at center, rgba(060, 160, 255, 1) 50%, transparent 75%);

            h2 {
                font-size: 5rem;
                font-weight: bolder;
                color: #fff;
            }
        }
    }

    .container {
        display: flex;
        align-content: center;
        align-items: center;
        justify-content: center;
        width: 500px;
        height: 100px;

        .card-header {
            font-size: 2rem;
        }
    }
</style>

@endpush