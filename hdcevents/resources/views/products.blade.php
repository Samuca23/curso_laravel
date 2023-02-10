@extends('layouts.main')

@section('title', 'Produto')

@section('content')

<h1>Produtos</h1>

@if($busca = 'camisa')
 <p>{{$busca}}</p> 
@endif
@endsection
