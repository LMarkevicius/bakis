@extends('main')

@section('title', 'All Deals')

@section('section')

  <section class="hero">
    <div class="hero-body has-text-centered hero-margin-bottom">
      <h1 class="title">
        All Deals
      </h1>
    </div>
  </section>

  <div class="row">

    <nav class="navbar navbar-filter is-light" role="navigation">


      <div id="navbar-danger" class="navbar-menu">
        <div class="navbar-start">

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link {{ request()->has('weekday') ? 'is-active' : '' }}" href="#">
              {{ request()->has('weekday') ? request('weekday') : 'Weekday' }}
            </a>
            <div class="navbar-dropdown is-boxed is-left">
              <a href="{{ route('all.deals', ['restaurant_id' => request('restaurant_id'), 'weekday' => 'Monday', 'price' => request('price')]) }}" class="navbar-item {{ request('weekday') == 'Monday' ? 'is-active' : '' }}">
                Monday
              </a>
              <a href="{{ route('all.deals', ['restaurant_id' => request('restaurant_id'), 'weekday' => 'Tuesday', 'price' => request('price')]) }}" class="navbar-item {{ request('weekday') == 'Tuesday' ? 'is-active' : '' }}">
                Tuesday
              </a>
              <a href="{{ route('all.deals', ['restaurant_id' => request('restaurant_id'), 'weekday' => 'Wednesday', 'price' => request('price')]) }}" class="navbar-item {{ request('weekday') == 'Wednesday' ? 'is-active' : '' }}">
                Wednesday
              </a>
              <a href="{{ route('all.deals', ['restaurant_id' => request('restaurant_id'), 'weekday' => 'Friday', 'price' => request('price')]) }}" class="navbar-item {{ request('weekday') == 'Friday' ? 'is-active' : '' }}">
                Friday
              </a>

            </div><!-- .navbar-dropdown is-boxed is-left -->
          </div><!-- .navbar-item has-dropdown is-hoverable -->

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link {{ request()->has('restaurant_id') ? 'is-active' : '' }}" href="#">
              Restaurant
            </a>
            <div class="navbar-dropdown is-boxed is-left">
              @foreach ($restaurants as $restaurant)
                <a href="{{ route('all.deals', ['restaurant_id' => $restaurant->id, 'weekday' => request('weekday'), 'price' => request('price')]) }}" class="navbar-item {{ request('restaurant_id') == $restaurant->id ? 'is-active' : '' }}">
                  {{ $restaurant->name }}
                </a>
              @endforeach
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
                <a href="{{ route('all.deals', ['restaurant_id' => request('restaurant_id'), 'weekday' => request('weekday'), 'price' => "$minprice-$maxprice"]) }}" class="navbar-item {{ request('price') == "$minprice-$maxprice" ? 'is-active' : '' }}">
                  {{ $minprice }} - {{ $maxprice }} $
                </a>

                @php ($minprice += 5)
                @php ($maxprice += 5)
              @endwhile

            </div><!-- .navbar-dropdown is-boxed is-left -->
          </div><!-- .navbar-item has-dropdown is-hoverable -->

        </div><!-- .navbar-start -->

        <div class="navbar-end">
          <a href="{{ route('all.deals') }}" class="navbar-item">Reset Filter</a>
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
              <a class="button is-danger is-small is-rounded button-price">{{ $lunch->price }} $</a>
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
      <h2 class="subtitle">There are no lunch deals at this moment ;(</h2>
    </div><!-- .has-text-centered -->
  @endif

@endsection
