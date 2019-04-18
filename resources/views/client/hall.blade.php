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
        <div class="buying__info-hint">
          <p>Тапните дважды,<br>чтобы увеличить</p>
        </div>
      </div>
      <div class="buying-scheme">
        <halls-component :connectionid={{ $connectionid }}></halls-component>


        <div class="buying-scheme__legend">
          <div class="col">
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_standart"></span> Свободно (<span class="buying-scheme__legend-value">250</span>руб)</p>
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_vip"></span> Свободно VIP (<span class="buying-scheme__legend-value">350</span>руб)</p>
          </div>
          <div class="col">
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_taken"></span> Занято</p>
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_selected"></span> Выбрано</p>
          </div>
        </div>

      </div>
      <button class="acceptin-button" onclick="location.href='/client/payment/{{ $connectionid }}'" >Забронировать</button>
    </section>
  </main>
@endsection
