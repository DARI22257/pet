@extends('layouts.app')

@section('title', 'Моё расписание')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Моё расписание</h1>
        <a href="{{ route('volunteer.schedules.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Добавить смену
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Дата</th>
                    <th>Время</th>
                    <th>Питомец</th>
                    <th>Тип деятельности</th>
                    <th>Заметки</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->schedule_date->format('d.m.Y') }}</td>
                    <td>{{ $schedule->time_range }}</td>
                    <td>
                        @if($schedule->pet)
                            <a href="{{ route('pets.show', $schedule->pet) }}">
                                {{ $schedule->pet->name }}
                            </a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ $schedule->activity_color }}">
                            {{ $schedule->activity_type_label }}
                        </span>
                    </td>
                    <td>{{ Str::limit($schedule->notes, 50) ?? '—' }}</td>
                    <td>
                        <a href="{{ route('volunteer.schedules.edit', $schedule) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('volunteer.schedules.destroy', $schedule) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Удалить смену?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            У вас пока нет запланированных смен.
                            <a href="{{ route('volunteer.schedules.create') }}">Добавить первую смену</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{ $schedules->links() }}
</div>
@endsection