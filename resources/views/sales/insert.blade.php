@extends('layouts.app')

@section('title', 'Sales | Insert')

@section('content_header_title', 'Sales')
@section('content_header_subtitle', 'Create')

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    @if ($errors->any())
                    <div class="alert alert-dark alert-dimissible fade show" role="alert">
                        <strong>¡Try Again!</strong>

                        @foreach ($errors->all() as $error)
                        <span class="badge badge-danger">{{$error}}</span>
                        @endforeach
                        <button type="button" class="close" data-dimiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <form action="{{ route('sales.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row my-2">
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-floating">
                                    <label for="dni">Doc. Identity</label>
                                    <input type="text" name="dni" id="dni" class="form-control" value="">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-floating">
                                    <label for="customer_name">Customer Name</label>
                                    <input name="customer_name" id="customer_name" class="form-control" autocomplete="name">

                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-floating">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" autocomplete="email">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-floating">
                                    <label for="telephone">Telephone</label>
                                    <input name="telephone" id="telephone" class="form-control" autocomplete="telephone">
                                </div>
                            </div>
                        </div>

                        <div class="row my-2">
                            <div class="col-xs-12 col-sm-12 col-md-4">
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

                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-floating">
                                    <label for="proof_number">Ticket Number</label>
                                    <input type="number" class="form-control" id="proof_number" name="proof_number">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-floating">
                                    <label for="avg_discount"> % Discount</label>
                                    <input type="number" class="form-control" id="avg_discount" name="avg_discount" step="0.01" min="0.00" placeholder="0.00" value="0" disabled>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-floating">
                                    <label for="discount">Discount</label>
                                    <input type="number" class="form-control" id="discount" name="discount" step="0.01" min="0.00" placeholder="0.00" value="0" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="product_id">Products</label>
                                    <select name="product_id" id="product_id" class="form-control selectpicker" data-live-search="true">
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}_{{ $product->stock }}_{{ $product->avg_price }}">{{ $product->Product }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-floating">
                                    <label for="cant">Cant</label>
                                    <input type="number" class="form-control" id="cant" name="cant" min="0" placeholder="0">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-floating">
                                    <label for="stock">Stock</label>
                                    <input type="number" class="form-control" id="stock" name="stock" min="0" disabled>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-floating">
                                    <label for="sale_price">Sale Price</label>
                                    <input type="number" class="form-control" name="sale_price" id="sale_price" step="0.01" min="0.00" placeholder="0.00" disabled>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-2 add-button">
                                <div class="form-floating ">
                                    <button type="button" id="add_product" class="btn btn-outline-success">Add Product</button>
                                </div>
                            </div>
                        </div>


                        <div class="card my-3">
                            <div class="card-header">
                                <h4 class="card-title">Selected Products</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="details" class="table table-bordered table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th style="min-width: 80px;">Options</th>
                                                    <th style="min-width: 300px;">Description</th>
                                                    <th style="min-width: 80px;">Quantity</th>
                                                    <th style="min-width: 80px;">Unit Price</th>
                                                    <th style="min-width: 80px;">Unit Discount</th>
                                                    <th style="min-width: 80px;">Total Price</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="5">SUBTOTAL</th>
                                                    <th>
                                                        <h5 id="subtotal">$0.00</h5>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="5">Discount</th>
                                                    <th>
                                                        <h5 id="total_discount">$0.00</h5>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="5">TOTAL</th>
                                                    <th>
                                                        <h5 id="total">$0.00</h5>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <!-- Aquí se agregarán dinámicamente las filas de productos -->
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-center md:gap-8 gap-4 pt-3 pb-3">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-success me-1 mb-1" id="save">Save Order</button>
                            <button type="button" class="btn btn-danger me-1 mb-1" onclick="window.history.back()">Cancel</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<script>
    $(document).ready(function() {
        $('#dni').keypress(function(event) {
            if (event.which === 13) { // 13 is the Enter key code
                event.preventDefault();
                var dni = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "/search-customer-by-dni",
                    data: {
                        dni: dni
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#customer_id').val(response.id);
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
    $(document).ready(function() {
        $('#product_id').change(function() {
            showValues();
        });

        $('#add_product').click(function() {
            add();
            updateDiscount();
            updateSubtotal();
            updateTotalDiscount();
            updateTotal();
        });
    });

    var cont = 0;
    var total = 0;
    var total_price = [];
    subtotal = [];

    $("#save").hide();

    function showValues() {
        var articleData = document.getElementById('product_id').value.split('_');
        $("#sale_price").val(articleData[2]);
        $("#stock").val(articleData[1]);
        $("#discount").val(0);
    }

    function calculateDiscount(totalQuantity) {
        var discountRate = 0;

        if (totalQuantity >= 3 && totalQuantity <= 10) {
            discountRate = 5;
        } else if (totalQuantity > 10 && totalQuantity <= 20) {
            discountRate = 10;
        } else if (totalQuantity > 20) {
            discountRate = 15;
        }

        return discountRate;
    }

    function updateDiscount() {
        var totalQuantity = calculateTotalQuantity();
        var discountRate = calculateDiscount(totalQuantity);

        $("input[name='discount[]']").each(function() {
            var salePrice = parseFloat($(this).closest('tr').find("input[name='sale_price[]']").val());
            var discount = salePrice * (discountRate / 100);
            $(this).val(discount.toFixed(2)); // Mantener los decimales con dos posiciones
        });
    }

    function calculateTotalQuantity() {
        var totalQuantity = 0;
        $("input[name='cant[]']").each(function() {
            totalQuantity += parseInt($(this).val());
        });
        return totalQuantity;
    }

    function add() {
        var articleData = document.getElementById('product_id').value.split('_');

        var idArticle = articleData[0];
        var article = $("#product_id option:selected").text();
        var cant = parseInt($("#cant").val());
        var stock = parseInt($("#stock").val());
        var salePrice = parseFloat($("#sale_price").val());

        if (idArticle != "" && cant != "" && cant > 0 && salePrice != "") {
            total_price[cont] = (cant * salePrice);
            subtotal = total_price;
            total += subtotal[cont];

            // Calcular el nuevo total
            var newTotal = calculateNewTotal(total_price);

            var row = '<tr class="selected" id="row' + cont +
                '"><td><button type="button" class="btn btn-warning fas fa-trash-alt" onclick="rmRow(' + cont +
                ');"></button></td><td><input type="hidden" name="idArticle[]" value="' + idArticle + '">' + article +
                '</td><td><input type="number" name="cant[]" value="' + cant +
                '"></td><td><input type="number" name="sale_price[]" value="' + salePrice +
                '"></td><td><input type="text" name="discount[]" value="0"></td><td>' +
                total_price[cont] + '</td></tr>';

            cont++;
            cleanItems();
            $("#subtotal").html("$ " + newTotal.toFixed(2));
            $("#total").html("$ " + newTotal.toFixed(2));
            $("#sale_total").val(newTotal.toFixed(2));
            evaluate();
            $("#details").append(row);
        } else {
            alert("Failed putting details of sale. Please try again");
        }
    }

    function calculateNewTotal(total_price) {
        var sum = 0;
        for (var i = 0; i < total_price.length; i++) {
            sum += total_price[i];
        }
        return sum;
    }

    function cleanItems() {
        $('#cant').val("");
        $('#sale_price').val("");
    }

    function evaluate() {
        if (total > 0) {
            $("#save").show();
        } else {
            $("#save").hide();
        }
    }

    function rmRow(index) {
        total -= total_price[index];
        subtotal.splice(index, 1);
        $("#total").html("$ " + total.toFixed(2));
        $("#row" + index).remove();
        evaluate();
        updateDiscount();
        updateSubtotal();
        updateTotalDiscount();
        // Actualizar el campo sale_total con el nuevo valor
        $("#sale_total").val(total.toFixed(2)); // Asegurarse de que sea un valor de dos decimales
    }


    function updateSubtotal() {
        var sum = 0;
        $("input[name='sale_price[]']").each(function() {
            var salePrice = parseFloat($(this).val());
            var quantity = parseInt($(this).closest('tr').find("input[name='cant[]']").val());
            sum += salePrice * quantity;
        });
        $("#subtotal").html("$ " + sum.toFixed(2));
    }

    function updateTotalDiscount() {
        var subtotalValue = parseFloat($("#subtotal").text().replace("$ ", ""));
        var totalQuantity = calculateTotalQuantity();
        var discountRate = calculateDiscount(totalQuantity);
        var totalDiscount = subtotalValue * (discountRate / 100);
        $("#total_discount").html("$ " + totalDiscount.toFixed(2));
    }

    function updateTotal() {
        var subtotalText = $("#subtotal").text();
        var totalDiscountText = $("#total_discount").text();

        if (subtotalText && totalDiscountText) {
            var subtotalValue = parseFloat(subtotalText.replace("$ ", ""));
            var totalDiscountValue = parseFloat(totalDiscountText.replace("$ ", ""));
            var totalValue = subtotalValue - totalDiscountValue;
            $("#total").html("$ " + totalValue.toFixed(2));
        } else {
            // Manejar el caso en el que el subtotal o el descuento total son null
            console.error("Subtotal or total discount is null");
        }
    }
</script>



@endpush

@stop

@section('css')

<style>
    .card {
        border-radius: 12 px;
    }

    .add-button {
        display: flex;
        align-items: center;
        justify-content: center;
        top: 8px;
        bottom: 0;
    }

    .search-button {
        display: flex;
        align-items: center;
        justify-content: center;
        top: 16px;
        bottom: 0;
    }

    #save {
        display: none;
    }
</style>

@stop