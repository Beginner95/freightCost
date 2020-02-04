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

let text_distance = qS('#distance');

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
                text_distance.value = response.routes[0].legs[0].distance.text;
            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
};

function qS(el) {
    return document.querySelector(el);
}

$('input.typeahead').typeahead({
    source:  function (query, process) {
        return $.get('autocomplete', {query:query}, function (data) {
            return process(data);
        });
    }
});

const weight_block = qS('.block-weight');
weight_block.addEventListener('click', blockWeight);

function blockWeight(e) {
    if (e.target.classList.contains('remove-weight-block')) {
        e.target.parentNode.parentNode.parentNode.remove()
    }

    if (e.target.classList.contains('add-weight-price')) {
        addWeightPrice();
    }
}

function addWeightPrice() {
    let block = qS('.weight-price');
    let div = createElement('div');
    block.appendChild(div);
    let addBlock = `
        <div class="row">
            <div class="col">
                <label for="weight-price">Вес</label>
                <select name="weight[]" class="form-control"></select>
            </div>
            <div class="col">
                <label for="distance">Дистанция км</label>
                <input type="text" id="distance" name="distance[]" class="form-control" value="${text_distance.value}">
            </div>
            <div class="col">
                <label for="price">Цена</label>
                <input type="text" name="price[]" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for=""></label>
                <span class="btn btn-danger float-right remove-weight-block">x</span>
            </div>
        </div>
    `;
    div.innerHTML = addBlock;
    let weights = qSAll('select[name="weight[]"]');
    weights[weights.length - 1].innerHTML = weights[0].innerHTML;
}

function qS(el) {
    return document.querySelector(el);
}

function qSAll(els) {
    return document.querySelectorAll(els);
}

function createElement(el) {
    return document.createElement(el)
}

function c(el) {
    console.log(el);
}