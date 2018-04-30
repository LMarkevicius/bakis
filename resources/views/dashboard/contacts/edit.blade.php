@extends('main')

@section('title', 'Edit Restaurant Contact')

@section('section')

  <section class="hero">
    <div class="hero-body has-text-centered">
      <h1 class="title">
        Edit {{ $contact->restaurant->name }} Restaurant Contact
      </h1>
    </div>
  </section>

  <div class="row">
    <div class="col-xs-12 col-md-8 col-lg-6 offset-md-2 offset-lg-3">
      {!! Form::model($contact, ['route' => ['contact.update', $contact->restaurant_id, $contact->id], 'method' => 'PUT', 'files' => true]) !!}
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
            {{ Form::submit('Update Contact', ['class' => 'button is-success']) }}
          </p>

          <p class="control">
            <a href="{{ route('dashboard.edit', $contact->restaurant_id) }}" class="button is-light">Cancel</a>
          </p>
        </div>

        {{-- {!! Html::linkRoute('lunch.show', 'Cancel', [$restaurant->id], ['class' => 'btn btn-danger']) !!}
        {{ Form::submit('Update Deal', ['class' => 'btn btn-primary']) }} --}}

      {!! Form::close() !!}
    </div>
  </div>

@endsection
