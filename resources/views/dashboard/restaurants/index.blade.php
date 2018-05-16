@extends('main')

@section('title', 'Administratoriaus Apžvalga')

@section('section')

  <section class="hero is-dark">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">
          Administratoriaus Apžvalga
        </h1>
        <h2 class="subtitle">
          <nav class="breadcrumb is-medium" aria-label="breadcrumbs">
            <ul>
              <li class="is-active"><a href="{{ route('dashboard.index') }} aria-current="page"">Administratoriaus Apžvalga</a></li>
            </ul>
          </nav>
        </h2>
      </div>
    </div>
  </section>

  <div class="container">
    @include('partials._messages')
  </div>

  <section class="section">

    <div class="container">

      <div class="row">
        <div class="col-sm-12 col-md-8 col-md-offset-2">
          <section class="hero">
            <div class="hero-body has-text-centered">
              <h1 class="title">
                Duomenų Surinkimo Rezultatai
                <a href="{{ route('dashboard.download') }}" class="button is-small is-primary"><span class="icon is-small"><i class="fas fa-download"></i></span></a>
              </h1>

              <nav class="level">
                <div class="level-item has-text-centered">
                  <div>
                    <p class="heading">Sutampantys</p>
                    <p class="title">{{ $count['match'] }}</p>
                  </div>
                </div>
                <div class="level-item has-text-centered">
                  <div>
                    <p class="heading">Egzistuojantys</p>
                    <p class="title">{{ $count['exists'] }}</p>
                  </div>
                </div>
                <div class="level-item has-text-centered">
                  <div>
                    <p class="heading">Atnaujinti</p>
                    <p class="title">{{ $count['updated'] }}</p>
                  </div>
                </div>
                <div class="level-item has-text-centered">
                  <div>
                    <p class="heading">Nauji</p>
                    <p class="title">{{ $count['new'] }}</p>
                  </div>
                </div>
                <div class="level-item has-text-centered">
                  <div>
                    <p class="heading">Klaidos</p>
                    <p class="title">{{ $count['error'] }}</p>
                  </div>
                </div>
              </nav>
            </div>
          </section>
        </div>
      </div>


      <section class="hero">
        <div class="hero-body has-text-centered">
          <h1 class="title">
            Visi Restoranai
          </h1>
          <h2 class="subtitle">{{ count($restaurants) }} skirtingos vietos</h2>
        </div>
      </section>

      <div class="row hero-margin-bottom">
        <div class="col-sm-12 col-md-8 col-md-offset-2">
          <table class="table is-striped is-fullwidth">
            <thead>
              <tr>
                <th>#</th>
                <th>Logotipas</th>
                <th>Restoranas</th>
                <th>Patiekalai</th>
                <th>Kontaktai</th>
                <th>Klaidos</th>
                <th>Veiksmai</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($restaurants as $key => $restaurant)
                <tr>
                  <td>{{ $key + 1 }}</td>
                  <td>
                    <figure class="image is-48x48">
                      <img src="{{ asset('images/' . $restaurant->logo) }}" alt="{{ $restaurant->name }} logo">
                    </figure>
                  </td>
                  <td>{{ $restaurant->name }}</td>
                  <td>{{ $restaurant->lunches->count() }}</td>
                  <td>{{ $restaurant->contacts->count() }}</td>
                  <td>

                    @php $count = 0 @endphp
                    @foreach ($restaurant->lunches as $lunch)

                      @if (count($lunch->xpaths) > 0)
                        @if ($lunch->xpaths[0]->status == "NOT OK")
                          @php $count++ @endphp
                        @endif
                      @endif
                    @endforeach

                    @if ($count > 0)
                      <span class="tag is-danger">{{ $count }}</span>
                    @else
                      <span class="tag">{{ $count }}</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{ route('dashboard.edit', $restaurant->id) }}" class="button is-info is-small is-fullwidth">
                      <span class="icon left">
                        <i class="fas fa-pencil-alt"></i>
                      </span>
                      Redaguoti
                    </a>

                    {!! Form::open(['route' => ['dashboard.destroy', $restaurant->id], 'method' => 'DELETE']) !!}
                      <button type="submit" class="button is-danger is-small is-fullwidth">
                        <span class="icon left">
                          <i class="fas fa-trash-alt"></i>
                        </span>
                        Ištrinti
                      </button>
                    {!! Form::close() !!}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </section>

@endsection
