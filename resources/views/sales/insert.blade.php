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

                    <form action="{{route('sales.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-floating">
                                    <label for="customer">Customer Name</label>
                                    <input name="customer_id" id="customer_id" class="form-control" value="{{ implode(', ', App\Models\Customer::pluck('name')->toArray()) }}">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-3">
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

                            <div class="col-xs-12 col-sm-12 col-md-3">
                                <div class="form-floating">
                                    <label for="proof-number">Ticket Number</label>
                                    <input type="number" class="form-control" id="proof_number" name="proof_number">
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-floating">
                                    <label for="discount">Discount</label>
                                    <input type="number" class="form-control" id="discount" name="discount" step="0.01" min="0.00" placeholder="0.00" value="0">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="products">Products</label>
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
                                    <input type="number" class="form-control" id="stock" name="stock" min="0">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2">
                                <div class="form-floating">
                                    <label for="sale-price">Sale Price</label>
                                    <input type="number" class="form-control" name="sale_price" id="sale_price" step="0.01" min="0.00" placeholder="0.00">
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
                                                    <th style="min-width: 80px;">Stock</th> <!-- Ajustar el ancho -->
                                                    <th style="min-width: 80px;">Sale Price</th> <!-- Ajustar el ancho -->
                                                    <th style="min-width: 80px;">Discount</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="6">TOTAL</th>
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
        $('#product_id').change(function() {
            showValues();
        });

        $('#add_product').click(function() {
            add();
        });
    });

    var cont = 0;
    total = 0;
    subtotal = [];

    $("#save").hide();

    function showValues() {
        articleData = document.getElementById('product_id').value.split('_');
        $("#sale_price").val(articleData[2]);
        $("#stock").val(articleData[1]); // Corregir aquí para establecer el valor del stock en el input
    }


    function add() {
        var articleData = $('#product_id').val().split('_');

        var idArticle = articleData[0];
        var article = $("#product_id option:selected").text();
        var cant = $("#cant").val();
        var stock = parseInt($("#stock").html()); // Cambio aquí para obtener el valor del stock
        var sale_price = parseFloat($("#sale_price").val());
        var discount = $("#discount").val();
        var unit = articleData[3];

        if (idArticle != "" && cant != "" && cant > 0 && discount != "" && sale_price != "") {
            subtotal[cont] = (cant * sale_price);
            total = total + subtotal[cont];

            var row = '<tr class="selected" id="row' + cont +
                '"><td><button type="button" class="btn btn-warning fas fa-trash-alt" onclick="rmRow(' + cont +
                ');"></button></td><td><input type="hidden" name="idArticle[]" value="' + idArticle + '">' + article +
                '</td><td><input type="number" name="cant[]" value="' + cant +
                '"></td><td><input type="number" name="stock[]" value="' + stock +
                '"></td><td><input type="number" name="sale_price[]" value="' + sale_price +
                '"></td><td><input type="number" name="discount[]" value="' + discount + '"></td><td>' +
                subtotal[cont] + '</td></tr>';

            cont++;
            cleanItems();
            $("#total").html("$ " + total);
            evaluate();
            $("#details").append(row);
        } else {
            alert("Failed putting details of sale. Please try again");
        }
    }

    function cleanItems() {
        $('#cant').val("");
        $('#discount').val("");
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