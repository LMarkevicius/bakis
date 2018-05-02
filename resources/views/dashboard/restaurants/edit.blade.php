@extends('main')

@section('title', 'Edit Restaurant')

@section('section')

  <section class="hero">
    <div class="hero-body has-text-centered hero-margin-bottom">
      <h1 class="title">
        Edit {{ $restaurant->name }} Restaurant
      </h1>
    </div>
  </section>

  <div class="row">
    <div class="col-xs-12 col-md-10 col-md-offset-1">
      {!! Form::model($restaurant, ['route' => ['dashboard.update', $restaurant->id], 'method' => 'PUT', 'files' => true]) !!}
        <div class="field">
          {{ Form::label('name', 'Website Name', ['class' => 'label']) }}

          <div class="control">
            {{ Form::text('name', null, ['class' => 'input']) }}
          </div>
        </div>

        <div class="field">
          {{ Form::label('website', 'Website URL', ['class' => 'label']) }}

          <div class="control">
            {{ Form::text('website', null, ['class' => 'input']) }}
          </div>
        </div>

        <div class="field">
          <div class="file has-name">
            <label class="file-label">
              {{-- {{ Form::file('logo', null, ['class' => 'file-input']) }} --}}
              <input type="file" name="logo" class="file-input" id="logo-file">

              <span class="file-cta">
                <span class="file-icon">
                  <i class="fas fa-upload"></i>
                </span>

                <span class="file-label">Choose a logo...</span>
              </span>

              <span class="file-name" id="file-name">{{ $restaurant->logo }}</span>
            </label>
          </div>
        </div>


        {{-- <div class="form-group">
          {{ Form::label('logo', 'Website Logo') }}
          {{ Form::file('logo', null, ['class' => 'form-control']) }}
        </div> --}}

        <div class="field is-grouped is-grouped-centered">
          <p class="control">
            {{ Form::submit('Update Restaurant', ['class' => 'button is-success']) }}
          </p>

          <p class="control">
            <a href="{{ route('dashboard.index') }}" class="button is-light">Cancel</a>
          </p>
        </div>

        {{-- {!! Html::linkRoute('lunch.show', 'Cancel', [$restaurant->id], ['class' => 'btn btn-danger']) !!}
        {{ Form::submit('Update Deal', ['class' => 'btn btn-primary']) }} --}}

      {!! Form::close() !!}
    </div>
  </div>

  <section class="hero">
    <div class="hero-body has-text-centered">
      <h2 class="subtitle is-4">
        Contacts

        <a href="{{ route('contact.create', $restaurant->id) }}" class="button is-primary is-small">
          <span class="icon">
            <i class="fas fa-plus"></i>
          </span>
          Add new
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
              <th>Address</th>
              <th>City</th>
              <th>Phone Number</th>
              <th>Actions</th>
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
                    Edit Contact
                  </a>

                  {!! Form::open(['route' => ['contact.destroy', $restaurant->id, $contact->id], 'method' => 'DELETE']) !!}

                    <button type="submit" class="button is-danger is-small is-fullwidth">
                      <span class="icon left">
                        <i class="fas fa-trash-alt"></i>
                      </span>
                      Delete Contact
                    </button>

                  {!! Form::close() !!}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="has-text-centered">
          There are no contacts
        </div>
      @endif
    </div>
  </div>

  <section class="hero" id="modal-place">
    <div class="hero-body has-text-centered">
      <h2 class="subtitle is-4">
        Lunches

        <a href="{{ route('lunch.create', $restaurant->id) }}" class="button is-primary is-small">
          <span class="icon">
            <i class="fas fa-plus"></i>
          </span>
          Add new
        </a>
      </h2>
    </div>
  </section>

  <div class="row">
    <div class="col-xs-12 col-md-10 col-md-offset-1">
      {{-- <table>
        <thead>
          <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Price</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($lunchesByWeekday as $weekday => $lunches)
            <tr>
              <td>{{ $weekday }}</td>
            </tr>
            @foreach ($lunches as $lunch)
              <tr>
                <td></td>
                <td>{{ $l->title }}</td>
                {{-- <td>{{ $weekday[$lunch]->price }}</td> --}}


      @if (count($restaurant->lunches) > 0)
        <table class="table is-striped is-fullwidth">
          <thead>
            <tr>
              <th>Image</th>
              <th>Title</th>
              <th>Price</th>
              {{-- <th>Week day</th> --}}
              <th>Actions</th>
              <th>Status</th>
              <th>Check Date</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($lunchesByWeekday as $weekday => $lunches)
              <tr>
                <th colspan="6">{{ $weekday }}<small> ({{ count($lunches) }} meals)</small></th>
              </tr>

              @foreach ($lunches as $lunch)
                <tr>
                  <td><img src="{{ asset('images/' . $lunch->image) }}" class="table-logo" /></td>
                  <td>{{ $lunch->title }}</td>
                  <td>{{ $lunch->price }} $</td>
                  {{-- <td>{{ $lunch->weekday }}</td> --}}
                  <td>
                    <a href="{{ route('lunch.edit', [$restaurant->id, $lunch->id]) }}" class="button is-info is-small is-fullwidth">
                      <span class="icon left">
                        <i class="fas fa-pencil-alt"></i>
                      </span>
                      Edit
                    </a>

                    {!! Form::open(['route' => ['lunch.destroy', $restaurant->id, $lunch->id], 'method' => 'DELETE']) !!}
                      <button type="submit" class="button is-danger is-small is-fullwidth">
                        <span class="icon left">
                          <i class="fas fa-trash-alt"></i>
                        </span>
                        Delete
                      </button>
                    {!! Form::close() !!}
                  </td>
                  <td>
                    {{-- {{ dd($lunch->xpaths()->title_path) }} --}}
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
                          Check
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

        {{-- {{ Form::text('check', null, ['id' => 'check_atsakas']) }} --}}
      @else
        <div class="has-text-centered">
          There are no lunch deals
        </div>
      @endif
    </div>
  </div>

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



    // Check
    $('.check_xpath').on('click', function(e) {
      e.preventDefault();
      var thiss = $(this);

      var xpath_data = thiss.siblings('.xpath_data').val();
      var lunch_id = thiss.siblings('.lunch_id').val();
      var update_url = thiss.siblings('.update_url').val();
      var lunch_title = thiss.siblings('.lunch_title').val();
      var lunch_price = thiss.siblings('.lunch_price').val();
      var lunch_weekday = thiss.siblings('.lunch_weekday').val();

      // console.log(xpath_data);


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
          console.log(error);
        }
      })
      .done(function (msg) {
        console.log(msg['atsakas']);
        console.log(msg['content']);
        console.log(msg['new_lunchdeal']);

        var modal_open = '<div class="modal is-active"><div class="modal-background"></div><div class="modal-card">';

        var form = '{!! Form::open(['route' => ['xpath.lunch.store', $restaurant->id]]) !!}';

        var update_form = '<form method="POST" action="' + update_url + '">';
            update_form += '<input type="hidden" name="_token" value="{{ csrf_token() }}">';

        var modal = '<header class="modal-card-head"><p class="modal-card-title">Add new Lunch Deal</p><button class="delete" aria-label="close"></button></header><section class="modal-card-body">';
            modal += '<div class="row"><div class="col-md-6">';
            modal += '<h2>Old Lunch Deal</h2>'

            modal += '<div class="field"><label class="label">Lunch Title</label><div class="control"><input type="text" value="' + lunch_title + '" class="input field-title" readonly="readonly" /></div></div>';
            modal += '<div class="field"><label class="label">Meal Price</label><div class="control"><input type="number" step="0.01" value="' + lunch_price + '" class="input field-price" readonly="readonly" /></div></div>';
            modal += '<div class="field"><label class="label">Weekday</label><div class="control"><input type="text" value="' + lunch_weekday + '" class="input" readonly="readonly" /></div></div>';
            modal += '<input type="hidden" name="lunch_id" value="' + lunch_id + '" />';

            modal += '</div><div class="col-md-6">';
            modal += '<h2>New Lunch Deal</h2>';

            modal += '<div class="field"><label name="title" class="label">Lunch Title</label><div class="control"><input type="text" name="title" value="' + msg['new_lunchdeal']['title'] + '" class="input field-title" /></div></div>';
            modal += '<div class="field"><label name="price" class="label">Meal Price</label><div class="control"><input type="number" name="price" step="0.01" value="' + msg['new_lunchdeal']['price'] + '" class="input field-price" /></div></div>';
            // modal += '<div class="field"><label name="weekday" class="label">Weekday</label><div class="control"><input type="text" name="weekday" value="' + msg['new_lunchdeal']['weekday'] + '" class="input" /></div></div>';
            modal += '<div class="field"><label name="weekday" class="label">Weekday</label><div class="control"><div class="select">{{ Form::select('weekday', ["Monday" => "Monday", "Tuesday" => "Tuesday", "Wednesday" => "Wednesday", "Thursday" => "Thursday", "Friday" => "Friday"], date("l") == "Saturday" || date("l") == "Sunday" ? "Monday" : date("l")) }}</div></div></div>';
            // modal += '<input type="hidden" name="lunch_id" id="lunch_id" value="' + lunch_id + '" />';
            var todaysdate = "{{ date('l') == "Saturday" || date('l') == "Sunday" ? "Monday" : date('l') }}";
            // console.log(todaysdate);
            // $('option[value="' + todaysdate + '"]').attr('selected', 'selected');

            modal += '</div></div>';
            modal += '</section><footer class="modal-card-foot"><button type="submit" class="button is-success">Add New Deal</button><button class="button cancel-modal">Cancel</button></footer>';
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


        // $('#check_atsakas').val(msg['content']);

        });
      });
  </script>

@endsection
