@extends('main')

@section('title', 'Show Lunch Deals')

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
                  {{ request()->has('weekday') ? request('weekday') : 'Weekday' }}
                </a>
                <div class="navbar-dropdown is-boxed is-left">
                  <a href="{{ route('restaurant.show', [$restaurant->id, 'weekday' => 'Monday', 'price' => request('price')]) }}" class="navbar-item {{ request('weekday') == 'Monday' ? 'is-active' : '' }}">
                    Monday
                  </a>
                  <a href="{{ route('restaurant.show', [$restaurant->id, 'weekday' => 'Tuesday', 'price' => request('price')]) }}" class="navbar-item {{ request('weekday') == 'Tuesday' ? 'is-active' : '' }}">
                    Tuesday
                  </a>
                  <a href="{{ route('restaurant.show', [$restaurant->id, 'weekday' => 'Wednesday', 'price' => request('price')]) }}" class="navbar-item {{ request('weekday') == 'Wednesday' ? 'is-active' : '' }}">
                    Wednesday
                  </a>
                  <a href="{{ route('restaurant.show', [$restaurant->id, 'weekday' => 'Friday', 'price' => request('price')]) }}" class="navbar-item {{ request('weekday') == 'Friday' ? 'is-active' : '' }}">
                    Friday
                  </a>

                </div><!-- .navbar-dropdown is-boxed is-left -->
              </div><!-- .navbar-item has-dropdown is-hoverable -->

              <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link {{ request()->has('price') ? 'is-active' : '' }}" href="#">
                  Price Range
                </a>
                <div class="navbar-dropdown is-boxed is-left">
                  @php ($minprice = 0)
                  @php ($maxprice = 5)
                  @while ($maxprice <= 50)
                    <a href="{{ route('restaurant.show', [$restaurant->id, 'weekday' => request('weekday'), 'price' => "$minprice-$maxprice"]) }}" class="navbar-item {{ request('price') == "$minprice-$maxprice" ? 'is-active' : '' }}">
                      {{ $minprice }} - {{ $maxprice }} $
                    </a>

                    @php ($minprice += 5)
                    @php ($maxprice += 5)
                  @endwhile

                </div><!-- .navbar-dropdown is-boxed is-left -->
              </div><!-- .navbar-item has-dropdown is-hoverable -->

            </div><!-- .navbar-start -->

            <div class="navbar-end">
              <a href="{{ route('restaurant.show', $restaurant->id) }}" class="navbar-item">Reset Filter</a>
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
                <a class="button is-danger is-small is-rounded button-price">{{ $lunch->price }} $</a>
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
            Contacts
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
