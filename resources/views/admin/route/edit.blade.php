@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card block-weight">
                    <div class="card-header">Редактирование маршрута</div>
                    <div class="card-body">
                        {{ Form::open(['route' => ['admin.route.update', $route->id], 'method' => 'PUT']) }}
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="origin">Из города</label>
                                    <input type="text" name="origin" class="typeahead form-control" required value="{{ $route->cityOrigin->name }}">
                                </div>
                                <div class="col">
                                    <label for="destination">В город</label>
                                    <input type="text" name="destination" class="typeahead form-control" required value="{{ $route->cityDestination->name }}">
                                </div>
                            </div>

                        </div>
                        <div class="form-group weight-price">
                            @foreach($route->weights as $key => $weight)
                                <div>
                                    <div class="row">
                                        <div class="col">
                                            <label for="weight-price">Вес</label>
                                            <select name="weight[]" class="form-control">
                                                @foreach($weights as $w)
                                                    <option value="{{ $w->id }}" @if ($weight->id === $w->id) selected @endif>{{ $w->name }} / {{ $w->cubic_meter }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="price">Цена</label>
                                            <input type="text" name="price[]" class="form-control" value="{{ $weight->pivot->price }}">
                                        </div>
                                    </div>
                                    @if ($key > 0)
                                        <div class="row">
                                            <div class="col">
                                                <label for=""></label>
                                                <span class="btn btn-danger float-right remove-weight-block">x</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <span class="btn btn-primary add-weight-price">&#43;</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection