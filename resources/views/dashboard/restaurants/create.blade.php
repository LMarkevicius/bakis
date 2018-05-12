@extends('main')

@section('title', 'Pridėti Restoraną')

@section('section')

  <section class="hero is-dark">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">
          Sukurti Restoraną
        </h1>

        <h2 class="subtitle">
          <nav class="breadcrumb is-medium" aria-label="breadcrumbs">
            <ul>
              <li><a href="{{ route('dashboard.index') }}">Administratoriaus Apžvalga</a></li>
              <li class="is-active"><a href="" aria-current="page">Sukurti Restoraną</a></li>
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
        <div class="col-xs-12 col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">
          {!! Form::open(['route' => 'dashboard.store', 'files' => true]) !!}
            <div class="field">
              {{ Form::label('name', 'Restorano pavadinimas', ['class' => 'label']) }}

              <div class="control is-expanded has-icons-left">
                {{ Form::text('name', null, ['class' => 'input', 'placeholder' => 'La Crepe']) }}
                <span class="icon is-small is-left">
                  <i class="fas fa-utensils"></i>
                </span>
              </div>
            </div>

            <div class="field">
              {{ Form::label('website', 'Tinklalapio nuoroda', ['class' => 'label']) }}

              <div class="control is-expanded has-icons-left">
                {{ Form::text('website', null, ['class' => 'input', 'placeholder' => 'https://www.lacrepe.lt/']) }}
                <span class="icon is-small is-left">
                  <i class="fas fa-globe"></i>
                </span>
              </div>
            </div>

            <div class="field file has-name">
              <label class="file-label">
                <input type="file" name="logo" class="file-input" id="logo-file">

                <span class="file-cta">
                  <span class="file-icon">
                    <i class="fas fa-upload"></i>
                  </span>

                  <span class="file-label">Pasirinkite logotipą...</span>
                </span>

                <span class="file-name" id="file-name"></span>
              </label>
            </div>

            <h2 class="subtitle is-5">Kontaktai <small>(Neprivaloma)</small></h2>

            <div class="field">
              {{ Form::label('address', 'Restorano adresas', ['class' => 'label']) }}

              <div class="control is-expanded has-icons-left">
                {{ Form::text('address', null, ['class' => 'input', 'placeholder' => 'Žirmūnų g. 15']) }}
                <span class="icon is-small is-left">
                  <i class="fas fa-map-marker"></i>
                </span>
              </div>
            </div>

            <div class="field">
              {{ Form::label('city', 'Miestas', ['class' => 'label']) }}

              <div class="control is-expanded has-icons-left">
                {{ Form::text('city', null, ['class' => 'input', 'placeholder' => 'Vilnius']) }}
                <span class="icon is-small is-left">
                  <i class="fas fa-building"></i>
                </span>
              </div>
            </div>

            <div class="field">
              {{ Form::label('phone', 'Telefono numeris', ['class' => 'label']) }}

              <div class="control is-expanded has-icons-left">
                {{ Form::text('phone', null, ['class' => 'input', 'placeholder' => '+37067500000']) }}
                <span class="icon is-small is-left">
                  <i class="fas fa-phone"></i>
                </span>
              </div>
            </div>

            {{-- <h2 class="subtitle is-5">Add Lunch Deals</h2>

            <div class="field is-grouped">
              <p class="control">
                <a href="#" class="button is-primary" id="manual">
                  <span class="icon">
                    <i class="fas fa-pencil-alt"></i>
                  </span>
                  Manually
                </a>
              </p>

              <p class="control">
                <a href="#" class="button is-primary" id="automatic">
                  <span class="icon">
                    <i class="fas fa-magic"></i>
                  </span>
                  Automatically
                </a>
              </p>
            </div>

            <div class="manual-lunch-container is-hidden">
              <div class="lunch-deals">
                <div class="field">
                  {{ Form::label('title[]', 'Lunch Title', ['class' => 'label']) }}

                  <div class="control">
                    {{ Form::text('title[]', null, ['class' => 'input']) }}
                  </div>
                </div>

                <div class="file has-name">
                  <label class="file-label">
                    <input type="file" name="image[]" class="file-input" id="logo-file">

                    <span class="file-cta">
                      <span class="file-icon">
                        <i class="fas fa-upload"></i>
                      </span>

                      <span class="file-label">Choose an image...</span>
                    </span>

                    <span class="file-name" id="file-name"></span>
                  </label>
                </div>

                <div class="field">
                  {{ Form::label('price[]', 'Meal Price', ['class' => 'label']) }}

                  <div class="control">
                    {{ Form::number('price[]', null, ['class' => 'input']) }}
                  </div>
                </div>

                <div class="field">
                  {{ Form::label('weekday[]', 'Week Day', ['class' => 'label']) }}

                  <div class="control">
                    {{ Form::text('weekday[]', null, ['class' => 'input']) }}
                  </div>
                </div>

                {{ Form::hidden('count_deals', null, ['id' => 'count-deals']) }}
              </div>

              <div class="field">
                <a href="#" id="add-more" class="button is-primary is-small">
                  <span class="icon">
                    <i class="fas fa-plus"></i>
                  </span>
                  Add Another Deal
                </a>
              </div>
            </div>

            <div class="automatic-lunch-container is-hidden">
              <h1>Oplia</h1>
            </div> --}}

            <div class="field is-grouped is-grouped-centered">
              <p class="control">
                {{ Form::submit('Sukurti Restoraną', ['class' => 'button is-success']) }}
              </p>
            </div>

          {!! Form::close() !!}
        </div>

      </div>

    </div>
  </section>

