<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="stylesheet" href="/css/style.css">
        <script src="/js/script.js"></script>
    </head>
    <body>
        <h1>Teste Laravel</h1>
        <img src="/img/img1.jpeg" alt="">
            @for($i = 0; $i < count($array); $i++)
                <p>{{$array[$i]}} - {{$i}}</p>
            @endfor
            @php 
                echo $array[1];
            @endphp
            {{-- Comentário Blade --}}
            @foreach($nome as $sNome)
            <p>{{$loop->index}}</p>
            <p>{{$sNome}}</p>
            @endforeach
    </body>
</html>
