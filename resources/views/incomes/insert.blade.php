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
                                    <label for="provider-class">Select Provider</label>
                                    <select name="provider_class_id" id="provider_class_id" class="form-control">
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
                                    <label for="product-type">Ticket Number</label>

                                    <input type="number" class="form-control" id="proof_number" name="proof_number">

                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="fee-tax">Fee or Tax</label>
                                    <input class="form-control" type="number" name="fee_tax" min="0" step="1" placeholder="0">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="closing-order-date">Closing Order Date</label>
                                    <div class="input-group">
                                        <input type="text" id="closing-order-date" name="closing-order-date" class="form-control">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="products">Products</label>
                                    <select name="id_product" id="id_product" class="form-control selectpicker" data-live-search="true">
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->title }}</option>
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

                        <div class="card-content">
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    <thead style="background-color: #6777ef;">
                                        <tr>
                                            <th>Options</th>
                                            <th>Product</th>
                                            <th>Cant</th>
                                            <th>Purchase Price</th>
                                            <th>Sale Price</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <th>TOTAL</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <h5 id="total">$0.00</h5>
                                        </th>
                                    </tfoot>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="flex items-center justify-center md:gap-8 gap-4 pt-5 pb-5">
                            <a href="{{route('incomes.index')}}" class="w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-x1 font-medium text-white px-4 py-2"></a>
                            <button type="submit" class="btn btn-primary" id="save">Save Order</button>

                            <button type="reset" class="btn btn-danger me-1 mb-1">Cancel</button>
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
            {
                add();
            }
        });

    });

    var count = 0;
    total = 0;
    subtotal = [];

    $('#save').hide();
    $('#id_product').change(showValues);

    function showValues() {
        articleData = document.getElementById('id_product').value.split('_');
        $('#cant').val(articleData[1]);
        $('#unit').html(articleData[2]);
    }

    function add() {
        articleData = document.getElementById('id_product').value.split('_');
        idProduct = articleData[0];
        product = $('#id_product option:selected').text();
        cant = $('#cant').val();
        purchase_price = $('#purchase_price').val();
        sale_price = $('#sale_price').val();

        if (idProduct != "" && cant != "" && cant > 0 && purchase_price != "" && sale_price != "") {
            subtotal[count] = (cant * purchase_price);
            total = total + subtotal[count];

        };
    }

    function clean() {
        $('#cant').val("");
        $('#purchase_price').val("");
        $('#sale_price').val("");
    }

    function evaluate() {
        if (total > 0) {
            $('#save').show();
        } else {
            $('#save').hide();
        }
    }
</script>
@endpush

@stop

@section('css')

<style>
    .add-button {
        display: flex;
        align-items: center;
        justify-content: center;
        top: 10px;
        bottom: 0;
    }
</style>

@stop