@extends('main')

@section('title', 'Sukurti Restorano Kontaktą')

@section('section')

  <section class="hero is-dark">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">
          Sukurti Restorano Kontaktą
        </h1>

        <h2 class="subtitle">
          <nav class="breadcrumb is-medium" aria-label="breadcrumbs">
            <ul>
              <li><a href="{{ route('dashboard.index') }}">Administratoriaus Apžvalga</a></li>
              <li><a href="{{ route('dashboard.edit', $restaurantId) }}">Redaguoti Restoraną</a></li>
              <li class="is-active"><a href="" aria-current="page">Pridėti Kontaktą</a></li>
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
          {!! Form::open(['route' => ['contact.store', $restaurantId]]) !!}
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
                {{ Form::number('phone', null, ['class' => 'input', 'placeholder' => '+37067500000']) }}
                <span class="icon is-small is-left">
                  <i class="fas fa-phone"></i>
                </span>
              </div>
            </div>


            <div class="field is-grouped is-grouped-centered">
              <p class="control">
                {{ Form::submit('Pridėti Kontaktą', ['class' => 'button is-success']) }}
              </p>

              <p class="control">
                <a href="{{ route('dashboard.edit', $restaurantId) }}" class="button is-light">Atšaukti</a>
              </p>
            </div>

          {!! Form::close() !!}
        </div>
      </div>

    </div>
  </section>

@endsection
