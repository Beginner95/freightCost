@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Список маршрутов <a href="{{ route('admin.route.create') }}" class="btn btn-primary add-weight" title="Добавить маршрут"><span>+</span></a></div>
                    <div class="card-body">
                        @if (empty($routes->toArray()))
                            В базе нет маршрутов!
                        @else
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">№</th>
                                    <th scope="col">Из города</th>
                                    <th scope="col">В город</th>
                                    <th scope="col">Вес / Цена</th>
                                    <th scope="col">Действие</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i = 1; @endphp
                                @foreach ($routes as $route)
                                    <tr>
                                        <td width="30" scope="row">{{ $i++ }}</td>
                                        <td>{{ $route->cityOrigin->name }}</td>
                                        <td>{{ $route->cityDestination->name }}</td>
                                        <td>
                                            @foreach($route->weights as $weight)
                                                {{ $weight->name }} / {{ $weight->pivot->price }} <br>
                                            @endforeach
                                        </td>
                                        <td width="150">
                                            <a href="{{ route('admin.route.edit', $route->id) }}" class="btn btn-success">Edit</a>
                                            {{ Form::open(['route' => ['admin.route.destroy', $route->id], 'style' => 'float:right;']) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            {{ Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => 'return confirm(\'Удалить город?\');']) }}
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $routes->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection