@extends('layouts.layout')

@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('client-style/css/normalize.css') }}">
  <link rel="stylesheet" href="{{ asset('client-style/css/styles.css') }}">
@endsection

@section('content')
  <main>
    <section class="ticket">

      <header class="tichet__check">
        <h2 class="ticket__check-title">Вы выбрали билеты:</h2>
      </header>

      <div class="ticket__info-wrapper">
        <p class="ticket__info">На фильм: <span class="ticket__details ticket__title">{{ $movie }}</span></p>
        <p class="ticket__info">Места:
            @foreach($places as $place)
              <span class="ticket__details ticket__chairs">
                {{ $place->num_row }}-ряд {{ $place->num_place_in_row }}-место;
              </span>
            @endforeach
        </p>
        <p class="ticket__info">В зале: <span class="ticket__details ticket__hall">{{ $hallName }}</span></p>
        <p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start">{{ $startTime }}</span></p>
        <p class="ticket__info">Стоимость: <span class="ticket__details ticket__cost">{{ $totalPrice }}</span> рублей</p>

        <button class="acceptin-button" onclick="location.href='/client/ticket/{{ $connectionid }}'" >Получить код бронирования</button>

        <p class="ticket__hint">После оплаты билет будет доступен в этом окне, а также придёт вам на почту. Покажите QR-код нашему контроллёру у входа в зал.</p>
        <p class="ticket__hint">Приятного просмотра!</p>
      </div>
    </section>
  </main>
@endsection
