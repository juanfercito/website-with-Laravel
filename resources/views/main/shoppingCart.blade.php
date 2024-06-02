@extends('layouts.main')

@section('title', 'Online Shop | Shopping Cart')

@section('content')

<div class="container">
    <h1>Your Shopping Cart</h1>
    <form id="purchase-form" action="{{ route('cart.savePurchase') }}" method="post">
        @csrf

        <div class="card">
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
                                <div class="table-title" id="tableTitleToggle">
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
                        </div>
                        <div class="clear-cart">
                            <form action="{{ route('cart.clearCart') }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger">Clear Cart</button>
                            </form>
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
            <div class="user-data">
                <div class="row">
                    <div class="dni">
                        <div class="form-floating">
                            <label for="dni">DNI</label>
                            <input type="text" name="dni" id="dni" class="form-control" value="">
                        </div>
                    </div>

                    <div class="name">
                        <div class="form-floating">
                            <label for="customer_name">Customer Name</label>
                            <input name="customer_name" id="customer_name" class="form-control" autocomplete="name">
                        </div>
                    </div>

                    <div class="email">
                        <div class="form-floating">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" autocomplete="email">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="telephone">
                        <div class="form-floating">
                            <label for="telephone">Telephone</label>
                            <input name="telephone" id="telephone" class="form-control" autocomplete="telephone">
                        </div>
                    </div>
                    <div class="proof-type">
                        <div class="form-floating">
                            <label for="proof_type">Payment Type</label>
                            <select name="proof_type" id="proof_type" class="form-control">
                                <option value="Vaucher">Vaucher</option>
                                <option value="Transfer">Transfer</option>
                                <option value="Paypal">Paypal</option>
                                <option value="Check">Check</option>
                            </select>
                        </div>
                    </div>

                    <div class="proof-number">
                        <div class="form-floating">
                            <label for="proof_number">Ticket Number</label>
                            <input type="number" class="form-control" id="proof_number" name="proof_number">
                        </div>
                    </div>
                </div>
            </div>
            <div class="buy">
                <button type="button" class="btn btn-success" onclick="handlePurchase()">
                    <i class="fas fa-shopping-cart"></i> Comprar
                </button>
            </div>
            @if (session('success'))
            <script>
                alert("{{ session('success') }}");
            </script>
            @endif
            @else
            <div class="text-center">
                <a href="/" class="btn btn-primary">Empty. Add a Product</a>
            </div>
            @endif
        </div>
    </form>
</div>

<!-- Use of Jquery and serching for customers before the purchase -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dni').keypress(function(event) {
            if (event.which === 13) { // 13 is the Enter key code
                event.preventDefault();
                var dni = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "{{ route('search.customer.by.dni') }}",
                    data: {
                        dni: dni
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#customer_name').val(response.name);
                            $('#email').val(response.email);
                            $('#telephone').val(response.telephone);
                        } else {
                            alert('Customer not found. Please enter a valid DNI.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Error searching for customer. Please try again.');
                    }
                });
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tableTitle = document.getElementById("tableTitleToggle");
        const tableContent = document.querySelector(".table-content");

        tableTitle.addEventListener("click", function() {
            if (tableContent.style.display === "none" || tableContent.style.display === "") {
                tableContent.style.display = "block";
            } else {
                tableContent.style.display = "none";
            }
        });
    });
</script>

<!-- Purchase management -->
<script>
    function handlePurchase() {
        var purchaseForm = document.getElementById('purchase-form');

        // Crear una instancia de FormData con los datos del formulario
        var formData = new FormData(purchaseForm);

        fetch(purchaseForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                // Realizar la recarga de la página si la respuesta es exitosa
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al realizar la compra. Por favor, inténtelo de nuevo.');
            });
    }
</script>


@endsection

@push('css')
<style>
    .container {
        display: flex;
        align-items: start;
        justify-content: center;
        width: 100%;
        height: 100vh;
        font-size: 62.5%;
        background: linear-gradient(to bottom, #4299E1, #1b2029, #4299E1);
    }

    form {
        display: flex;
        align-items: start;
        justify-content: center;
    }

    h1 {
        display: flex;
        align-items: center;
        position: absolute;
        font-size: 4rem;
        margin-top: 70px;
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
            display: flex;
            flex-direction: column;

            .row {
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;

                .product-cant {
                    padding-left: 6px;
                }

                .discount-avg {
                    padding-left: 6px;
                    padding-right: 6px;
                }
            }

            .clear-cart {
                display: flex;
                position: absolute;
                bottom: 20%;
                left: 30%;

                .btn {
                    width: 100px;
                    height: 30px;
                    font-size: 1.4rem;
                    font-weight: bold;
                    background-color: goldenrod;
                    border: 2px solid transparent;
                    border-radius: 10px;
                    color: #555;
                }

                .btn:hover {
                    cursor: pointer;
                    background: radial-gradient(ellipse at center, #fff, crimson);
                    border-bottom: 2px solid darkred;
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

            .table-title:hover {
                cursor: pointer;

                p {
                    color: wheat;
                }
            }
        }
    }

    .table-content {
        display: none;
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
                        font-size: 2rem;
                        background-color: goldenrod;
                        color: white;
                        font-weight: bold;
                        border: 2px transparent;
                        border-radius: 8px;
                    }

                    .btn:hover {
                        cursor: pointer;
                        background: radial-gradient(circle at center, #fff, crimson);
                        color: #333;
                        border-bottom: 2px solid darkred;
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

        a:hover {
            color: wheat;
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

    .user-data {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        margin-top: 20px;
        background-color: rgba(0, 0, 0, 0.4);
        border-radius: 10px;

        .row {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            margin: 6px;
            width: 100%;
            padding: 4px;

            label {
                font-size: 1.6rem;
                color: white;
            }

            input {
                font-size: 1.6rem;
                color: #444;
                font-weight: bold;
            }

            .form-floating {
                margin-inline: 4px;
            }

            .dni,
            .telephone {
                width: 20%;
                margin: 4px;

                label {
                    margin-bottom: 4px;
                }
            }

            .name,
            .email,
            .proof-type,
            .proof-number {
                width: 40%;
            }

            .proof-type select {
                display: flex;
                align-items: start;
                font-size: 1.6rem;
                border: none;

                option {
                    font-size: 1.4rem;
                }
            }
        }
    }

    .buy {
        display: flex;
        align-items: center;
        justify-content: end;
        width: 100%;
        height: 60px;

        .btn {
            min-width: 120px;
            height: 30px;
            font-size: 1.6rem;
            margin-right: 6px;
            border-radius: 10px;
            background-color: springgreen;
            color: #333;
            font-weight: bold;
            border: none;
        }

        .btn:hover {
            cursor: pointer;
            color: white;
            background: linear-gradient(to bottom, #4299E1, #1b2029, #4299E1);
            border-bottom: 2px solid #ccc;
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

        .table-totals {
            .row {

                .titles {
                    p {
                        font-size: 1rem;
                    }
                }

                .values {
                    p {
                        font-size: 1.2rem;
                    }
                }
            }
        }

        .user-data {
            flex-direction: row;

            .row {
                flex-direction: column;

                label {
                    font-size: 1.2rem;
                    bottom: 4px;
                }

                .dni,
                .telephone,
                .name,
                .proof-type,
                .proof-number,
                .email {
                    width: 100%;
                    margin-top: 6px;
                    margin-bottom: 6px;
                }

                .proof-type select {
                    option {
                        font-size: 1.2rem;
                        width: 100px;
                    }
                }
            }
        }
    }
</style>
@endpush