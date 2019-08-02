<table class="table table-bordered table-striped sortable">
  <thead>
    <tr>
      <th  class="nosort" data-sortcolumn="0" data-sortkey="0-0">Hotel</th>
      <th data-defaultsort="disabled" class="nosort" data-sortcolumn="1" data-sortkey="1-0">City</th>
      <th class="nosort" data-sortcolumn="2" data-sortkey="2-0">Price</th>
      <th data-defaultsort="disabled" data-defaultsign="month" class="nosort" data-sortcolumn="3" data-sortkey="3-0">Availability</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($final_result as $hotel)

    <tr>
      <td data-value="{{ $hotel -> name}}">{{ $hotel -> name}}</td>
      <td data-value="{{ $hotel -> city}}">{{ $hotel -> city}}</td>
      <td data-value="{{ $hotel -> price}}">{{ $hotel -> price}}</td>
      <td>
        @foreach ($hotel -> availability as $date)
          {{ 'From: '.$date -> from. ' To: '.$date -> to.', '}}
        @endforeach
      </td>
    </tr>

    @endforeach
  </tbody>
</table>
