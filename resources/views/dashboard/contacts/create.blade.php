@extends('main')

@section('title', 'Create Restaurant Contact')

@section('section')

  <section class="hero is-dark">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">
          Add New Restaurant Contact
        </h1>

        <h2 class="subtitle">
          <nav class="breadcrumb is-medium" aria-label="breadcrumbs">
            <ul>
              <li><a href="{{ route('dashboard.index') }}">Admin Dashboard</a></li>
              <li><a href="{{ route('dashboard.edit', $restaurantId) }}">Edit Restaurant</a></li>
              <li class="is-active"><a href="" aria-current="page">Add Contact</a></li>
            </ul>
          </nav>
        </h2>
      </div>
    </div>
  </section>

  <section class="section">

    <div class="container">

      <div class="row">
        <div class="col-xs-12 col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">
          {!! Form::open(['route' => ['contact.store', $restaurantId]]) !!}
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


            <div class="field is-grouped is-grouped-centered">
              <p class="control">
                {{ Form::submit('Add New Contact', ['class' => 'button is-success']) }}
              </p>

              <p class="control">
                <a href="{{ route('dashboard.edit', $restaurantId) }}" class="button is-light">Cancel</a>
              </p>
            </div>

          {!! Form::close() !!}
        </div>
      </div>

    </div>
  </section>

@endsection
