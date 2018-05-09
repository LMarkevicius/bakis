<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>

    @include('partials._header')

  </head>
  <body>

    @include('partials._nav')

    @if (Request::is('dashboard/*'))
      @yield('section')
    @else
      <div class="container">
        @include('partials._messages')
      </div>

      <section class="section">

        <div class="container">

          @yield('section')

        </div>

      </section>
    @endif



    @include('partials._footer')

  </body>
</html>
