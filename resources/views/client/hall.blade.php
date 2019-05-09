@extends('layouts.layout')

@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('client-style/css/normalize.css') }}">
  <link rel="stylesheet" href="{{ asset('client-style/css/styles.css') }}">
@endsection

@section('content')
  <main>
    <section class="buying">
      <div class="buying__info">
        <div class="buying__info-description">

          {{--<h1>{{ request()->user()->role }}</h1>--}}
          {{--<h1>{{ Auth::user()->email }}</h1>--}}

          <h2 class="buying__info-title">{{ $movieName }}</h2>
          <p class="buying__info-start">Начало сеанса: {{ $startTime }}</p>
          <p class="buying__info-hall">{{ $hall->hall_name }}</p>
        </div>
        {{--<div class="buying__info-hint">--}}
          {{--<p>Тапните дважды,<br>чтобы увеличить</p>--}}
        {{--</div>--}}
      </div>
      <div class="buying-scheme">
        <halls-component :connectionid={{ $connectionid }}></halls-component>

      </div>
      <button class="acceptin-button" onclick="location.href='/client/payment/{{ $connectionid }}'" >Забронировать</button>
    </section>
  </main>
@endsection