@endsection

@section('scripts')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function(e) {
      // var x = 1;
      // {{ $x = 1 }}
      //
      //
      // $('.lunch-deals #count-deals').val(x);
      // // var value = 0;
      //
      // $("#add-more").on('click', function(e) {
      //   e.preventDefault();
      //   x++;
      //   {{ $x++ }}
      //
      //   var lunchdeal = '<div class="field">{{ Form::label('title[]', 'Lunch Title', ['class' => 'label']) }}<div class="control">{{ Form::text('title[]', null, ['class' => 'input']) }}</div></div>';
      //       lunchdeal += '<div class="file has-name"><label class="file-label"><input type="file" name="image[]" class="file-input" id="logo-file"><span class="file-cta"><span class="file-icon"><i class="fas fa-upload"></i></span><span class="file-label">Choose an image...</span></span><span class="file-name" id="file-name"></span></label></div>';
      //       lunchdeal += '<div class="field">{{ Form::label('price[]', 'Meal Price', ['class' => 'label']) }}<div class="control">{{ Form::number('price[]', null, ['class' => 'input']) }}</div></div>';
      //       lunchdeal += '<div class="field">{{ Form::label('weekday[]', 'Week Day', ['class' => 'label']) }}<div class="control">{{ Form::text('weekday[]', null, ['class' => 'input']) }}</div></div>';
      //       lunchdeal += '<a href="#" class="remove-meal button is-danger is-small"><span class="icon"><i class="fas fa-trash-alt"></i></span>Remove Deal</a>';
      //
      //   $('.lunch-deals').append('<div><h2 class="subtitle is-5">' + x + ' meal</h2>' + lunchdeal + '</div>');
      //
      //   $('.lunch-deals #count-deals').val(x);
      // });
      //
      // $('.lunch-deals').on('click', '.remove-meal', function(e) {
      //   e.preventDefault();
      //
      //   $(this).parent('div').remove();
      //
      //   x--;
      //   {{ $x-- }}
      //   $('.lunch-deals #count-deals').val(x);
      // });

      var file = document.getElementById("logo-file");
      file.onchange = function(){
        if(file.files.length > 0) {
          document.getElementById('file-name').innerHTML = file.files[0].name;
        }
      };

      // $('#manual').on('click', function(e) {
      //   e.preventDefault();
      //
      //   if ($('.automatic-lunch-container').hasClass('.is-hidden') != true) {
      //     $('.automatic-lunch-container').addClass('is-hidden');
      //   }
      //
      //   $('.manual-lunch-container').toggleClass('is-hidden');
      // });
      //
      // $('#automatic').on('click', function(e) {
      //   e.preventDefault();
      //
      //   if ($('.manual-lunch-container').hasClass('.is-hidden') != true) {
      //     $('.manual-lunch-container').addClass('is-hidden');
      //   }
      //
      //   $('.automatic-lunch-container').toggleClass('is-hidden');
      // });
    });
  </script>
@endsection
