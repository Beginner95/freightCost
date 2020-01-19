@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Список Городов <a href="{{ route('admin.city.create') }}" class="btn btn-primary add-weight" title="Добавить город"><span>+</span></a></div>
                    <div class="card-body">
                        @if (empty($cities->toArray()))
                            В базе нет городов!
                        @else
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">№</th>
                                    <th scope="col">Код города</th>
                                    <th scope="col">Наименование города</th>
                                    <th scope="col">Действие</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i = 1; @endphp
                                @foreach ($cities as $city)
                                    <tr>
                                        <td width="30" scope="row">{{ $i++ }}</td>
                                        <td width="150">{{ $city->region_id }}</td>
                                        <td>{{ $city->name }}</td>
                                        <td width="150">
                                            <a href="{{ route('admin.city.edit', $city->id) }}" class="btn btn-success">Edit</a>
                                            {{ Form::open(['route' => ['admin.city.destroy', $city->id], 'style' => 'float:right;']) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            {{ Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => 'return confirm(\'Удалить город?\');']) }}
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
            {{ $cities->links() }}
        </div>
    </div>
@endsection