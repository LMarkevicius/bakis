@extends('main')

@section('title', 'Pridėti Dienos Pietų Pasiūlymus')

@section('section')

  <section class="hero is-dark">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">
          Pridėti Dienos Pietų Pasiūlymus
        </h1>

        <h2 class="subtitle">
          <nav class="breadcrumb is-medium" aria-label="breadcrumbs">
            <ul>
              <li><a href="{{ route('dashboard.index') }}">Administratoriaus Apžvalga</a></li>
              <li><a href="{{ route('dashboard.edit', $restaurantId) }}">Redaguoti Restoraną</a></li>
              <li class="is-active"><a href="" aria-current="page">Pridėti Patiekalus</a></li>
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

      <section class="hero">
        <div class="hero-body has-text-centered">
          <h1 class="title">
            Pasirinkite metodą
          </h1>

          <div class="field is-grouped is-grouped-centered">
            <p class="control">
              <a href="#" class="button is-danger is-small" id="automatic">
                <span class="icon">
                  <i class="fas fa-magic"></i>
                </span>
                Automatinis
              </a>
            </p>

            <p class="control">
              <a href="#" class="button is-light is-small" id="manual">
                <span class="icon">
                  <i class="fas fa-pencil-alt"></i>
                </span>
                Rankinis
              </a>
            </p>
          </div>
        </div>
      </section>

      <div class="row">
        <div class="col-xs-12 lunch-container">
          {!! Form::open(['route' => ['lunch.store', $restaurantId], 'files' => true]) !!}
            <div class="manual-lunch-container is-hidden">

            </div> <!-- .manual-lunch-container -->

            <div class="automatic-lunch-container">
              <div class="row">

                <div class="col-md-4 auto-lunch-cont">
                  <div class="field dataurl-field">
                    {{ Form::label('dataurl', 'Tinklalapio duomenų nuoroda', ['class' => 'label']) }}

                    <div class="control is-expanded has-icons-left">
                      {{ Form::text('dataurl', null, ['class' => 'input', 'id' => 'dataurl', 'placeholder' => 'https://www.lacrepe.lt/lt/dienos-pietus']) }}
                      <span class="icon is-small is-left">
                        <i class="fas fa-globe"></i>
                      </span>
                    </div><!--.control -->
                  </div> <!-- .field -->

                  <div class="field">
                    <a href="#" class="button is-primary" id="fetch">
                      <span class="icon left">

                      </span>
                      Ištraukti
                    </a>
                  </div> <!-- .field -->

                  <div class="lunch-deals">
                    <div class="field">
                      {{ Form::label('weekday[]', 'Savaitės diena', ['class' => 'label']) }}

                      <div class="control has-icons-left">
                        <div class="select">
                          @php setlocale(LC_TIME, "lt_LT.UTF8") @endphp
                          {{ Form::select('weekday[]', [
                            'Pirmadienis' => 'Pirmadienis',
                            'Antradienis' => 'Antradienis',
                            'Trečiadienis' => 'Trečiadienis',
                            'Ketvirtadienis' => 'Ketvirtadienis',
                            'Penktadienis' => 'Penktadienis',
                          ], strftime('%A') == "Šeštadienis" || strftime('%A') == "Sekmadienis" ? "Pirmadienis" : strftime('%A')) }}
                        </div>

                        <span class="icon is-small is-left">
                          <i class="fas fa-calendar-alt"></i>
                        </span>

                      </div> <!-- .control -->
                    </div> <!-- .field -->

                    {{ Form::hidden('count_deals', null, ['id' => 'count-deals']) }}

                  </div> <!-- .lunch-deals -->
                </div> <!-- .col-md-4 auto-lunch-cont -->

                <div class="col-md-8">
                  <div class="fetch-results"></div>
                </div> <!-- .col-md-8 -->

              </div> <!-- .row -->
            </div> <!-- .automatic-lunch-container -->

            <div class="field">
              <a href="#" id="add-more" class="button is-primary is-small is-hidden has-margin-top-little">
                <span class="icon">
                  <i class="fas fa-plus"></i>
                </span>
                Pridėti dar vieną patiekalą
              </a>
            </div> <!-- .field -->

            <div class="field is-grouped is-grouped-centered">
              <p class="control">
                {{ Form::submit('Pridėti Patiekalus', ['class' => 'button is-success']) }}
              </p>

              <p class="control">
                <a href="{{ route('dashboard.edit', $restaurantId) }}" class="button is-light">Atšaukti</a>
              </p>
            </div> <!-- .field is-grouped is-grouped-centered -->

          {!! Form::close() !!}

        </div> <!-- .col-xs-12 lunch-container-->
      </div> <!-- .row -->

    </div>
  </section>

