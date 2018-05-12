@extends('main')

@section('title', "Šiandienos pietūs")

@section('section')

  <section class="hero">
    <div class="hero-body has-text-centered hero-margin-bottom">
      <h1 class="title">
        Šiandienos Pietūs
      </h1>
    </div>
  </section>

  <div class="row">

    <nav class="navbar navbar-filter is-light" role="navigation">

      <div id="navbar-danger" class="navbar-menu">
        <div class="navbar-start">

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link {{ request()->has('restaurant_id') ? 'is-active' : '' }}" href="#">
              Restoranas
            </a>
            <div class="navbar-dropdown is-boxed is-left">
              @foreach ($restaurants as $restaurant)
                <a href="{{ route('todays.deals', ['restaurant_id' => $restaurant->id, 'from' => request('from'), 'to' => request('to')]) }}" class="navbar-item {{ request('restaurant_id') == $restaurant->id ? 'is-active' : '' }}">
                  {{ $restaurant->name }}
                </a>
              @endforeach
            </div><!-- .navbar-dropdown is-boxed is-left -->
          </div><!-- .navbar-item has-dropdown is-hoverable -->

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link {{ request()->has('from') ? 'is-active' : '' }}" href="#">
              Kaina nuo
            </a>
          {{-- </div>
          <div class="navbar-item"> --}}




            <div class="navbar-dropdown is-boxed is-left">
              @php ($minprice = 0)
              {{-- @php ($maxprice = 1) --}}
              @while ($minprice <= 10)
                <a href="{{ route('todays.deals', ['restaurant_id' => request('restaurant_id'), 'from' => $minprice, 'to' => request('to')]) }}" class="navbar-item {{ request('from') == "$minprice" ? 'is-active' : '' }}">
                  {{ $minprice }} €
                </a>

                @php ($minprice += 1)
                {{-- @php ($maxprice += 1) --}}
              @endwhile

            </div><!-- .navbar-dropdown is-boxed is-left -->
          </div><!-- .navbar-item has-dropdown is-hoverable -->

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link {{ request()->has('to') ? 'is-active' : '' }}" href="#">
              iki
            </a>
          {{-- </div>
          <div class="navbar-item"> --}}




            <div class="navbar-dropdown is-boxed is-left">
              {{-- @php ($minprice = 0) --}}
              @php ($maxprice = 1)
              @while ($maxprice <= 10)
                <a href="{{ route('todays.deals', ['restaurant_id' => request('restaurant_id'), 'from' => request('from'), 'to' => $maxprice]) }}" class="navbar-item {{ request('to') == $maxprice ? 'is-active' : '' }}">
                  {{ $maxprice }} €
                </a>

                {{-- @php ($minprice += 1) --}}
                @php ($maxprice += 1)
              @endwhile

            </div><!-- .navbar-dropdown is-boxed is-left -->
          </div><!-- .navbar-item has-dropdown is-hoverable -->

        </div><!-- .navbar-start -->

        <div class="navbar-end">
          <a href="{{ route('todays.deals') }}" class="navbar-item">Panaikinti filtrą</a>
        </div><!-- .navbar-end -->
      </div><!-- .navbar-menu -->
    </nav><!-- .navbar navbar-filter is-light -->
  </div><!-- .row -->


  @if (count($lunches) > 0)
    <div class="row">
      @foreach ($lunches as $lunch)
        <div class="col-sm-12 col-md-4 col-lg-3 margin-bottom">
          <div class="card">
            <div class="card-image">
              <a class="button is-primary is-small is-rounded button-weekday">{{ $lunch->weekday }}</a>
              <a class="button is-danger is-small is-rounded button-price">{{ $lunch->price }} €</a>
              <figure class="image is-4by3">
                <img src="{{ asset('images/' . $lunch->image) }}" alt="{{ $lunch->title }}">
              </figure>
            </div><!-- .media-image -->

            <div class="card-content">
              <div class="media">
                <div class="media-left">
                  <figure class="image is-48x48">
                    <img src="{{ asset('images/' . $lunch->restaurant['logo']) }}" alt="{{ $lunch->restaurant['name'] }} logo">
                  </figure>
                </div><!-- .media-left -->

                <div class="media-content">
                  <a href="{{ route('restaurant.show', $lunch->restaurant_id) }}" class="subtitle is-6">{{ $lunch->restaurant['name'] }}</a>
                </div><!-- .media-content -->
              </div><!-- .media -->

              <div class="content content-title">
                {{ $lunch->title }}
              </div><!-- .content content-title -->
            </div><!-- .card-content -->
          </div><!-- .card -->
        </div><!-- .col-sm-12 col-md-4 col-lg-3 margin-bottom -->
      @endforeach
    </div><!-- .row -->

    <div class="row">
      <div class="col-sm-12">
        {{ $lunches->links('partials._pagination') }}
      </div><!-- .col-sm-12 -->
    </div><!-- .row -->
  @else
    <div class="has-text-centered">
      <h2 class="subtitle">Šiuo metu nėra jokių dienos patiekalų</h2>
    </div><!-- .has-text-centered -->
  @endif

@endsection
