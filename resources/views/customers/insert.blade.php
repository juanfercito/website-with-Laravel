@extends('layouts.app')

@section('title', 'Customers')

@section('content_header_title', 'Create')
@section('content_header_subtitle', 'New')

@section('content')
<div class="card">
    <div class="card-body">

        @if ($errors->any())
        <div class="alert alert-dark alert-dismissible fade show" role="alert">
            <strong>¡Try Again!</strong>

            @foreach ($errors->all() as $error)
            <span class="badge badge-danger">{{$error}}</span>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <form method="POST" action="{{ route('customers.store') }}">
            @csrf

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="dni">DNI</label>
                        <input type="text" name="dni" id="dni" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="telephone">Telephone</label>
                        <input type="text" name="telephone" id="telephone" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-4">
                    <a href="{{ route('customers.index') }}" class="btn btn-warning mb-3">Back to List</a>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <button type="submit" class="btn btn-primary mb-3">Save Changes</button>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <button type="button" class="btn btn-info mb-3" onclick="useExistingData()">Use existent</button>
                </div>
            </div>
        </form>
        <!-- Botón para usar datos existentes -->

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
                            $('#name').val(response.name);
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

    function useExistingData() {
        window.location.href = "{{ route('sales.create') }}";
    }
</script>

@endpush
@stop

@section('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
<style>
    .btn {
        width: 120px;
        border-radius: 32px;
    }

    .search-button {
        display: flex;
        align-items: center;
        justify-content: center;
        top: 16px;
        bottom: 0;
    }
</style>
@stop