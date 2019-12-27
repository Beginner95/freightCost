@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Добавление нового транспорта</div>
                    <div class="card-body">
                        {{ Form::open(['route' => 'admin.index.store', 'method' => 'post']) }}
                        <div class="form-group">
                            <label for="name">Грузоподъемность</label>
                            <input type="text" name="name" value="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="cubic">Габариты</label>
                            <input type="text" name="cubic-meter" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="price">Цена</label>
                            <input type="text" name="price" value="" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection