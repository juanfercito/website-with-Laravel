@extends('layouts.main')

@section('title', 'Online Shop | Shopping Cart')

@extends('layouts.main')

@section('title', 'Online Shop | Shopping Cart')

@section('content')
<div class="container">
    <div class="card">
        <h1>Your Shopping Cart</h1>
        <div class="card-body">
            @php
            $totalQuantity = 0;
            $subtotal = 0;

            foreach (session('cart', []) as $product) {
            $productTotal = isset($incomeDetails[$product['id']]) ? $product['quantity'] * $incomeDetails[$product['id']]->sale_price : 0;
            $subtotal += $productTotal;
            $totalQuantity += $product['quantity'];
            }

            $discount = 0;
            if ($totalQuantity >= 5 && $totalQuantity <= 10) { $discount=5; } elseif ($totalQuantity> 10 && $totalQuantity <= 20) { $discount=10; } elseif ($totalQuantity> 20) {
                    $discount = 15;
                    }

                    $discountAmount = ($subtotal * $discount) / 100;
                    $total = $subtotal - $discountAmount;
                    @endphp
                    <div class="row">
                        <h2 class="product-cant">Products: <span>{{ Cart::count() }}</span></h2>
                        <h2 class="discount-avg">Discount: <span>{{ $discount }}%</span></h2>
                    </div>
                    @if (session('cart'))
                    <div class="table-container">
                        <div class="row">
                            <div class="table-title">
                                <div class="remove-product">
                                    <p>Action</p>
                                </div>
                                <div class="description">
                                    <p>Description</p>
                                </div>
                                <div class="unit-price">
                                    <p>Unit Price</p>
                                </div>
                                <div class="cant">
                                    <p>Quantity</p>
                                </div>
                                <div class="total-price">
                                    <p>Total Price</p>
                                </div>
                            </div>
                        </div>

                        <div class="table-content">
                            @foreach (session('cart') as $product)
                            @php
                            $productTotal = isset($incomeDetails[$product['id']]) ? $product['quantity'] * $incomeDetails[$product['id']]->sale_price : 0;
                            @endphp
                            <div class="row">
                                <div class="table-product">
                                    <div class="remove-product">
                                        <form action="{{ route('cart.removeFromCart') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $product['id'] }}">
                                            <button type="submit" class="btn btn-danger">X</button>
                                        </form>
                                    </div>
                                    <div class="description">
                                        <p>{{ $product['title'] }}</p>
                                    </div>
                                    <div class="unit-price">
                                        <p>{{ isset($incomeDetails[$product['id']]) ? $incomeDetails[$product['id']]->sale_price : 'N/A' }}</p>
                                    </div>
                                    <div class="cant">
                                        <p>{{ $product['quantity'] }}</p>
                                    </div>
                                    <div class="total-price">
                                        <p>{{ number_format(isset($incomeDetails[$product['id']]) ? $product['quantity'] * $incomeDetails[$product['id']]->sale_price : 'N/A', 2) }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center">
                            <a href="/" class="btn btn-primary">Empty. Add a Product</a>
                        </div>
                        @endif
                    </div>
                    <div class="table-totals">
                        <div class="row">
                            <div class="titles">
                                <div class="subtotal">
                                    <p>SUBTOTAL</p>
                                </div>
                                <div class="discount">
                                    <p>DISCOUNT</p>
                                </div>
                                <div class="total">
                                    <p>TOTAL</p>
                                </div>
                            </div>
                            <div class="values">
                                <div class="subtotal">
                                    <p>{{ number_format($subtotal, 2) }}</p>
                                </div>
                                <div class="discount">
                                    <p>{{ number_format($discountAmount, 2) }}</p>
                                </div>
                                <div class="total">
                                    <p>{{ number_format($total, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .container {
        display: flex;
        align-items: flex-start;
        justify-content: center;
        width: 100%;
        height: 100vh;
        font-size: 62.5%;
        background: linear-gradient(to bottom, #4299E1, #1b2029, #4299E1);
    }

    h1 {
        font-size: 3rem;
        margin-bottom: 20px;
        color: white;
    }

    h2 {
        font-size: 2rem;
        padding-bottom: 10px;
        color: white;

        span {
            font-size: 2rem;
            margin-left: 10px;
            color: white;
        }
    }

    .card {
        width: 90%;

        .card-body {
            .row {
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;

                .product-cant {
                    padding-left: 6px;
                }

                .discount-avg {
                    padding-right: 6px;
                }
            }
        }
    }

    .table-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        background-color: #4299E1;
        padding: 4px;
        border-radius: 10px 10px 0 10px;
        ;

        .row {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            width: 100%;

            .table-title {
                display: flex;
                align-items: start;
                justify-content: center;
                width: 100%;
                height: 40px;
                border-bottom: 1px solid #aaa;

                p {
                    font-size: 1.6rem;
                }

                .remove-product {
                    width: 10%;
                    display: flex;
                    justify-content: center;
                    height: 100%;
                    font-weight: bold;
                    color: white;
                    border-right: 2px solid #ccc;
                    margin-left: 3px;
                }

                .description {
                    display: flex;
                    justify-content: center;
                    width: 45%;
                    height: 100%;
                    font-weight: bold;
                    color: white;
                    border-right: 2px solid #ccc;
                }

                .unit-price {
                    display: flex;
                    justify-content: center;
                    width: 15%;
                    height: 100%;
                    font-weight: bold;
                    color: white;
                    border-right: 2px solid #ccc;
                }

                .cant {
                    display: flex;
                    justify-content: center;
                    width: 15%;
                    height: 100%;
                    font-weight: bold;
                    color: white;
                    border-right: 2px solid #ccc;
                }

                .total-price {
                    display: flex;
                    justify-content: center;
                    width: 15%;
                    height: 100%;
                    font-weight: bold;
                    color: white;
                }
            }
        }
    }

    .table-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        background-color: #444;
        padding: 4px;
        border-top: 4px solid #1b2029;
        border-radius: 0 0 0 10px;

        .row {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            width: 100%;

            .table-product {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 40px;

                p {
                    font-size: 1.6rem;
                }

                .remove-product {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 10%;
                    height: 100%;
                    font-weight: bold;
                    color: white;
                    border-right: 2px solid #ccc;
                    padding: 0 auto;
                    margin: 0 auto;

                    .btn {
                        width: 55px;
                        height: 35px;
                        font-size: 1.6rem;
                        background-color: goldenrod;
                        color: white;
                        font-weight: bold;
                        border-radius: 8px;
                    }

                    .btn:hover {
                        cursor: pointer;
                        background-color: crimson;
                    }
                }

                .description {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 45%;
                    height: 100%;
                    font-weight: bold;
                    color: white;
                    border-right: 2px solid #ccc;
                }

                .unit-price {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 15%;
                    height: 100%;
                    font-weight: bold;
                    color: white;
                    border-right: 2px solid #ccc;
                    margin-right: -2px;
                }

                .cant {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 15%;
                    height: 100%;
                    font-weight: bold;
                    color: white;
                    border-right: 2px solid #ccc;
                }

                .total-price {
                    display: flex;
                    align-items: center;
                    justify-content: end;
                    width: 15%;
                    height: 100%;
                    font-weight: bold;
                    color: white;
                    padding-right: 5px;
                }
            }
        }

        .row:hover {
            background-color: #999;
        }
    }

    .text-center {
        display: flex;
        align-items: center;
        justify-content: center;

        a {
            color: white;
            font-size: 2rem;
            text-decoration: none;
        }
    }

    .table-totals {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 35%;
        background-color: #4299E1;
        padding: 4px;
        margin-left: 65%;
        border-radius: 0 0 10px 10px;

        .row {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            width: 100%;
            background-color: #444;
            padding: 6px;
            border-radius: 0 0 10px 10px;

            .titles {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                width: 62%;

                p {
                    font-size: 1.6rem;
                    font-weight: bold;
                    color: white;
                }

                .subtotal {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 100%;
                    height: 30px;
                    font-weight: bold;
                    color: white;
                    border-right: 2px solid #ccc;
                }

                .discount {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 100%;
                    height: 30px;
                    font-weight: bold;
                    color: white;
                    border-right: 2px solid #ccc;
                }

                .total {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 100%;
                    height: 30px;
                    font-weight: bold;
                    color: white;
                    border-right: 2px solid #ccc;
                }
            }

            .values {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                width: 50%;

                p {
                    font-size: 1.6rem;
                    font-weight: bold;
                    color: white;
                }

                .subtotal {
                    display: flex;
                    align-items: center;
                    justify-content: end;
                    width: 100%;
                    height: 30px;
                    font-weight: bold;
                    color: white;
                    padding-right: 4px;
                }

                .discount {
                    display: flex;
                    align-items: center;
                    justify-content: end;
                    width: 100%;
                    height: 30px;
                    font-weight: bold;
                    color: white;
                    padding-right: 4px;
                }

                .total {
                    display: flex;
                    align-items: center;
                    justify-content: end;
                    width: 100%;
                    height: 30px;
                    font-weight: bold;
                    color: white;
                    padding-right: 4px;
                }
            }
        }
    }

    /* Responsive design */
    @media (max-width: 700px) {
        .table-container {
            .row {
                .table-title {
                    p {
                        font-size: 1.2rem;
                    }

                    .remove-product,
                    .description,
                    .unit-price,
                    .cant,
                    .total-price {
                        align-items: center;
                    }
                }
            }
        }

        .table-content {
            .row {
                .table-product {
                    p {
                        font-size: 1.2rem;
                    }

                    .remove-product {
                        .btn {
                            width: 35px;
                            height: 30px;
                        }
                    }

                    .description,
                    .unit-price,
                    .cant,
                    .total-price {
                        align-items: center;
                    }
                }
            }
        }
    }
</style>
@endpush