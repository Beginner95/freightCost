function initMap() {
    const map = new google.maps.Map(document.getElementById('map'), {
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

    const originInput = document.getElementById('origin-input');
    const destinationInput = document.getElementById('destination-input');
    const modeSelector = document.getElementById('mode-selector');

    const originAutocomplete = new google.maps.places.Autocomplete(originInput);
    // Specify just the place data fields that you need.
    originAutocomplete.setFields(['place_id']);

    const destinationAutocomplete = new google.maps.places.Autocomplete(destinationInput);
    // Specify just the place data fields that you need.
    destinationAutocomplete.setFields(['place_id']);

    this.setupPlaceChangedListener(originAutocomplete, 'ORIG');
    this.setupPlaceChangedListener(destinationAutocomplete, 'DEST');

    this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(originInput);
    this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(destinationInput);
    this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(modeSelector);
}

AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(autocomplete, mode) {
    const me = this;
    autocomplete.bindTo('bounds', this.map);

    autocomplete.addListener('place_changed', function() {

        const place = autocomplete.getPlace();

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

let panel = qS('.panel_list');
let text_distance = qS('.text-distance');
let text_price = qS('.text-price');
let result_block = qS('.weight');

AutocompleteDirectionsHandler.prototype.route = function() {
    if (!this.originPlaceId || !this.destinationPlaceId) {
        return;
    }
    const me = this;
    this.directionsService.route(
        {
            origin: {'placeId': this.originPlaceId},
            destination: {'placeId': this.destinationPlaceId},
            travelMode: this.travelMode
        },

        function(response, status) {
            if (status === 'OK') {
                me.directionsRenderer.setDirections(response);
                text_distance.innerText = response.routes[0].legs[0].distance.text;
                let start_address = response.routes[0].legs[0].start_address;
                let end_address = response.routes[0].legs[0].end_address;
                let addresses = {
                    'start_address': start_address,
                    'end_address': end_address
                };

                ajax('/weights', addresses, 'PUT').then((data) => {
                    createBlockWeights(data);
                });

            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
};

function runCalc(e) {
    if (e.target.tagName === 'INPUT') {
        let price = e.target.value;
        calc(price);
    }
}

function calc(price) {
    result_block.style.display = 'block';
    text_price.innerText = moneyFormat(price);
    return price;
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

async function ajax(url, data, method) {
    try {
        const response = await fetch(url, {
            method: method,
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const json = await response.json();
        return JSON.stringify(json);
    } catch (error) {
        console.error('Ошибка:', error);
    }
}

function createBlockWeights(data) {
    let html = '';
    let block = qS('.block-weight');
    data = JSON.parse(data);
    if (data.route === null) {
        block.innerHTML = '';
        result_block.style.display = 'block';
        text_price.innerText = 'Такого маршрута нет'
    } else {
        for (let i in data) {
            let checked = '';
            if (i === '0') checked = 'checked';
            html += `<li><label><input type="radio" name="w" value="${data[i].price}" data-price="" ${checked} class="visually_hidden">`;
            html += `<span class="panel_name">${data[i].name} <br> ${data[i].cubic_meter}</span></label></li>`;
        }
        block.innerHTML = html;
        let check_price = qS('input[name="w"]:checked');
        calc(check_price.value);
    }
}

function c(el) {
    console.log(el);
}