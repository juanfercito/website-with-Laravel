@extends('layouts.app')

@section('title', 'Sales')

@section('content_header_title', 'Datails')
@section('content_header_subtitle', 'View')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="border-radius: 12px;">
                <div class="card-header">Sale Details</div>

                <div class="card-body">
                    <h2 class="mb-4">CLOSEOUT ID: {{ $sales->id }}</h2>
                    <p style="font-size: 1.4rem; font-weight: bold;">Customer: {{ $sales->name }}</p>
                    <p>Date Time: {{ $sales->date_time }}</p>
                    <p>Payment Proof: {{ $sales->proof_type }}</p>
                    <p>Proof Number: {{ $sales->proof_number }}</p>
                    <p>Fee Tax: {{ $sales->tax_fee }}</p>
                    <p>Status: {{ $sales->status }}</p>
                    <h2 style="color: lightblue; font-weight: bolder;" class="my-4">Total: ${{ $sales->sale_total }}</h2>

                    <!-- Calculate the discount percentage, the totalDiscount value and the Sale Subtotal to show on the screen -->
                    @php
                    $subtotal = 0;

                    foreach ($details as $detail) {
                    $subtotal += $detail->cant * $detail->sale_price;
                    }
                    $discountPercentage = 0;
                    $totalDiscount = 0;
                    $totalQuantity = 0;

                    foreach ($details as $detail) {
                    $totalDiscount += $detail->discount * $detail->cant;
                    $totalQuantity += $detail->cant;
                    }

                    if ($totalQuantity >= 3 && $totalQuantity <= 10) { $discountPercentage=5; } elseif ($totalQuantity> 10 && $totalQuantity <= 20) { $discountPercentage=10; } elseif ($totalQuantity> 20) {
                            $discountPercentage = 15;
                            }
                            @endphp

                            <p style="font-size:1.4rem; font-weight: bolder;">Subtotal: ${{ number_format($subtotal, 2) }}</p>
                            <p>Avg Discount: {{ number_format($discountPercentage, 2) }}%</p>
                            <p>Total Discount: ${{ number_format($totalDiscount, 2) }}</p>

                            <table class="table">
                                <h4>Income Order Details</h4>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Discount</th>
                                        <th>Sale Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($details as $detail)
                                    <tr>
                                        <td>{{ $detail->product }}</td>
                                        <td>{{ $detail->cant }}</td>
                                        <td>${{ $detail->discount}}</td>
                                        <td>${{ $detail->sale_price }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <td>
                                <div class="btn-action">
                                    <form action="{{ route('sales.cancel', $sales->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-warning" style="color: white;">
                                            <span class="d-none d-sm-inline">Cancel Order</span>
                                            <i class="d-inline d-sm-none fa fa-ban"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('sales.index') }}" class="btn btn-primary my-3">Back to List</a>
                                </div>
                </div>
                </td>
            </div>
        </div>
    </div>
</div>

@stop