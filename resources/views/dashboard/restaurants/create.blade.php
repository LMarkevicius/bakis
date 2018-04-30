@extends('main')

@section('title', 'Create Lunch Deals')

@section('section')

  <section class="hero">
    <div class="hero-body has-text-centered">
      <h1 class="title">
        Create Lunch Deals
      </h1>

      <h2 class="subtitle">Manually</h2>
    </div>
  </section>

  <div class="row">
    <div class="col-xs-12 col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">
      {!! Form::open(['route' => 'dashboard.store', 'files' => true]) !!}
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

        <div class="file has-name">
          <label class="file-label">
            <input type="file" name="logo" class="file-input" id="logo-file">

            <span class="file-cta">
              <span class="file-icon">
                <i class="fas fa-upload"></i>
              </span>

              <span class="file-label">Choose a logo...</span>
            </span>

            <span class="file-name" id="file-name"></span>
          </label>
        </div>

        <h2 class="subtitle is-5">Contacts <small>(Optional)</small></h2>

        <div class="field">
          {{ Form::label('address', 'Restaurant Address', ['class' => 'label']) }}

          <div class="control">
            {{ Form::text('address', null, ['class' => 'input']) }}
          </div>
        </div>

        <div class="field">
          {{ Form::label('city', 'Restaurant City', ['class' => 'label']) }}

          <div class="control">
            {{ Form::text('city', null, ['class' => 'input']) }}
          </div>
        </div>

        <div class="field">
          {{ Form::label('phone', 'Phone Number', ['class' => 'label']) }}

          <div class="control">
            {{ Form::text('phone', null, ['class' => 'input']) }}
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
            {{ Form::submit('Create Deal', ['class' => 'button is-success']) }}
          </p>
        </div>

      {!! Form::close() !!}
    </div>

  </div>

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
