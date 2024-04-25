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
                                    <label for="product-class">Select Provider</label>
                                    <select name="product_class_id" id="product_class_id" class="form-control">
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

                                    </select>
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
                        </div>

                        <div class="row">
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

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <input class="form-control" type="number" name="status" min="0" step="1" placeholder="0">
                                </div>
                            </div>
                        </div>


                        <div class="flex items-center justify-center md:gap-8 gap-4 pt-5 pb-5">
                            <a href="{{route('incomes.index')}}" class="w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-x1 font-medium text-white px-4 py-2"></a>
                            <button type="submit" class="btn btn-primary">Save Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop