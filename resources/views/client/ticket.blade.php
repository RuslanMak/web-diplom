@extends('layouts.layout')

@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('client-style/css/normalize.css') }}">
  <link rel="stylesheet" href="{{ asset('client-style/css/styles.css') }}">
@endsection

@section('content')
  <main>
    <section class="ticket">

      <header class="tichet__check">
        <h2 class="ticket__check-title">Электронный билет</h2>
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

        {{--<img class="ticket__info-qr" src="{{ asset('client-style/i/qr-code.png') }}">--}}
        <generate-qr-code-component for_qr='{{ json_encode($ticketInfor) }}'></generate-qr-code-component>

        <p class="ticket__hint">Покажите QR-код нашему контроллеру для подтверждения бронирования.</p>
        <p class="ticket__hint">Приятного просмотра!</p>
      </div>
    </section>
  </main>
@endsection
