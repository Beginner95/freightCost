@extends('layouts.app')

@section('content')
<div class="container-site open-sidebar" style="background: #4c783f;">
    <div class="main-content">
        <div class="content">
            <div class="roundbox-position">
                <div class="roundbox roundbox-width1 roundbox-p3">
                    <div id="panel-from-in" class="controls panel">
                        <input id="address" type="text" placeholder="Город погрузки" class="SearchBox">
                    </div>
                    <div id="panel2-from-in" class="controls panel">
                        <input id="address2" type="text" placeholder="Город выгрузки" class="SearchBox">
                    </div>
                    <div id="panelClose1" class="panelClose" onClick="address.click();"></div>
                    <div id="panelClose2" class="panelClose" onClick="address2.click();"></div>
                </div>
                <input type="hidden" name="svidTransp" id="svidTransp" value="2">
            </div>
            <div id="map-canvas"></div>
        </div>
    </div>
</div>

<div class="b-popup" id="popup1">
    <img src="/img/loading.gif">
</div>

<a href="{{ route('logout') }}" class="logout-icon"></a>
<div class="weight">
    <ul class="panel_list d-flex block-weight"></ul>
    <div class="block-inform">
        <p class="block-inform-p">Растояние: <span class="text-distance"></span></p>
        <p class="block-inform-p">Цена перевозки: <span class="text-price"></span></p>
    </div>
</div>
@endsection