@endsection

@section('scripts')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function(e) {

      function getElementXPath(element) {
        return "//" + $(element).parents().addBack().map(function () {
          var $this = $(this);
          var tagName = this.nodeName;

          if($this.siblings(tagName).length > 0) {
            tagName += "[" + ($this.prevAll(tagName).length + 1) + "]";
          }

          return tagName;
        }).get().join("/").toLowerCase();
      }

      var x = 0;
      var fetch_count = 1;

      $('.lunch-container #fetch_count').val(fetch_count);

      var lunchfields = '<div class="field">{{ Form::label('title[]', 'Patiekalo pavadinimas', ['class' => 'label']) }}<div class="control is-expanded has-icons-left">{{ Form::text('title[]', null, ['class' => 'input field-title', 'placeholder' => 'Lietiniai su varške']) }}<span class="icon is-small is-left"><i class="fas fa-utensils"></i></span></div></div>';
          lunchfields += '<div class="field file has-name"><label class="file-label"><input type="file" name="image[]" class="file-input" id="logo-file"><span class="file-cta"><span class="file-icon"><i class="fas fa-upload"></i></span><span class="file-label">Pasirinkite paveiksliuką...</span></span><span class="file-name" id="file-name"></span></label></div>';
          lunchfields += '<div class="field">{{ Form::label('price[]', 'Kaina', ['class' => 'label']) }}<div class="control is-expanded has-icons-left">{{ Form::number('price[]', null, ['class' => 'input field-price', 'step' => '0.01', 'placeholder' => '3.99']) }}<span class="icon is-small is-left"><i class="fas fa-money-bill-alt"></i></span></div></div>';

          weekdayfield = '<div class="field">{{ Form::label('weekday[]', 'Savaitės diena', ['class' => 'label']) }}<div class="control has-icons-left"><div class="select">{{ Form::select('weekday[]', ["Pirmadienis" => "Pirmadienis", "Antradienis" => "Antradienis", "Trečiadienis" => "Trečiadienis", "Ketvirtadienis" => "Ketvirtadienis", "Penktadienis" => "Penktadienis"], strftime('%A') == "Šeštadienis" || strftime('%A') == "Sekmadienis" ? "Pirmadienis" : strftime('%A')) }}</div><span class="icon is-small is-left"><i class="fas fa-calendar-alt"></i></span></div></div>';

      var removebutton = '<a href="#" class="remove-meal button is-danger is-small is-rounded"><span class="icon"><i class="fas fa-times-circle"></i></span>Pašalinti</a>';

      $('.lunch-deals #count-deals').val(x);

      $(".lunch-container").on('click', '#add-more', function(e) {
        e.preventDefault();
        x++;

        var lunchdeal = lunchfields;
            lunchdeal += weekdayfield;

        $('.lunch-deals').append('<div class="field has-margin-top"><h2 class="subtitle is-5">' + x + ' patiekalas ' + removebutton + '</h2>' + lunchdeal + '</div>');

        $('.lunch-deals #count-deals').val(x);

        $('.file-input').on('change', function () {
          $(this).siblings('.file-name').text($(this)[0].files[0].name);
        });
      });

      $('.lunch-container').on('click', '.remove-meal', function(e) {
        e.preventDefault();

        $(this).parent('h2').parent('div').remove();

        x--;
        $('.lunch-deals #count-deals').val(x);
      });

      var content = '<div class="lunch-deals">';
          content += lunchfields;
          content += weekdayfield;
          content += '{{ Form::hidden('count_deals', 1, ['id' => 'count-deals']) }}</div>';

      // RANKINIS BŪDAS
      $('#manual').on('click', function(e) {
        e.preventDefault();

        if ($('.automatic-lunch-container').hasClass('is-hidden') != true) {
          $('.automatic-lunch-container').addClass('is-hidden');
          $('.manual-lunch-container').removeClass('is-hidden');

          $('.automatic-lunch-container #dataurl').val('NODATA');

          $('#add-more').removeClass('is-hidden');

          $('#manual').addClass('is-danger');
          $('#manual').removeClass('is-light');
          $('#automatic').removeClass('is-danger');
          $('#automatic').addClass('is-light');

          $('.fetch-results').empty();

          if ($('.manual-lunch-container .lunch-deals').length == 0) {
            $('.manual-lunch-container').prepend(content);
            $('.automatic-lunch-container .lunch-deals').remove();
            x = 1;

            $('.file-input').on('change', function () {
              $(this).siblings('.file-name').text($(this)[0].files[0].name);
            });
          }
        }
      });

      // AUTOMATINIS BŪDAS
      $('#automatic').on('click', function(e) {
        e.preventDefault();

        var auto_content = '<div class="lunch-deals">';
            auto_content += weekdayfield;
            auto_content += '{{ Form::hidden('count_deals', 0, ['id' => 'count-deals']) }}</div>';

        if ($('.manual-lunch-container').hasClass('is-hidden') != true) {
          $('.manual-lunch-container').addClass('is-hidden');
          $('.automatic-lunch-container').removeClass('is-hidden');

          $('.automatic-lunch-container #dataurl').val('');

          $('#add-more').addClass('is-hidden');

          $('#manual').addClass('is-light');
          $('#manual').removeClass('is-danger');
          $('#automatic').removeClass('is-light');
          $('#automatic').addClass('is-danger');

          if ($('.automatic-lunch-container .lunch-deals').length == 0) {
            $('.automatic-lunch-container .auto-lunch-cont').append(auto_content);
            $('.manual-lunch-container .lunch-deals').remove();
            x = 0;
          }
        }
      });

      // DUOMENŲ IŠTRAUKIMO FUNKCIJA
      $('#fetch').on('click', function(e) {
        e.preventDefault();

        var dataurl = $('#dataurl').val();
        var token = '{{ Session::token() }}';
        var url = '{{ route('fetch.index', $restaurantId) }}';
        var restaurantId = {{ $restaurantId }};

        $.ajax({
          method: 'POST',
          url: url,
          data: {dataurl: dataurl, restaurantId: restaurantId, _token: token},
          beforeSend: function () {
            $('#fetch').children('span').children('svg').remove();
            $('#fetch').children('span').append('<i class="fas fa-spinner rotate"></i>');

          },
          error: function (xhr) {
            var error = '<p class="help is-danger dataurl-error">' + JSON.parse(xhr.responseText).errors['dataurl'] + '</p>';

            if ($('.dataurl-error').length) {
              $('.dataurl-error').remove();

              $('.dataurl-field').append(error);

              $('#fetch').children('span').children('svg').remove();
              $('#fetch').children('span').append('<i class="fas fa-times"></i>');
            } else {
              $('.dataurl-field').append(error);
              $('#fetch').children('span').children('svg').remove();
              $('#fetch').children('span').append('<i class="fas fa-times"></i>');
            }

          }
        })

        .done(function (msg) {
          $('.dataurl-error').remove();

          var lunchwrap = '<div class="col-xs-12 col-sm-6 margin-bottom"><div class="card">';
              lunchwrap += '<div class="card-image new-image"><a class="delete-deal button is-danger is-small is-rounded"><span class="icon is-small"><i class="fas fa-times"></i></span></a><figure class="image is-4by3"><img src=""></figure></div>';
              lunchwrap += '{{ Form::hidden('photo_url[]', null, ['class' => 'photo-url new-photo-url']) }}';
              lunchwrap += '<div class="card-content"><div class="content"><div class="field">{{ Form::label('title[]', 'Patiekalo pavadinimas', ['class' => 'label']) }}<div class="control is-expanded has-icons-left">{{ Form::textarea('title[]', null, ['class' => 'input field-title new-title', 'style' => 'height: 60px;', 'placeholder' => 'Lietiniai su varške']) }}<span class="icon is-small is-left"><i class="fas fa-utensils"></i></span></div></div></div>';
              lunchwrap += '<div class="field">{{ Form::label('price[]', 'Kaina', ['class' => 'label']) }}<div class="control is-expanded has-icons-left">{{ Form::number('price[]', null, ['class' => 'input field-price new-price', 'step' => '0.01', 'placeholder' => '3.99']) }}<span class="icon is-small is-left"><i class="fas fa-money-bill-alt"></i></span></div></div>';
              lunchwrap += '{{ Form::hidden('image_xpath[]', null, ['class' => 'image-xpath new-image-xpath']) }}';
              lunchwrap += '{{ Form::hidden('title_xpath[]', null, ['class' => 'title-xpath new-title-xpath']) }}';
              lunchwrap += '{{ Form::hidden('price_xpath[]', null, ['class' => 'price-xpath new-price-xpath']) }}';
              lunchwrap += '</div></div></div>';

          var wrapper = document.createElement('div');
          wrapper.innerHTML = msg['content'];
          var images = wrapper.getElementsByTagName('img');
          var specimg = [];
          var vaikai = [];
          var field_price;
          var fixed_title;
          var xpath;
          var xpath_image = [];
          var temp_xpath_image;
          var temp_image;

          for (var i = 0; i < images.length; i++) {
            $(images[i]).filter(function () {

              if (images[i].src.match(/^https:\/\/www/)) {
                specimg.push($(images[i]));
                temp_xpath_image = getElementXPath($(images[i])).split('/');
                temp_xpath_image[2] = "html/body";
                temp_image = temp_xpath_image.join('/');

                xpath_image.push(temp_image);
              } else if (images[i].src.match(/^http:\/\/www/)) {

                specimg.push($(images[i]));
                temp_xpath_image = getElementXPath($(images[i])).split('/');
                temp_xpath_image[2] = "html/body";

                temp_image = temp_xpath_image.join('/');

                xpath_image.push(temp_image);
              } else if (images[i].src.match(/^http:\/\/guacamole/)) {
                specimg.push($(images[i]));

                temp_xpath_image = getElementXPath($(images[i])).split('/');
                temp_xpath_image[2] = "html/body";
                temp_image = temp_xpath_image.join('/');

                xpath_image.push(temp_image);
              }
            });
          }

          function FetchLunches(father) {

            if ($(father).siblings().length == 0) {
              var grandfather = $(father).parent();

              FetchLunches(grandfather);

            } else {
              var brolis = $(father).siblings();

              if ($(brolis).children().length >= 1) {

                $('.fetch-results').append(lunchwrap);
                vaikai = $(brolis).children();

                $(vaikai).each(function (count = 0) {

                  if ($(vaikai[count]).text().trim() != '') {

                    if (/\€/.test($(vaikai[count]).text())) {
                      temp_xpath_data = getElementXPath($(vaikai[count])).split('/');
                      temp_xpath_data[2] = "html/body";
                      xpath = temp_xpath_data.join('/');

                      field_price = $(vaikai[count]).text().replace(/[^0-9,.]/g, '');
                      field_price = field_price.replace(/,/, '.');

                      $('.fetch-results .new-image img').attr('src', $(wrapper).find(specimg[i]).attr('src'));
                      $('.fetch-results .new-photo-url').val($(wrapper).find(specimg[i]).attr('src'));
                      $('.fetch-results .new-image-xpath').val(xpath_image[i]);

                      $('.fetch-results .new-price').val(field_price);
                      $('.fetch-results .new-price-xpath').val(xpath);

                      $('.fetch-results .card-image').removeClass('new-image');
                      $('.fetch-results .photo-url').removeClass('new-photo-url');
                      $('.fetch-results .image-xpath').removeClass('new-image-xpath');

                      $('.fetch-results .field-price').removeClass('new-price');
                      $('.fetch-results .price-xpath').removeClass('new-price-xpath');
                      count++;
                      x++;

                      $('.lunch-deals #count-deals').val(x);
                    } else {

                      temp_xpath_data = getElementXPath($(vaikai[count])).split('/');
                      temp_xpath_data[2] = "html/body";
                      xpath = temp_xpath_data.join('/');

                      fixed_title = $(vaikai[count]).text().trim().replace(/\"/g, "'");

                      $('.fetch-results .new-title').val(fixed_title);
                      $('.fetch-results .new-title-xpath').val(xpath);

                      $('.fetch-results .field-title').removeClass('new-title');
                      $('.fetch-results .title-xpath').removeClass('new-title-xpath');

                      count++;
                    }
                  }
                });
              }
            }
          }

          if (specimg.length > 0) {
            for (var i = 0; i < specimg.length; i++) {
              var father = $(wrapper).find(specimg[i]).parent();

              FetchLunches(father);

            }
          }

          $('.delete-deal').on('click', function () {
            $(this).parent().parent().parent().remove();

            x--;
            $('.lunch-deals #count-deals').val(x);
          });

          $('#fetch').children('span').children().remove();
          $('#fetch').children('span').append('<i class="fas fa-check-circle"></i>');

        });
      });
    });
  </script>
@endsection
