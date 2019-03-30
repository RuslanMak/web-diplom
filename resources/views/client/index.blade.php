@extends('layouts.layout')

@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('client-style/css/normalize.css') }}">
  <link rel="stylesheet" href="{{ asset('client-style/css/styles.css') }}">
@endsection

@section('content')
  <nav class="page-nav">
    <a class="page-nav__day page-nav__day_today" href="#">
      <span class="page-nav__day-week">Пн</span><span class="page-nav__day-number">31</span>
    </a>
    <a class="page-nav__day" href="#">
      <span class="page-nav__day-week">Вт</span><span class="page-nav__day-number">1</span>
    </a>
    <a class="page-nav__day page-nav__day_chosen" href="#">
      <span class="page-nav__day-week">Ср</span><span class="page-nav__day-number">2</span>
    </a>
    <a class="page-nav__day" href="#">
      <span class="page-nav__day-week">Чт</span><span class="page-nav__day-number">3</span>
    </a>
    <a class="page-nav__day" href="#">
      <span class="page-nav__day-week">Пт</span><span class="page-nav__day-number">4</span>
    </a>
    <a class="page-nav__day page-nav__day_weekend" href="#">
      <span class="page-nav__day-week">Сб</span><span class="page-nav__day-number">5</span>
    </a>
    <a class="page-nav__day page-nav__day_next" href="#">
    </a>
  </nav>

  <main>
    {{--данные фильма--}}
    @foreach ($movies as $movie)
      <section class="movie">
        <div class="movie__info">
          <div class="movie__poster">
            <img class="movie__poster-image" alt="Звёздные войны постер" src="{{ asset( $movie->image ) }}">
          </div>
          <div class="movie__description">
            <h2 class="movie__title">{{ $movie->name }}</h2>
            <p class="movie__synopsis">{{ $movie->description }}</p>
            <p class="movie__data">
              <span class="movie__data-duration">{{ $movie->runtime }} минут</span>
              <span class="movie__data-origin">{{ $movie->country }}</span>
            </p>
          </div>
        </div>

        {{--данние зала и время начала фильма--}}
        <div class="movie-seances__hall">
          @foreach ($halls as $hall)

            <h3 class="movie-seances__hall-title">{{$hall->hall_name}}</h3>
            <ul class="movie-seances__list">
              @foreach ($timesOfMovie as $time)
                @if($time->id_movie === $movie->id && $time->id_hall === $hall->id)
                  <li class="movie-seances__time-block"><a class="movie-seances__time" href="client/hall/{{$time->id}}">{{$time->start_time}}</a></li>
                @endif
              @endforeach
            </ul>
          @endforeach
        </div>

      </section>
    @endforeach

  </main>
@endsection
