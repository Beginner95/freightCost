@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Редактирование города</div>
                    <div class="card-body">
                        {{ Form::open(['route' => ['admin.city.update', $city->id], 'method' => 'PUT']) }}
                        <div class="form-group">
                            <label for="name">Код города</label>
                            <input type="text" name="region-id" value="{{ $city->region_id }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="cubic">Наименование города</label>
                            <input type="text" name="city" value="{{ $city->name }}" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection