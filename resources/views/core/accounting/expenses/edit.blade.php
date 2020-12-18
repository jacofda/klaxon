@extends('jacofda::layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{config('app.url')}}expenses">Spese</a></li>
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Modifica Spesa'])


@section('content')

    {!! Form::model($expense, ['url' => $expense->url, 'autocomplete' => 'off', 'method' => 'PATCH', 'id' => 'expenseForm']) !!}
        <div class="row">
            @include('jacofda::components.errors')
            @include('jacofda::core.accounting.expenses.form')
        </div>
    {!! Form::close() !!}

@stop
