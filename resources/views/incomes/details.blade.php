@extends('layouts.app')

@section('title', 'Order Details')

@section('content_header_title', 'Incomes')
@section('content_header_subtitle', 'Details')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="border-radius: 12px;">
                <div class="card-header">Income Details</div>

                <div class="card-body">
                    <h2 class="mb-4">ORDER ID: {{ $income->id }}</h2>
                    <p style="font-size: 1.4rem; font-weight: bold;">Provider: {{ $income->name }}</p>
                    <p>Date Time: {{ $income->date_time }}</p>
                    <p>Payment Proof: {{ $income->payment_proof }}</p>
                    <p>Proof Number: {{ $income->proof_number }}</p>
                    <p>Fee Tax: {{ $income->fee_tax }}</p>
                    <p>Status: {{ $income->status }}</p>
                    <h2 style="color: lightblue; font-weight: bolder;" class="my-4">Total: ${{ $income->total }}</h2>

                    <table class="table">
                        <h4>Income Order Details</h4>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Purchase Price</th>
                                <th>Sale Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details as $detail)
                            <tr>
                                <td>{{ $detail->product }}</td>
                                <td>{{ $detail->cant }}</td>
                                <td>${{ $detail->purchase_price }}</td>
                                <td>${{ $detail->sale_price }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <td>
                        <div class="btn-action">
                            <form action="{{ route('incomes.cancel', $income->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning" style="color: white;">
                                    <span class="d-none d-sm-inline">Cancel Order</span>
                                    <i class="d-inline d-sm-none fa fa-ban"></i>
                                </button>
                            </form>

                            <a href="{{ route('incomes.index') }}" class="btn btn-primary my-3">Back to List</a>
                        </div>
                </div>
                </td>
            </div>
        </div>
    </div>
</div>

@stop