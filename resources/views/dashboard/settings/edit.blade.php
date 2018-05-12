@extends('main')

@section('title', 'Administratoriaus Nustatymai')

@section('section')

  <section class="hero is-dark">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">
          Administratoriaus Nustatymai
        </h1>

        <h2 class="subtitle">
          <nav class="breadcrumb is-medium" aria-label="breadcrumbs">
            <ul>
              <li><a href="{{ route('dashboard.index') }}">Administratoriaus Apžvalga</a></li>
              <li class="is-active"><a href="" aria-current="page">Administratoriaus Nustatymai</a></li>
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
          {!! Form::model($settings, ['route' => ['settings.update'], 'method' => 'PUT']) !!}
            <div class="field">
              {{ Form::label('sleep', 'Miegojimo laikas (s)', ['class' => 'label']) }}

              <div class="control is-expanded has-icons-left">
                {{ Form::number('sleep', null, ['class' => 'input', 'min' => '0', 'max' => '300']) }}
                <span class="icon is-small is-left">
                  <i class="fas fa-clock"></i>
                </span>
              </div>
            </div>

            {{-- <div class="field has-text-centered">
              <h2 class="subtitle">
                Choose daily or every x hours
              </h2>
            </div> --}}

            <div class="field is-horizontal">
              {{-- <div class="field-label is-normal">
                <label class="label">From</label>
              </div> --}}
              <div class="field-body">
                {{-- <div class="field is-expanded"> --}}
                  <div class="field">
                    {{ Form::label('daily', 'Kasdieną x valandą', ['class' => 'label']) }}

                    <p class="control is-expanded has-icons-left">
                      {{ Form::time('daily', null, ['class' => 'input']) }}
                      <span class="icon is-small is-left">
                        <i class="fas fa-clock"></i>
                      </span>
                    </p>
                  </div>

                  <div class="field">
                    {{ Form::label('hourly', 'Kas x valandų', ['class' => 'label']) }}

                    <p class="control is-expanded has-icons-left">
                      {{ Form::number('hourly', null, ['class' => 'input', 'min' => '1', 'max' => '23']) }}
                      <span class="icon is-small is-left">
                        <i class="fas fa-clock"></i>
                      </span>
                    </p>
                  </div>


                {{-- </div> --}}
              </div>
            </div>
            <div class="field">

              <p class="help">Pasirinkite vieną iš dviejų</p>
            </div>

            <div class="field is-grouped is-grouped-centered">
              <p class="control">
                {{ Form::submit('Atnaujinti Nustatymus', ['class' => 'button is-success']) }}
              </p>

              <p class="control">
                <a href="{{ route('dashboard.index') }}" class="button is-light">Atšaukti</a>
              </p>
            </div>

            {{-- {!! Html::linkRoute('lunch.show', 'Cancel', [$restaurant->id], ['class' => 'btn btn-danger']) !!}
            {{ Form::submit('Update Deal', ['class' => 'btn btn-primary']) }} --}}

          {!! Form::close() !!}
        </div>
      </div>

    </div>
  </section>

@endsection
