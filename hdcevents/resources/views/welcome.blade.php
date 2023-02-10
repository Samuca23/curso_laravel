@extends('layouts.main')

@section('title', 'HDC Events')

@section('content')
<h1>Teste Laravel</h1>
<img src="/img/img1.jpeg" alt="">
@for($i = 0; $i < count($array); $i++) <p>{{$array[$i]}} - {{$i}}</p>
    @endfor
    @php
    echo $array[1];
    @endphp
    {{-- Comentário Blade --}}
    @foreach($nome as $sNome)
    <p>{{$loop->index}}</p>
    <p>{{$sNome}}</p>
    @endforeach
@endsection