@extends('layouts.main')

@section('title', 'Online Shop | Shopping Cart')

@section('content')
<section>
    <div class="box">
        <div class="box-title">
            <h2>Shopping Cart</h2>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">Your Order</div>

                    <div class="card-body">
                        <p class="text-center">Tu carrito de compras está vacío.</p>
                    </div>

                    <div class="card-footer text-center">
                        <a href="{{ url('/welcome') }}" class="btn btn-secondary">Continuar comprando</a>
                        <a href="/" class="btn btn-success">Realizar compra</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

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