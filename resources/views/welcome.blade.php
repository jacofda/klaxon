@extends('jacofda::layouts.app')

@include('jacofda::layouts.elements.title', ['title' => 'Dashboard'])

@section('content')
    <div class="row">

        @can('companies.read')
            @include('jacofda::home-components.companies')
        @endcan
        @can('contacts.read')
            @include('jacofda::home-components.contacts')
        @endcan

        @can('costs.read')
            @include('jacofda::home-components.costi-in-scadenza')
        @endcan
        @can('invoices.read')
            @include('jacofda::home-components.fatture-in-scadenza')
        @endcan

    </div>
@stop


@section('scripts')
    <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
@stop
