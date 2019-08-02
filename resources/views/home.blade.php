<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap-slider.css') }}" rel="stylesheet">
        <link href="{{ asset('css/highlightjs-github-theme.css') }}" rel="stylesheet">
        <link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap-sortable.css') }}" rel="stylesheet">

        <title>{{ $title }}</title>
    </head>
    <body>
        <div class="overlay" id="loading">
         <img class="spinner_logo" src="{{ asset('img/spinner.gif') }}">
      </div>
       <div class="main_form">
        <div class="page_title">
            <h2>{{ $title }}</h2>
        </div>
        <form method="POST" action="javascript:void(0)" class="search_form">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Hotel</label>
                <input type="text" class="form-control" name="hotel">
              </div>
              <div class="form-group">
                <label>Destination</label>
                <input type="text" class="form-control" name="city">
              </div>
              <div class="form-group">
                <label>Price Range</label>
                <b>$ 50</b> <input type="text" class="span2 price_slider" value="" data-slider-min="50" data-slider-max="140" data-slider-step="5" data-slider-value="[80,120]"/> <b>$ 140</b>
              </div>
              <div class="form-group">
                <label>Date Range</label>
                <input type="text" name="date_range" class="date_range" value="10/01/2020 - 11/01/2020" />
              </div>
              <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
       </div>
    </body>

    <input type='hidden' value = {{ url('/search') }} class="submit_url"/>

    <div class="search_table">
    </div>
</html>

<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-slider.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/highlight.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-sortable.js') }}"></script>


<script type="text/javascript">

var slider = $(".price_slider").slider({});
var originalVal = $('.span2').data('slider').getValue();
var min_price = originalVal[0];
var max_price = originalVal[1];
var date_start, date_end;

$(function() {
  $('input[name="date_range"]').daterangepicker({
    opens: 'right'
  }, function(start, end, label) {

    date_start = start.format('DD-MM-YYYY');
    date_end = end.format('DD-MM-YYYY');
  });
});

var date = $('.date_range').val().split(" - ");
date_start = date[0];
date_end = date[1];

$(".price_slider").on("slide", function(slideEvt) {

    var price_min = slideEvt.value[0];
    var price_max = slideEvt.value[1];

    min_price = slideEvt.value[0];
    max_price = slideEvt.value[1];

});

 $( '.search_form' ).on( 'submit', function(e) {

    e.preventDefault();

    $('#loading').show();

    var hotel = $('input[name="hotel"]').val();
    var city = $('input[name="city"]').val();

    console.log('Hotel: '+ hotel);
    console.log('City: '+ city);
    console.log('Min Price: '+ min_price);
    console.log('Max Price '+ max_price);
    console.log('Start Date: '+ date_start);
    console.log('End Date: '+ date_end);

    $.ajax({
        type: "POST",
        url: $('.submit_url').val(),
        data: { hotel:hotel, city:city, min_price:min_price, max_price:max_price, date_start:date_start
        , date_end:date_end, _token: '{!! csrf_token() !!}' }, 
        success: function( data ) {
            
            $('.search_table').html(data.html);
            $('#loading').fadeOut(250);

    }
});

});

</script>

