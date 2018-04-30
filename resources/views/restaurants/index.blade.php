@extends('main')

@section('title', 'All Restaurants')

@section('section')

  <section class="hero">
    <div class="hero-body has-text-centered hero-margin-bottom">
      <h1 class="title">
        All Restaurants
      </h1>
      <h2 class="subtitle">{{ count($restaurants) }} different places</h2>
    </div>
  </section>

  <div class="row">
    @foreach ($restaurants as $restaurant)
      <div class="col-sm-12 col-md-4 col-lg-3 margin-bottom">
        <a href="{{ route('restaurant.show', $restaurant->id) }}" class="restaurant-card">
          <div class="card">
            <div class="card-image">
              <figure class="image is-4by3">
                <img src="{{ asset('images/' . $restaurant->logo) }}" alt="{{ $restaurant->name }} logo">
              </figure>
            </div>

            <div class="card-content">
              <div class="media">
                {{-- <div class="media-left">
                  <figure class="image is-48x48">
                    <img src="{{ asset('images/' . $lunch->restaurant['logo']) }}" alt="{{ $lunch->restaurant['name'] }} logo">
                  </figure>
                </div> --}}

                <div class="media-content">
                  <span class="subtitle is-5">{{ $restaurant->name }}</span>
                </div>
              </div>

              <div class="content">
                {{ count($restaurant->lunches) }} Lunch Deals
                {{-- {{ $lunch->title }} --}}
                {{-- <a class="button is-danger is-small is-rounded">{{ $lunch->price }} $</a> --}}
              </div>
            </div>

          </div>
        </a>
      </div>
    @endforeach
  </div>

@endsection
