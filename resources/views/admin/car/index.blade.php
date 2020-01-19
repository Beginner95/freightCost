@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Список транспортов <a href="{{ route('admin.car.create') }}" class="btn btn-primary add-weight" title="Добавить транспорт"><span>+</span></a></div>
                    <div class="card-body">
                        @if (empty($weights->toArray()))
                            В базе нет транспорта!
                        @else
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">№</th>
                                    <th scope="col">Грузоподъемность</th>
                                    <th scope="col">Габарит</th>
                                    <th scope="col">Цена</th>
                                    <th scope="col">Действие</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($weights as $weight)
                                    <tr>
                                        <th width="30" scope="row">{{ $i++ }}</th>
                                        <td>{{ $weight->name }}</td>
                                        <td>{{ $weight->cubic_meter }}</td>
                                        <td>{{ $weight->price }}</td>
                                        <td width="150">
                                            <a href="{{ route('admin.car.edit', $weight->id) }}" class="btn btn-success">Edit</a>
                                            {{ Form::open(['route' => ['admin.car.destroy', $weight->id], 'style' => 'float:right;']) }}
                                                {{ Form::hidden('_method', 'DELETE') }}
                                                {{ Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => 'return confirm(\'Удалить транспорт?\');']) }}

                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection