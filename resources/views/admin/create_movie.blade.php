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
        <h2 class="conf-step__title">Создание фильма</h2>
      </header>

      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Заполните данные:</p>
        <form class="" action="{{ route('image.upload') }}" method="post" enctype="multipart/form-data">
           @csrf

          <div class="">
            <input class="conf-step__input" type="text" name="name" value="" placeholder="Movie title" style="width:400px;" required>
          </div>

          <div class="">
            <input  class="conf-step__input" type="text" name="description" value="" placeholder="Description" style="width:400px;" required>
          </div>

          <div class="">
            <input class="conf-step__input" type="number" name="runtime" value="" placeholder="Runtime" style="width:400px;" required>
          </div>

          <div class="">
            <input class="conf-step__input" type="text" name="country" value="" placeholder="Country" style="width:400px;" required>
          </div>

          <div class="">
            <input class="conf-step__input" type="file" name="image" value="" placeholder="image" style="width:400px;">
          </div>

          <div class="">
            <button class="conf-step__button conf-step__button-accent" type="submit">Создать фильм</button>
          </div>

        </form>
      </div>

    </section>

    @isset($path)
      <img class="conf-step__movie-poster" alt="poster" src="{{ asset('/storage/' . $path) }}">
    @endisset
  <main>
@endsection
