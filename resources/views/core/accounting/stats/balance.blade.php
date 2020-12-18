@extends('jacofda::layouts.app')

@section('css')
<style>

</style>
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Bilancio'])

@php
    $Stat = new Jacofda\Klaxon\Models\Stat;
@endphp

@section('content')

    @include('jacofda::core.accounting.stats.components.iva')

    @include('jacofda::core.accounting.stats.components.balance-annual')

    @include('jacofda::core.accounting.stats.components.balance-quarterly')

    @include('jacofda::core.accounting.stats.components.balance-monthly')

@stop

@section('scripts')
    <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
    <script>

    $('a#menu-stats-bilancio').addClass('active');
    $('a#menu-stats-aziende').parent('li').parent('ul.nav-treeview').css('display', 'block');
    $('a#menu-stats-aziende').parent('li').parent('ul').parent('li.has-treeview ').addClass('menu-open');

    </script>
@stop
