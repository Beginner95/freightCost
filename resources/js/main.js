
// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script
// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        mapTypeControl: false,
        center: {lat: 55.751770, lng: 37.608868},
        zoom: 7
    });
    new AutocompleteDirectionsHandler(map);
}

/**
 * @constructor
 */
function AutocompleteDirectionsHandler(map) {
    this.map = map;
    this.originPlaceId = null;
    this.destinationPlaceId = null;
    this.travelMode = 'DRIVING';
    this.directionsService = new google.maps.DirectionsService;
    this.directionsRenderer = new google.maps.DirectionsRenderer;
    this.directionsRenderer.setMap(map);

    var originInput = document.getElementById('origin-input');
    var destinationInput = document.getElementById('destination-input');
    var modeSelector = document.getElementById('mode-selector');

    var originAutocomplete = new google.maps.places.Autocomplete(originInput);
    // Specify just the place data fields that you need.
    originAutocomplete.setFields(['place_id']);

    var destinationAutocomplete =
        new google.maps.places.Autocomplete(destinationInput);
    // Specify just the place data fields that you need.
    destinationAutocomplete.setFields(['place_id']);

    this.setupPlaceChangedListener(originAutocomplete, 'ORIG');
    this.setupPlaceChangedListener(destinationAutocomplete, 'DEST');

    this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(originInput);
    this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(destinationInput);
    this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(modeSelector);
}

// Sets a listener on a radio button to change the filter type on Places
// Autocomplete.


AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(autocomplete, mode) {
    var me = this;
    autocomplete.bindTo('bounds', this.map);

    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();

        if (!place.place_id) {
            window.alert('Please select an option from the dropdown list.');
            return;
        }
        if (mode === 'ORIG') {
            me.originPlaceId = place.place_id;
        } else {
            me.destinationPlaceId = place.place_id;
        }
        me.route();
    });
};

let distance = qS('input[name="distance"]');
let panel = qS('.panel_list');
let text_distance = qS('.text-distance');
let text_price = qS('.text-price');
let result_block = qS('.block-inform');
let check_price = qS('input[name="w"]:checked');

AutocompleteDirectionsHandler.prototype.route = function() {
    if (!this.originPlaceId || !this.destinationPlaceId) {
        return;
    }
    var me = this;
    this.directionsService.route(
        {
            origin: {'placeId': this.originPlaceId},
            destination: {'placeId': this.destinationPlaceId},
            travelMode: this.travelMode
        },

        function(response, status) {
            if (status === 'OK') {
                me.directionsRenderer.setDirections(response);
                distance.value = response.routes[0].legs[0].distance.value;
                text_distance.innerText = response.routes[0].legs[0].distance.text;
                calc(distance.value, check_price.value);
            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
};

function runCalc(e) {
    if (e.target.tagName === 'INPUT') {
        let dist = distance.value;
        let price = e.target.value;
        calc(dist, price);
    }
}

function calc(distance, price) {
    let dist = (distance / 1000);
    let result = price * dist;
    result_block.style.display = 'block';
    text_price.innerText = moneyFormat(result);
    return result;
}

panel.addEventListener('click', runCalc);

function qS(el) {
    return document.querySelector(el);
}

function moneyFormat(n) {
    return parseFloat(n).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1 ");
}

let clear_input_a = qS('#clear-input-a');
let clear_input_b = qS('#clear-input-b');

clear_input_a.addEventListener('click', clearInput);
clear_input_b.addEventListener('click', clearInput);

function clearInput(e) {
    if (e.target.id === 'clear-input-a') qS('#origin-input').value = '';
    if (e.target.id === 'clear-input-b') qS('#destination-input').value = '';
}