@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}erp/ddt">DDT</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => __('Edit') . ' DDT'])


@section('content')

    {!! Form::model($ddt, ['url' => route('erp.ddt.update', $ddt->id), 'autocomplete' => 'off', 'method' => 'PATCH', 'id' => 'ddtForm']) !!}
        <div class="row">
            @include('jacofda::components.errors')
            @include('jacofda::core.erp.ddts.form.form')
        </div>
    {!! Form::close() !!}

@stop

@section('scripts')
<script>
    $('a#menu-erp-ddt').addClass('active');
</script>
@stop
