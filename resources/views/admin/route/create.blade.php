@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card block-weight">
                    <div class="card-header">Добавление нового маршрута</div>
                    <div class="card-body">
                        {{ Form::open(['route' => 'admin.route.store', 'method' => 'post']) }}
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="origin">Из города</label>
                                    <input type="text" id="origin-input" name="origin" class="typeahead form-control" style="width: 100%; margin: 0;" required autocomplete="off">
                                </div>
                                <div class="col">
                                    <label for="destination">В город</label>
                                    <input type="text" id="destination-input" name="destination" value="" class="typeahead form-control" style="width: 100%; margin: 0;" required autocomplete="off">
                                </div>
                            </div>

                        </div>
                        <div id="map"></div>
                        <div class="form-group weight-price">
                            <div class="row">
                                <div class="col">
                                    <label for="weight-price">Вес</label>
                                    <select name="weight[]" class="form-control">
                                        @foreach($weights as $weight)
                                            <option value="{{ $weight->id }}">{{ $weight->name }} / {{ $weight->cubic_meter }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="distance">Дистанция км</label>
                                    <input type="text" id="distance" name="distance[]" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="price">Цена</label>
                                    <input type="text" name="price[]" class="form-control">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <span class="btn btn-primary add-weight-price">&#43;</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Добавить</button>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection