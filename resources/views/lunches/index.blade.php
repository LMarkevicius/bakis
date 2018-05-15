@extends('main')

@section('title', 'Pradinis puslapis')

@section('section')

  <section class="hero">
    <div class="hero-body has-text-centered hero-margin-bottom">
      <h1 class="title">
        Šiandienos Pietų Pasiūlymai
      </h1>
    </div>
  </section>



  @if (count($todayslunches) > 0)


    <div class="row">
      @foreach ($todayslunches as $lunch)
        {{-- {{ dd($lunch->restaurant) }} --}}
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 margin-bottom">
          <div class="card">
            <div class="card-image">
              <a class="button is-primary is-small is-rounded button-weekday">{{ $lunch->weekday }}</a>
              <a class="button is-danger is-small is-rounded button-price">{{ $lunch->price }} €</a>
              <figure class="image is-4by3">
                <img src="{{ asset('images/' . $lunch->image) }}" alt="{{ $lunch->title }}">
              </figure>
            </div>

            <div class="card-content">
              <div class="media">
                <div class="media-left">
                  <figure class="image is-48x48">
                    <img src="{{ asset('images/' . $lunch->restaurant['logo']) }}" alt="{{ $lunch->restaurant['name'] }} logo">
                  </figure>
                </div>

                <div class="media-content">
                  <a href="{{ route('restaurant.show', $lunch->restaurant_id) }}" class="subtitle is-6">{{ $lunch->restaurant['name'] }}</a>
                </div>
              </div>

              <div class="content content-title">
                {{ $lunch->title }}


              </div>
            </div>

            {{-- <a href="{{ route('lunch.show', $lunch->restaurant_id) }}">{{ $lunch->restaurant['name'] }}</a> --}}
            {{-- <img class="card-img-top card-specs" src="{{ asset('images/' . $lunch->image) }}" alt="{{ $lunch->title }} logo"> --}}
            {{-- <div class="card-image" style="background-image: url('/images/{{ $lunch->image }}');"></div> --}}
            {{-- <div class="card-body">
              <p class="card-text">{{ $lunch->title }}</p>
              <a href="#" class="btn btn-primary">{{ $lunch->price }} $</a>
            </div> --}}
          </div>
        </div>
      {{-- </div> --}}
      @endforeach
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="field is-grouped is-grouped-centered">
          <a href="{{ route('todays.deals') }}" class="button is-info">Peržiūrėti Visus</a>
        </div>
      </div>
    </div>
  @else
    <div class="has-text-centered">
      <h2 class="subtitle">Šiuo metu nėra jokių dienos patiekalų</h2>
    </div>
  @endif

  <section class="hero">
    <div class="hero-body has-text-centered">
      <h1 class="title">
        Neseniai Pridėti Dienos Patiekalai
      </h1>
    </div>
  </section>


  @if (count($recentlunches) > 0)
    <div class="row">
      @foreach ($recentlunches as $lunch)
        {{-- {{ dd($lunch->restaurant) }} --}}
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 margin-bottom">
          <div class="card">
            <div class="card-image">
              <a class="button is-primary is-small is-rounded button-weekday">{{ $lunch->weekday }}</a>
              <a class="button is-danger is-small is-rounded button-price">{{ $lunch->price }} €</a>
              <figure class="image is-4by3">
                <img src="{{ asset('images/' . $lunch->image) }}" alt="{{ $lunch->title }}">
              </figure>
            </div>

            <div class="card-content">
              <div class="media">
                <div class="media-left">
                  <figure class="image is-48x48">
                    <img src="{{ asset('images/' . $lunch->restaurant['logo']) }}" alt="{{ $lunch->restaurant['name'] }} logo">
                  </figure>
                </div>

                <div class="media-content">
                  <a href="{{ route('restaurant.show', $lunch->restaurant_id) }}" class="subtitle is-6">{{ $lunch->restaurant['name'] }}</a>
                </div>
              </div>

              <div class="content content-title">
                {{ $lunch->title }}


              </div>
            </div>

            {{-- <a href="{{ route('lunch.show', $lunch->restaurant_id) }}">{{ $lunch->restaurant['name'] }}</a> --}}
            {{-- <img class="card-img-top card-specs" src="{{ asset('images/' . $lunch->image) }}" alt="{{ $lunch->title }} logo"> --}}
            {{-- <div class="card-image" style="background-image: url('/images/{{ $lunch->image }}');"></div> --}}
            {{-- <div class="card-body">
              <p class="card-text">{{ $lunch->title }}</p>
              <a href="#" class="btn btn-primary">{{ $lunch->price }} $</a>
            </div> --}}
          </div>
        </div>
      {{-- </div> --}}
      @endforeach


    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="field is-grouped is-grouped-centered">
          <a href="{{ route('all.deals') }}" class="button is-info">Peržiūrėti Visus</a>
        </div>
      </div>
    </div>
  @else
    <div class="has-text-centered">
      <h2 class="subtitle">Šiuo metu nėra jokių dienos patiekalų</h2>
    </div>
  @endif

@endsection
