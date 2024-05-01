@extends('layouts.app')

@section('content_header_title', 'Incomes')
@section('content_header_subtitle', 'New')

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

                    <form action="{{route('incomes.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-floating">
                                    <label for="provider-id">Select Provider</label>
                                    <select name="provider_id" id="provider_id" class="form-control">
                                        @foreach(App\Models\Provider::all() as $provider)
                                        <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-floating">
                                    <label for="payment-proof">Payment Type</label>
                                    <select name="payment_proof" id="payment_proof" class="form-control">
                                        <option value="Vaucher">Vaucher</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="Paypal">Paypal</option>
                                        <option value="Check">Check</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-floating">
                                    <label for="proof-number">Ticket Number</label>
                                    <input type="number" class="form-control" id="proof_number" name="proof_number">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="products">Products</label>
                                    <select name="product_id" id="product_id" class="form-control selectpicker" data-live-search="true">
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->Product }}</option>
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
                                    <label for="purchase-price">Purchase Price</label>
                                    <input type="number" class="form-control" id="purchase_price" name="purchase_price" step="0.01" min="0.00" placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-floating">
                                    <label for="sale-price">Sale price</label>
                                    <input type="number" class="form-control" id="sale_price" name="sale_price" step="0.01" min="0.00" placeholder="0.00">
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
                                                    <th style="min-width: 80px;">Options</th> <!-- Ajustar el ancho -->
                                                    <th style="min-width: 300px;">Description</th> <!-- Ajustar el ancho -->
                                                    <th style="min-width: 80px;">Quantity</th> <!-- Ajustar el ancho -->
                                                    <th style="min-width: 80px;">Purchase Price</th> <!-- Ajustar el ancho -->
                                                    <th style="min-width: 80px;">Sale Price</th> <!-- Ajustar el ancho -->
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
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
        $('#add_product').click(function() {
            add();
        });
    });

    var cont = 0;
    total = 0;
    subtotal = [];

    $("#save").hide();
    $("#product_id").change(showValues);

    function showValues() {
        articleData = document.getElementById('product_id').value.split('-');
        $("#cant").val(articleData[1]);
        $("#unit").html(articleData[2]);
    }

    function add() {
        articleData = document.getElementById('product_id').value.split('_');

        idArticle = articleData[0];
        article = $("#product_id option:selected").text();
        cant = $("#cant").val();
        purchase_price = $("#purchase_price").val();
        sale_price = $("#sale_price").val();

        if (idArticle != "" && cant != "" && cant > 0 && purchase_price != "" && sale_price != "") {
            subtotal[cont] = (cant * purchase_price);
            total = total + subtotal[cont];

            var row = '<tr class="selected" id="row' + cont +
                '"><td><button type="button" class="btn btn-warning fas fa-trash-alt" onclick="rmRow(' + cont +
                ');"></button></td><td><input type="hidden" name="idArticle[]" value="' + idArticle + '">' + article +
                '</td><td><input type="number" name="cant[]" value="' + cant +
                '"></td><td><input type="number" name="purchase_price[]" value="' + purchase_price +
                '"></td><td><input type="number" name="sale_price[]" value="' + sale_price + '"></td><td>' +
                subtotal[cont] + '</td></tr>';

            cont++;
            cleanItems();
            $("#total").html("$ " + total);
            evaluate();
            $("#details").append(row);
        } else {
            alert("Failed putting details of Income. Please try again");
        }
    }

    function cleanItems() {
        $('#cant').val("");
        $('#purchase_price').val("");
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
        total = total - subtotal[index];
        $("#total").html("$ " + total);
        $("#row" + index).remove();
        evaluate();
    }
</script>
@endpush

@stop

@section('css')

<style>
    .card {
        border-radius: 12px;
    }

    .add-button {
        display: flex;
        align-items: center;
        justify-content: center;
        top: 8px;
        bottom: 0;
    }

    #save {
        display: none;
    }
</style>

@stop