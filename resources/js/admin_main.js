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