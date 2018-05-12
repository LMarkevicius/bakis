@if (Session::has('success'))
  <div class="notification is-success">
    <button class="delete"></button>
    <strong>Sėkmingai:</strong> {{ Session::get('success') }}
  </div>

  {{-- <div class="alert alert-success" role="alert">
    <strong>Success:</strong> {{ Session::get('success') }}
  </div> --}}
@endif

@if (Session::has('error'))
  <div class="notification is-danger">
    <button class="delete"></button>
    <strong>Klaida:</strong> {{ Session::get('error') }}
  </div>

  {{-- <div class="alert alert-success" role="alert">
    <strong>Success:</strong> {{ Session::get('success') }}
  </div> --}}
@endif

@if (Session::has('errors'))
  <div class="notification is-danger">
    <button class="delete"></button>
    <strong>Klaida:</strong>

    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>

  {{-- <div class="alert alert-danger" role="alert">
    <strong>Error:</strong>

    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div> --}}
@endif
