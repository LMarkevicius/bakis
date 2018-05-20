@extends('main')

@section('title', 'Redaguoti Restoraną')

@section('section')
  @php setlocale(LC_TIME, "lt_LT.UTF8") @endphp

  <section class="hero is-dark">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">
          Redaguoti "{{ $restaurant->name }}" Restoraną
        </h1>

        <h2 class="subtitle">
          <nav class="breadcrumb is-medium" aria-label="breadcrumbs">
            <ul>
              <li><a href="{{ route('dashboard.index') }}">Administratoriaus Apžvalga</a></li>
              <li class="is-active"><a href="" aria-current="page">Redaguoti Restoraną</a></li>
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
        <div class="col-xs-12 col-md-10 col-md-offset-1">
          {!! Form::model($restaurant, ['route' => ['dashboard.update', $restaurant->id], 'method' => 'PUT', 'files' => true]) !!}
            <div class="field">
              {{ Form::label('name', 'Restorano pavadinimas', ['class' => 'label']) }}

              <div class="control is-expanded has-icons-left">
                {{ Form::text('name', null, ['class' => 'input']) }}
                <span class="icon is-small is-left">
                  <i class="fas fa-utensils"></i>
                </span>
              </div>
            </div>

            <div class="field">
              {{ Form::label('website', 'Tinklalapio nuoroda', ['class' => 'label']) }}

              <div class="control is-expanded has-icons-left">
                {{ Form::text('website', null, ['class' => 'input']) }}
                <span class="icon is-small is-left">
                  <i class="fas fa-globe"></i>
                </span>
              </div>
            </div>

            <div class="field">
              <div class="file has-name">
                <label class="file-label">
                  <input type="file" name="logo" class="file-input" id="logo-file">

                  <span class="file-cta">
                    <span class="file-icon">
                      <i class="fas fa-upload"></i>
                    </span>

                    <span class="file-label">Pasirinkite logotipą...</span>
                  </span>

                  <span class="file-name" id="file-name">{{ $restaurant->logo }}</span>
                </label>
              </div>
            </div>

            <div class="field is-grouped is-grouped-centered">
              <p class="control">
                {{ Form::submit('Atnaujinti Restoraną', ['class' => 'button is-success']) }}
              </p>

              <p class="control">
                <a href="{{ route('dashboard.index') }}" class="button is-light">Atšaukti</a>
              </p>
            </div>

          {!! Form::close() !!}
        </div>
      </div>

      <section class="hero">
        <div class="hero-body has-text-centered">
          <h2 class="subtitle is-4">
            Kontaktai

            <a href="{{ route('contact.create', $restaurant->id) }}" class="button is-primary is-small">
              <span class="icon">
                <i class="fas fa-plus"></i>
              </span>
              Pridėti naujus
            </a>
          </h2>
        </div>
      </section>

      <div class="row">
        <div class="col-xs-12 col-md-10 col-md-offset-1">
          @if (count($restaurant->contacts) > 0)
            <table class="table is-striped is-fullwidth">
              <thead>
                <tr>
                  <th>Adresas</th>
                  <th>Miestas</th>
                  <th>Telefono numeris</th>
                  <th>Veiksmai</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($restaurant->contacts as $contact)
                  <tr>
                    <td>{{ $contact->address }}</td>
                    <td>{{ $contact->city }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>
                      <a href="{{ route('contact.edit', [$restaurant->id, $contact->id]) }}" class="button is-info is-small is-fullwidth">
                        <span class="icon left">
                          <i class="fas fa-pencil-alt"></i>
                        </span>
                        Redaguoti kontaktą
                      </a>

                      {!! Form::open(['route' => ['contact.destroy', $restaurant->id, $contact->id], 'method' => 'DELETE']) !!}

                        <button type="submit" class="button is-danger is-small is-fullwidth">
                          <span class="icon left">
                            <i class="fas fa-trash-alt"></i>
                          </span>
                          Ištrinti kontaktą
                        </button>

                      {!! Form::close() !!}
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @else
            <div class="has-text-centered">
              Nėra pridėtų kontaktų
            </div>
          @endif
        </div>
      </div>

      <section class="hero" id="modal-place">
        <div class="hero-body has-text-centered">
          <h2 class="subtitle is-4">
            Patiekalai

            <a href="{{ route('lunch.create', $restaurant->id) }}" class="button is-primary is-small">
              <span class="icon">
                <i class="fas fa-plus"></i>
              </span>
              Pridėti naujus
            </a>
          </h2>
        </div>
      </section>

      <div class="row hero-margin-bottom">
        <div class="col-xs-12 col-md-10 col-md-offset-1">

          @if (count($restaurant->lunches) > 0)
            <table class="table is-striped is-fullwidth">
              <thead>
                <tr>
                  <th>Nuotrauka</th>
                  <th>Pavadinimas</th>
                  <th>Kaina</th>
                  <th>Veiksmai</th>
                  <th>Statusas</th>
                  <th>Patikrinimo data</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($lunchesByWeekday as $weekday => $lunches)
                  <tr>
                    <th colspan="6">{{ $weekday }}<small> ({{ count($lunches) }} {{ count($lunches) > 10 ? 'patiekalų' : 'patiekalai' }})</small></th>
                  </tr>

                  @foreach ($lunches as $lunch)
                    <tr>
                      <td><img src="{{ asset('images/' . $lunch->image) }}" class="table-logo" /></td>
                      <td>{{ $lunch->title }}</td>
                      <td>{{ $lunch->price }} €</td>
                      <td>
                        <a href="{{ route('lunch.edit', [$restaurant->id, $lunch->id]) }}" class="button is-info is-small is-fullwidth">
                          <span class="icon left">
                            <i class="fas fa-pencil-alt"></i>
                          </span>
                          Redaguoti
                        </a>

                        {!! Form::open(['route' => ['lunch.destroy', $restaurant->id, $lunch->id], 'method' => 'DELETE']) !!}
                          <button type="submit" class="button is-danger is-small is-fullwidth">
                            <span class="icon left">
                              <i class="fas fa-trash-alt"></i>
                            </span>
                            Ištrinti
                          </button>
                        {!! Form::close() !!}
                      </td>
                      <td>
                        @if ($lunch->xpaths)
                          @foreach ($lunch->xpaths as $xpath)
                            <a href="#" class="button {{ $xpath->status == 'OK' ? 'is-success' : ($xpath->status == 'NOT OK' ? 'is-danger' : 'is-light') }} is-small check_xpath">
                              <span class="icon left">
                                @if ($xpath->status == "OK")
                                  <i class="fas fa-check"></i>
                                @elseif ($xpath->status == "NOT OK")
                                  <i class="fas fa-times"></i>
                                @endif
                              </span>
                              Patikrinti
                            </a>

                            {{ Form::hidden('xpath_data', $xpath, ['class' => 'xpath_data']) }}
                            {{ Form::hidden('lunch_id', $lunch->id, ['class' => 'lunch_id']) }}
                            {{ Form::hidden('update_url', route('xpath.lunch.update', [$restaurant->id, $lunch->id]), ['class' => 'update_url']) }}
                            {{ Form::hidden('lunch_title', $lunch->title, ['class' => 'lunch_title']) }}
                            {{ Form::hidden('lunch_price', $lunch->price, ['class' => 'lunch_price']) }}
                            {{ Form::hidden('lunch_weekday', $lunch->weekday, ['class' => 'lunch_weekday']) }}
                          @endforeach
                        @endif
                      </td>
                      <td>
                        @if ($lunch->xpaths)
                          @foreach ($lunch->xpaths as $xpath)
                            {{ $xpath->check_date }}
                          @endforeach
                        @endif
                      </td>
                    </tr>
                  @endforeach
                @endforeach
              </tbody>
            </table>

          @else
            <div class="has-text-centered">
              Šiuo metu nėra jokių patiekalų priklausančių šiam restoranui
            </div>
          @endif
        </div>
      </div>

    </div>
  </section>

@endsection

@section('scripts')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script type="text/javascript">
    var file = document.getElementById("logo-file");
    file.onchange = function(){
      if(file.files.length > 0) {
        document.getElementById('file-name').innerHTML = file.files[0].name;
      }
    };

    // PATIEKALŲ PATIKRINIMO FUNKCIJA
    $('.check_xpath').on('click', function(e) {
      e.preventDefault();
      var thiss = $(this);

      var xpath_data = thiss.siblings('.xpath_data').val();
      var lunch_id = thiss.siblings('.lunch_id').val();
      var update_url = thiss.siblings('.update_url').val();
      var lunch_title = thiss.siblings('.lunch_title').val();
      var lunch_price = thiss.siblings('.lunch_price').val();
      var lunch_weekday = thiss.siblings('.lunch_weekday').val();

      var token = '{{ Session::token() }}';
      var url = '{{ route('xpath.index', $restaurant->id) }}';
      var restaurantId = {{ $restaurant->id }};

      $.ajax({
        method: 'POST',
        url: url,
        data: {xpath_data: xpath_data, lunch_title: lunch_title, lunch_price: lunch_price, restaurantId: restaurantId, _token: token},
        beforeSend: function () {
          thiss.children('span').children().remove();
          thiss.children('span').append('<i class="fas fa-spinner rotate"></i>');

        },
        error: function (error) {
          var error_message = '<p class="help is-danger">' + error.statusText + '</p>';
          thiss.parent('td').append(error_message);

          thiss.removeClass('is-light');
          thiss.removeClass('is-success');
          thiss.addClass('is-danger');

          thiss.children('span').children().remove();
          thiss.children('span').append('<i class="fas fa-times"></i>');
        }
      })
      .done(function (msg) {
        var modal_open = '<div class="modal is-active"><div class="modal-background"></div><div class="modal-card">';

        var form = '{!! Form::open(['route' => ['xpath.lunch.store', $restaurant->id]]) !!}';

        var update_form = '<form method="POST" action="' + update_url + '">';
            update_form += '<input type="hidden" name="_token" value="{{ csrf_token() }}">';

        var modal = '<header class="modal-card-head"><p class="modal-card-title">Pridėti naują patiekalą</p><button class="delete" aria-label="close"></button></header><section class="modal-card-body">';
            modal += '<div class="row"><div class="col-md-6">';
            modal += '<h2>Senas Pasiūlymas</h2>'

            modal += '<div class="field"><label class="label">Pavadinimas</label><div class="control is-expanded has-icons-left"><input type="text" value="' + lunch_title + '" class="input field-title" readonly="readonly" /><span class="icon is-small is-left"><i class="fas fa-utensils"></i></span></div></div>';
            modal += '<div class="field"><label class="label">Kaina</label><div class="control is-expanded has-icons-left"><input type="number" step="0.01" value="' + lunch_price + '" class="input field-price" readonly="readonly" /><span class="icon is-small is-left"><i class="fas fa-money-bill-alt"></i></span></div></div>';
            modal += '<div class="field"><label class="label">Savaitės diena</label><div class="control is-expanded has-icons-left"><input type="text" value="' + lunch_weekday + '" class="input" readonly="readonly" /><span class="icon is-small is-left"><i class="fas fa-calendar-alt"></i></span></div></div>';
            modal += '<input type="hidden" name="lunch_id" value="' + lunch_id + '" />';

            modal += '</div><div class="col-md-6">';
            modal += '<h2>Naujas Pasiūlymas</h2>';

            modal += '<div class="field"><label name="title" class="label">Pavadinimas</label><div class="control is-expanded has-icons-left"><input type="text" name="title" value="' + msg['new_lunchdeal']['title'] + '" class="input field-title" placeholder="Lietiniai su varške" /><span class="icon is-small is-left"><i class="fas fa-utensils"></i></span></div></div>';
            modal += '<div class="field"><label name="price" class="label">Kaina</label><div class="control is-expanded has-icons-left"><input type="number" name="price" step="0.01" value="' + msg['new_lunchdeal']['price'] + '" class="input field-price" placeholder="3.99" /><span class="icon is-small is-left"><i class="fas fa-money-bill-alt"></i></span></div></div>';
            modal += "<input type='hidden' name='image' value='" + msg['new_lunchdeal']['image'] + "' />";
            modal += '<div class="field"><label name="weekday" class="label">Savaitės diena</label><div class="control has-icons-left"><div class="select">{{ Form::select('weekday', ["Pirmadienis" => "Pirmadienis", "Antradienis" => "Antradienis", "Trečiadienis" => "Trečiadienis", "Ketvirtadienis" => "Ketvirtadienis", "Penktadienis" => "Penktadienis"], strftime('%A') == "Šeštadienis" || strftime('%A') == "Sekmadienis" ? "Pirmadienis" : strftime('%A')) }}</div><span class="icon is-small is-left"><i class="fas fa-calendar-alt"></i></span></div></div>';

            modal += '</div></div>';
            modal += '</section><footer class="modal-card-foot"><button type="submit" class="button is-success">Pridėti Pasiūlymą</button><button class="button cancel-modal">Atšaukti</button></footer>';
            modal += '</div>{!! Form::close() !!}</div>';

        if (msg['atsakas'] == 'Error') {
          thiss.removeClass('is-light');
          thiss.removeClass('is-success');
          thiss.addClass('is-danger');

          thiss.children('span').children().remove();
          thiss.children('span').append('<i class="fas fa-times"></i>');

          var error_modal = modal_open;
              error_modal += update_form;
              error_modal += modal;

          $('#modal-place').append(error_modal);

          $('.modal-background, .delete, .cancel-modal').on('click', function(e) {
            e.preventDefault();

            thiss.children('span').children().remove();
            thiss.children('span').append('<i class="fas fa-times"></i>');

            $('#modal-place').children('.modal').remove();
          });
        } else if (msg['atsakas'] == 'Different days') {
            var different_modal = modal_open;
                different_modal += form;
                different_modal += modal;

            $('#modal-place').append(different_modal);

            $('.modal-background, .delete, .cancel-modal').on('click', function(e) {
              e.preventDefault();

              thiss.children('span').children().remove();
              thiss.children('span').append('<i class="fas fa-times"></i>');

              $('#modal-place').children('.modal').remove();
            });
        } else {
          thiss.removeClass('is-light');
          thiss.removeClass('is-danger');
          thiss.addClass('is-success');

          thiss.children('span').children().remove();
          thiss.children('span').append('<i class="fas fa-check"></i>');
        }

        });
      });
  </script>

@endsection
