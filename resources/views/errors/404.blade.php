@extends('layout')
@section('content')
<div class="wrapper row2">
    <div id="container" class="clear">
        <section id="fof" class="clear">
            <h1>WHOOPS!</h1>
            <img src="/images/404.png" alt="">
            <p>Страница которую Вы ищете, нет на даном веб сервере</p>
            <p>Вернуться назад
                <a href="javascript:history.go(-1)">
                    на предидущую страницу
                </a>
                или посетите нашу
                <a href="{{route('post.index')}}">домашнюю страницу</a>
            </p>

        </section>
    </div>
</div>
@endsection