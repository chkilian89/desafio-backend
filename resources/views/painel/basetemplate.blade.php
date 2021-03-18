@extends('painel.shared.masterpage')
@section('custom_head')
<link rel="icon" href="{{ asset('assets/chktecnologia/img/favicon.png') }}">
{{--  <link rel="stylesheet" href="{{ asset('assets/src/css/dashboard.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('assets/fontawesome-free-5.15.2/css/all.css') }}">
<style>
    .fa-pencil-alt {
        color: #0000FF
    }

    .fa-trash-alt {
        color: #FF0000
    }

    {{-- .fa-check {
        color: #00FF00
    } --}}

    .fa-times {
        color: #FF0000
    }

    .fas {
        cursor: pointer
    }

    table>tbody>tr:hover {
        background: rgba(215, 198, 140, 0.6) !important
    }
</style>
@stop
@section('maincontainer')

@include('painel.shared.menu')

<div class="container-fluid">
    <div class="row mb-10">&nbsp;</div>
    @yield('content')
</div>

@stop
