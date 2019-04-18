@extends('layouts.layout')

@section('stylesheets')
  <link rel="stylesheet" href="{{ asset('admin-style/CSS/normalize.css') }}">
  <link rel="stylesheet" href="{{ asset('admin-style/CSS/styles.css') }}">
@endsection

@section('header')
  <span class="page-header__subtitle">Администраторррская</span>
@endsection

@section('content')
  <main class="conf-steps">
    {{--<section class="conf-step">--}}
      {{--<header class="conf-step__header conf-step__header_opened">--}}
        {{--<h2 class="conf-step__title">Управление залами</h2>--}}
      {{--</header>--}}
      {{--<div class="conf-step__wrapper">--}}
        {{--<p class="conf-step__paragraph">Доступные залы:</p>--}}
        {{--<ul class="conf-step__list">--}}
          {{--{{ $halls }}--}}
          {{--{{ $hallss }}--}}
          {{--@foreach($halls as $hall)--}}
              {{--<li>{{ $hall->hall_name }}--}}
                {{--<form method="POST" action="/admin/hall/{{ $hall->id }}" style="display:inline;">--}}
                  {{--@method('DELETE')--}}
                  {{--@csrf--}}
                  {{--<button type="submit" class="conf-step__button conf-step__button-trash"></button>--}}
                {{--</form>--}}
              {{--</li>--}}

          {{--@endforeach--}}
        {{--</ul>--}}
        {{--<a href="/admin/create"><button class="conf-step__button conf-step__button-accent">Создать зал</button></a>--}}
      {{--</div>--}}
    {{--</section>--}}

    <admin-main-component></admin-main-component>

    {{--<admin-hall-edit-component></admin-hall-edit-component>--}}

    {{--<admin-hall-places-component halls_string='{{ json_encode($halls) }}'></admin-hall-places-component>--}}

    {{--<admin-prices-component halls_string='{{ json_encode($halls) }}'></admin-prices-component>--}}

    {{--<admin-movie-time-component halls_string='{{ json_encode($halls) }}'></admin-movie-time-component>--}}

    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Открыть продажи</h2>
      </header>
      <div class="conf-step__wrapper text-center">
        <p class="conf-step__paragraph">Всё готово, теперь можно:</p>
        <a href="/admin/open-sale"><button class="conf-step__button conf-step__button-accent">Открыть продажу билетов</button></a>
      </div>
    </section>
  </main>
  {{--<script src="{{ asset('admin-style/js/accordeon.js') }}"></script>--}}
@endsection
