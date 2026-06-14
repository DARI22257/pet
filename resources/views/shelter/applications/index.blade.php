@extends('layouts.app')

@section('title', 'Управление заявками')

@section('content')
<div class="container">
    <h1 class="mb-4">Управление заявками на усыновление</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Питомец</th>
                    <th>Заявитель</th>
                    <th>Телефон</th>
                    <th>Дата подачи</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $app)
                <tr>
                    <td>{{ $app->id }}</td>
                    <td>
                        <a href="{{ route('pets.show', $app->pet) }}">
                            {{ $app->pet->name }}
                        </a>
                    </td>
                    <td>{{ $app->full_name }}</td>
                    <td>{{ $app->phone }}</td>
                    <td>{{ $app->created_at->format('d.m.Y') }}</td>
                    <td>
                        <span class="badge bg-{{ $app->statusColor }}">
                            {{ $app->statusLabel }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('shelter.applications.show', $app) }}" class="btn btn-sm btn-primary">
                            Просмотр
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {{ $applications->links() }}
</div>
@endsection