@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
{{ config('adminlte.title') }}
@hasSection('subtitle') | @yield('subtitle') @endif
@stop

{{-- Extend and customize the page content header --}}

@section('content_header')
@hasSection('content_header_title')
<h1 class="text-muted">
    @yield('content_header_title')

    @hasSection('content_header_subtitle')
    <small class="text-dark">
        <i class="fas fa-xs fa-angle-right text-muted"></i>
        @yield('content_header_subtitle')
    </small>
    @endif
</h1>
@endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
@yield('content_body')
@stop

{{-- Create a common footer --}}

@section('footer')
<div class="float-right">
    Version: {{ config('app.version', '1.0.0') }}
</div>

<strong>
    <a href="{{ config('app.company_url', '#') }}">
        {{ config('app.company_name', 'Juanfercito Content Inc.') }}
    </a>
</strong>
@stop

{{-- Add common Javascript/Jquery code --}}

@push('js')
<script>
    $(document).ready(function() {
        // Add your common script logic here...
    });
</script>

<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
@stack('scripts')
@endpush

{{-- Add common CSS customizations --}}

@push('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
<style type="text/css">
    .btn-action {
        display: flex;
        align-items: center;
        margin-right: 4px;
    }

    .btn {
        margin-inline: 4px;
        border-radius: 12px;
    }

    .btn:hover {
        background: linear-gradient(to right, #0d4bf5, #040f74, #043e6e, #1093ff);
    }

    .bootstrap-select:hover {
        color: white !important;
    }

    @media(max-width: 600px) {
        thead {
            font-size: 0.8rem;
        }
    }

    /*{{-- You can add AdminLTE customizations here --}}*/
</style>
@endpush