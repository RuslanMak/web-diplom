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
    <section class="conf-step">

      <header class="conf-step__header">
        <h2 class="conf-step__title">Создание зала</h2>
      </header>

      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Название зала:</p>
        <form class="" action="/admin/hall" method="post">
           @csrf

          <div class="">
            <input  class="conf-step__input" type="text" name="hall_name" value="" placeholder="Hall title" style="width:400px;">
          </div>

          <div class="">
            <button class="conf-step__button conf-step__button-accent" type="submit">Создать зал</button>
          </div>

        </form>
      </div>

    </section>
  <main>
@endsection
