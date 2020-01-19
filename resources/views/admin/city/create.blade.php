@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Добавление нового города</div>
                    <div class="card-body">
                        {{ Form::open(['route' => 'admin.city.store', 'method' => 'post']) }}
                        <div class="form-group">
                            <label for="name">Код города</label>
                            <input type="text" name="region-id" value="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="cubic">Наименование города</label>
                            <input type="text" name="city" value="" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection