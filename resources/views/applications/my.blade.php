@extends('layouts.app')

@section('title', 'Мои заявки')

@section('content')
<div class="container">
    <h1 class="mb-4">Мои заявки на усыновление</h1>
    
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
                    <th>Дата подачи</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                <tr>
                    <td>{{ $app->id }}</td>
                    <td>
                        <a href="{{ route('pets.show', $app->pet) }}">
                            {{ $app->pet->name }}
                        </a>
                    </td>
                    <td>{{ $app->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <span class="badge bg-{{ $app->statusColor }}">
                            {{ $app->statusLabel }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('applications.show', $app) }}" class="btn btn-sm btn-info">
                            Подробнее
                        </a>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            У вас пока нет заявок. 
                            <a href="{{ route('pets.index') }}">Посмотрите питомцев</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{ $applications->links() }}
</div>
@endsection