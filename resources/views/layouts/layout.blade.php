<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>ИдёмВКино</title>
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Styles -->
  {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
  @yield('stylesheets')
  {{--<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">--}}
</head>

<body>

  <header class="page-header">
    <h1 class="page-header__title"><a href="/" style="all:inherit; cursor:pointer;">Идём<span>в</span>кино</a></h1>
    @yield('header')
  </header>

  <div id="app">
    @yield('content')
  </div>

  @yield('scripts')
</body>
</html>
