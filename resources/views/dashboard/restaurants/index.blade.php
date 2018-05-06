@extends('main')

@section('title', 'All Restaurants')

@section('section')

  <section class="hero">
    <div class="hero-body has-text-centered hero-margin-bottom">
      <h1 class="title">
        Dashboard All Restaurants
      </h1>
      <h2 class="subtitle">{{ count($restaurants) }} different places</h2>
    </div>
  </section>

  {{-- <table class="table is-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
      </tr>
    </thead>

    <tbody>
      @foreach($restaurants as $key => $restaurant)
        <tr>
          <td>{{ $key + 1 }}</td>
          <td>
            <img src="{{ asset('images/' . $restaurant->logo) }}" alt="{{ $restaurant->name }} logo" class="table-logo" />
            <a href="{{ route('lunch.show', $restaurant->id) }}">{{ $restaurant->name }}
            </td>
        </tr>
      @endforeach
    </tbody>

  </table> --}}

  <div class="row">
    <div class="col-sm-12 col-md-8 col-md-offset-2">
      <h2 class="subtitle">Results</h2>

      
      {{-- {{ preg_match("/\d{4}\-\d{2}\-\d{2} ([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?/", $content, $matches) }} --}}
      {{-- @foreach ($matches as $m)
        {{ $m }}
      @endforeach --}}
    </div>
  </div>

  <div class="row">
    <div class="col-sm-12 col-md-8 col-md-offset-2">
      <table class="table is-striped is-fullwidth">
        <thead>
          <tr>
            <th>#</th>
            <th>Logo</th>
            <th>Restaurant</th>
            <th>Lunches</th>
            <th>Contacts</th>
            <th>Actions</th>
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
                <a href="{{ route('dashboard.edit', $restaurant->id) }}" class="button is-info is-small is-fullwidth">
                  <span class="icon left">
                    <i class="fas fa-pencil-alt"></i>
                  </span>
                  Edit
                </a>

                {!! Form::open(['route' => ['dashboard.destroy', $restaurant->id], 'method' => 'DELETE']) !!}
                  <button type="submit" class="button is-danger is-small is-fullwidth">
                    <span class="icon left">
                      <i class="fas fa-trash-alt"></i>
                    </span>
                    Delete
                  </button>
                {!! Form::close() !!}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

@endsection
