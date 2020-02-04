@extends('layouts.app')

@section('content')
    <div style="display: none">
        <input id="origin-input" class="controls" type="text" placeholder="Город погрузки">
        <input id="destination-input" class="controls" type="text" placeholder="Город выгрузки">
    </div>
    <div class="clear-input" id="clear-input-a"></div>
    <div class="clear-input" id="clear-input-b"></div>
    <div class="weight">
        <ul class="panel_list d-flex block-weight"></ul>
        <div class="block-inform">
            <p>Растояние: <span class="text-distance"></span></p>
            <p>Цена перевозки: <span class="text-price"></span></p>
        </div>
    </div>

    <div id="map"></div>
@endsection
