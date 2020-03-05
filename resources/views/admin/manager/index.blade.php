@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Список менеджеров
                        <a
                            href="{{ route('admin.manager.create') }}"
                            class="btn btn-primary add-weight"
                            title="Добавить менеджера">
                            <span>+</span>
                        </a>
                    </div>
                    <div class="card-body">
                        @if (empty($managers->toArray()))
                            В базе нет транспорта!
                        @else
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">№</th>
                                    <th scope="col">Менеджер</th>
                                    <th scope="col">Логин</th>
                                    <th scope="col">Действие</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i = 1; @endphp
                                @foreach ($managers as $manager)
                                    <tr>
                                        <th width="30" scope="row">{{ $i++ }}</th>
                                        <td>{{ $manager->name }}</td>
                                        <td>{{ $manager->email }}</td>
                                        <td width="150">
                                            <a href="{{ route('admin.manager.edit', $manager->id) }}" class="btn btn-success">Edit</a>
                                            {{ Form::open(['route' => ['admin.manager.destroy', $manager->id], 'style' => 'float:right;']) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            {{ Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => 'return confirm(\'Удалить менеджера?\');']) }}
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