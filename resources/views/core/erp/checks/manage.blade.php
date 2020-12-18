@extends('jacofda::layouts.app')

@include('jacofda::layouts.elements.title', ['title' => __('Quality Control') . ' ' . __($model->class)])


@section('content')

<div class="row">
    <div class="col-12 col-sm-12">
        {!! Form::open(['url' => url('erp/checklists/'.$model->id.'/'.$model->class)]) !!}
            @include('jacofda::core.erp.checks.mform')
        {!! Form::close() !!}
    </div>
</div>

@stop
