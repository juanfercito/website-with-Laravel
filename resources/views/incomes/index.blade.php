@extends('layouts.app')

@section('title', 'Incomes')

@section('content_header_title', 'Incomes')
@section('content_header_subtitle', 'View')

@section('content')
<p>Watch the whole sumary of product incomes</p>

<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card" style="border-radius: 16px;">
                <div class="card-body">
                    <div class="row">

                        @can('insert-income')
                        <a class="btn btn-warning my-3 text-white" href="{{route('incomes.create')}}">New Income Order</a>
                        @endcan
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <div class="input-group my-3">
                                <form action="{{ route('incomes.index') }}" method="GET" class="input-group mb-6">

                                    <span class="input-group"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control" name="search" placeholder="Search for ticket features..." value="{{ request('search') }}">
                                    <button class="btn bg-secondary search-button" type="submit">
                                        <i class="text-white fas fa-search"></i> <!-- Icono de búsqueda -->
                                    </button>
                                    <button class="btn" type="reset" onclick="clearSearch();">
                                        <i class="text-white fa fa-sync"></i> <!-- Icono de búsqueda -->
                                    </button>

                                </form>
                            </div>
                        </div>

                    </div>

                    <div style="overflow-x: auto;">
                        <table class="table table-stripped mt-3" id="scrolling-1">
                            <thead style="background-color: #6777ef;">
                                <tr>

                                    <th style="min-width: 60px; color: #fff; display: flex; justify-content:center;">Actions</th>
                                    <th style="min-width: 50px; color: #fff">ID</th>
                                    <th style="min-width: 150px; color: #fff; white-space: nowrap;">Provider</th>
                                    <th style="min-width: 80px; color: #fff;">Payment_proof</th>
                                    <th style="min-width: 80px; color: #fff;">Proof_number</th>
                                    <th style="min-width: 120px; color: #fff;">date_time</th>
                                    <th style="min-width: 80px; color: #fff;">fee_tax</th>
                                    <th style="min-width: 80px; color: #fff;">Total</th>
                                    <th style="min-width: 80px; color: #fff;">status</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($incomes as $income)
                                <tr>

                                    <td>
                                        <div class="btn-action">
                                            <a class="btn btn-info btn-sm" href="{{ route('incomes.show', $income->id) }}">
                                                <i class="d-inline d-sm-none fas fa-info"></i>
                                                <span class="d-none d-sm-inline-flex">Details</span>
                                            </a>

                                            <form method="POST" action="{{ route('incomes.destroy', $income->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                    <span class="d-none d-sm-inline">Delete</span>
                                                    <i class="d-inline d-sm-none fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>


                                    <td>{{$income->id}}</td>
                                    <td>{{$income->name}}</td>
                                    <td>{{$income->payment_proof}}</td>
                                    <td>{{$income->proof_number}}</td>
                                    <td>{{$income->date_time}}</td>
                                    <td>{{$income->fee_tax}}</td>
                                    <td>{{ $income->total }}</td>
                                    <td>{{$income->status}}</td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="pagination justify-content-end">
    {!! $incomes->links() !!}
</div>
@stop

@section('css')

{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>

<script>
    // Activating the horizontal scrolling with the mouse wheel
    var contenedor1 = document.getElementById('scrolling-1');

    contenedor1.addEventListener('wheel', function(event) {
        if (event.deltaY !== 0) {
            event.preventDefault();
            contenedor1.scrollLeft += event.deltaY;
        }
    }, {
        passive: true
    });
</script>

{{-- link for refreshing screen --}}
<script>
    function clearSearch() {
        document.querySelector('.form-control[name="search"]').value = ''; // Stablish the search value input as empty
        document.querySelector('.input-group.mb-6').submit();
    }
</script>
@stop