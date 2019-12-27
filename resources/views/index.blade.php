@extends('layouts.app')

@section('content')
    <div style="display: none">
        <input id="origin-input" class="controls" type="text" placeholder="Город погрузки">
        <input id="destination-input" class="controls" type="text" placeholder="Город выгрузки">
    </div>
    <div class="clear-input" id="clear-input-a"></div>
    <div class="clear-input" id="clear-input-b"></div>
    <div class="weight">
        <ul class="panel_list d-flex">
            @foreach ($weights as $key => $weight)
                <li>
                    <label>
                        <input type="radio" name="w" value="{{ $weight->price }}" data-price="" @if ($key === 0) checked="checked" @endif class="visually_hidden">
                        <span class="panel_name">{{ $weight->name }}<br>{{ $weight->cubic_meter }}</span>
                    </label>
                </li>
            @endforeach
            <input type="hidden" name="distance" value="0">
        </ul>
        <div class="block-inform">
            <p>Растояние: <span class="text-distance"></span></p>
            <p>Цена перевозки: <span class="text-price"></span></p>
        </div>
    </div>

    <div id="map"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('YOUR_API_KEY') }}&libraries=places&callback=initMap" async defer></script>
@endsection
