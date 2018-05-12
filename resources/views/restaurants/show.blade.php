@extends('main')

@section('title', 'Parodyti dienos pasiūlymus')

@section('section')
  {{-- {{ dd($contacts) }} --}}

  <section class="hero">
    <div class="hero-body has-text-centered">
      <div class="row hero-flex">
        {{-- <div class="col-md-3"> --}}
          <figure class="image">
            <img src="{{ asset('images/' . $restaurant->logo) }}" alt="{{ $restaurant->name }} logo" style="width: 200px;">
          </figure>
        {{-- </div> --}}

        {{-- <div class="col-md-6"> --}}
          <a target="_blank" href="{{ $restaurant->website }}">
            <h1 class="title">
              {{ $restaurant->name }}
            </h1>
          </a>
        {{-- </div> --}}
      </div>
    </div>
  </section>

  <div class="row">
    <div class="col-lg-8 col-sm-12">
      <div class="row">

        <nav class="navbar navbar-filter is-light" role="navigation">


          <div id="navbar-danger" class="navbar-menu">
            <div class="navbar-start">

              <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link {{ request()->has('weekday') ? 'is-active' : '' }}" href="#">
                  {{ request()->has('weekday') ? request('weekday') : 'Savaitės diena' }}
                </a>
                <div class="navbar-dropdown is-boxed is-left">
                  <a href="{{ route('restaurant.show', [$restaurant->id, 'weekday' => 'Pirmadienis', 'from' => request('from'), 'to' => request('to')]) }}" class="navbar-item {{ request('weekday') == 'Pirmadienis' ? 'is-active' : '' }}">
                    Pirmadienis
                  </a>
                  <a href="{{ route('restaurant.show', [$restaurant->id, 'weekday' => 'Antradienis', 'from' => request('from'), 'to' => request('to')]) }}" class="navbar-item {{ request('weekday') == 'Antradienis' ? 'is-active' : '' }}">
                    Antradienis
                  </a>
                  <a href="{{ route('restaurant.show', [$restaurant->id, 'weekday' => 'Trečiadienis', 'from' => request('from'), 'to' => request('to')]) }}" class="navbar-item {{ request('weekday') == 'Trečiadienis' ? 'is-active' : '' }}">
                    Trečiadienis
                  </a>
                  <a href="{{ route('restaurant.show', [$restaurant->id, 'weekday' => 'Ketvirtadienis', 'from' => request('from'), 'to' => request('to')]) }}" class="navbar-item {{ request('weekday') == 'Ketvirtadienis' ? 'is-active' : '' }}">
                    Ketvirtadienis
                  </a>
                  <a href="{{ route('restaurant.show', [$restaurant->id, 'weekday' => 'Penktadienis', 'from' => request('from'), 'to' => request('to')]) }}" class="navbar-item {{ request('weekday') == 'Penktadienis' ? 'is-active' : '' }}">
                    Penktadienis
                  </a>

                </div><!-- .navbar-dropdown is-boxed is-left -->
              </div><!-- .navbar-item has-dropdown is-hoverable -->

              <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link {{ request()->has('from') ? 'is-active' : '' }}" href="#">
                  Kaina nuo
                </a>

                <div class="navbar-dropdown is-boxed is-left">
                  @php ($minprice = 0)
                  {{-- @php ($maxprice = 1) --}}
                  @while ($minprice <= 10)
                    <a href="{{ route('restaurant.show', [$restaurant->id, 'weekday' => request('weekday'), 'from' => $minprice, 'to' => request('to')]) }}" class="navbar-item {{ request('from') == "$minprice" ? 'is-active' : '' }}">
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

                <div class="navbar-dropdown is-boxed is-left">
                  {{-- @php ($minprice = 0) --}}
                  @php ($maxprice = 1)
                  @while ($maxprice <= 10)
                    <a href="{{ route('restaurant.show', [$restaurant->id, 'weekday' => request('weekday'), 'from' => request('from'), 'to' => $maxprice]) }}" class="navbar-item {{ request('to') == $maxprice ? 'is-active' : '' }}">
                      {{ $maxprice }} €
                    </a>

                    {{-- @php ($minprice += 1) --}}
                    @php ($maxprice += 1)
                  @endwhile

                </div><!-- .navbar-dropdown is-boxed is-left -->
              </div><!-- .navbar-item has-dropdown is-hoverable -->

            </div><!-- .navbar-start -->

            <div class="navbar-end">
              <a href="{{ route('restaurant.show', $restaurant->id) }}" class="navbar-item">Panaikinti filtrą</a>
            </div><!-- .navbar-end -->
          </div><!-- .navbar-menu -->
        </nav><!-- .navbar navbar-filter is-light -->
      </div><!-- .row -->

      <div class="row">
        @foreach ($lunches as $lunch)
          <div class="col-xs-12 col-sm-6 col-md-4 margin-bottom">
            <div class="card">
              <div class="card-image">
                <a class="button is-primary is-small is-rounded button-weekday">{{ $lunch->weekday }}</a>
                <a class="button is-danger is-small is-rounded button-price">{{ $lunch->price }} €</a>
                <figure class="image is-4by3">
                  <img src="{{ asset('images/' . $lunch->image) }}" alt="{{ $lunch->title }}">
                </figure>
              </div><!-- .media-image -->

              <div class="card-content">
                <div class="content content-title">
                  {{ $lunch->title }}
                </div><!-- .content content-title -->
              </div><!-- .card-content -->
            </div><!-- .card -->
          </div><!-- .col-sm-12 col-md-4 col-lg-3 margin-bottom -->
        @endforeach
      </div><!-- .row -->

      <div class="row margin-bottom">
        <div class="col-sm-12">
          {{ $lunches->links('partials._pagination') }}
        </div><!-- .col-sm-12 -->
      </div><!-- .row -->
    </div><!-- .col-lg-8 col-sm-12 -->

    <div class="col-lg-4 col-sm-12">
      @if (count($restaurant->contacts) > 0)
        <nav class="panel">
          <p class="panel-heading">
            Kontaktai
          </p>

          {{-- <p class="panel-tabs">
            <a class="is-active">all</a>
            <a>public</a>
            <a>private</a>
            <a>sources</a>
            <a>forks</a>
          </p> --}}
          @foreach ($restaurant->contacts as $contact)
            <a class="panel-block">
              <span class="panel-icon">
                <i class="fas fa-home"></i>
              </span>
              {{ $contact->address }}
            </a>

            <a class="panel-block">
              <span class="panel-icon">
                <i class="fas fa-map-marker"></i>
              </span>
              {{ $contact->city }}
            </a>

            <a class="panel-block">
              <span class="panel-icon">
                <i class="fas fa-phone"></i>
              </span>
              {{ $contact->phone }}
            </a>
          @endforeach
        </nav>

      @endif
    </div>
  </div>

@endsection
