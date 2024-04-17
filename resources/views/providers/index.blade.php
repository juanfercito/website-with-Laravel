@extends('layouts.app')

@section('title', 'Providers')

@section('content_header_title', 'Providers')
@section('content_header_subtitle', 'View')


@section('content')
<p>Providers admin panel.</p>

<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card" style="border-radius: 16px;">
                <div class="card-body">
                    <a class="btn btn-warning my-3" href="{{ route('providers.create') }}">New Provider</a>

                    <div style="overflow-x: auto;">
                        <table class="table table-stripped mt-3" id="scrolling-1">
                            <thead style="background-color: #6777ef;">
                                <tr>
                                    <th style="color: #fff;">Actions</th>
                                    <th style="display: none;">ID</th>
                                    <th style="color: #fff; white-space: nowrap;">Name</th>
                                    <th style="color: #fff;">Class</th>
                                    <th style="color: #fff;">Category</th>
                                    <th style="color: #fff;">Logo</th>
                                    <th style="color: #fff;">Location</th>
                                    <th style="color: #fff;">Closing Order</th>
                                    <th style="color: #fff;">Application Date</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($providers as $provider)
                                <tr>
                                    <td>
                                        <div class="btn-action">
                                            <a class="btn btn-info btn-sm" href="{{ route('providers.edit', $provider->id) }}">
                                                <span class="d-none d-sm-inline-flex">Modify</span>
                                                <i class="d-inline d-sm-none fas fa-pen"></i>
                                            </a>

                                            <form method="POST" action="{{ route('providers.destroy', $provider->id) }}" style="display: inline-flex">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <span class="d-none d-sm-inline">Delete</span>
                                                    <i class="d-inline d-sm-none fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td style="display: none;">{{$provider->id}}</td>
                                    <td>{{$provider->name}}</td>
                                    <td>{{$provider->providerclass->name}}</td>
                                    <td>{{$provider->providerCategory->name}}</td>
                                    <td>
                                        @if($provider->image)
                                        <img src="{{ asset('storage/public/provider_img/' . $provider->image) }}" alt="{{ $provider->image }}" style="width: 50px; height: 30px;">
                                        @else
                                        <span>No image available</span>
                                        @endif
                                    </td>

                                    <td>{{$provider->location}}</td>

                                    <td>{{ \Carbon\Carbon::parse($provider->closing_order_date)->format('Y-m-d H:i:s') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($provider->application_date)->format('Y-m-d H:i:s') }}</td>

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
    {!! $providers->links() !!}
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
    // Activar el scroll horizontal con la rueda del ratón para el primer contenedor
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
@stop