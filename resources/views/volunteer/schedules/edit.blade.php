@extends('layouts.app')

@section('title', 'Редактировать смену')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">Редактировать смену</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('volunteer.schedules.update', $schedule) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Дата смены *</label>
                            <input type="date" name="schedule_date" class="form-control @error('schedule_date') is-invalid @enderror" value="{{ old('schedule_date', $schedule->schedule_date->format('Y-m-d')) }}" required>
                            @error('schedule_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Начало *</label>
                                <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}" required>
                                @error('start_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Окончание *</label>
                                <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}" required>
                                @error('end_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Тип деятельности *</label>
                            <select name="activity_type" class="form-select @error('activity_type') is-invalid @enderror" required>
                                <option value="walking" {{ old('activity_type', $schedule->activity_type) == 'walking' ? 'selected' : '' }}>🚶 Выгул</option>
                                <option value="feeding" {{ old('activity_type', $schedule->activity_type) == 'feeding' ? 'selected' : '' }}>🍖 Кормление</option>
                                <option value="cleaning" {{ old('activity_type', $schedule->activity_type) == 'cleaning' ? 'selected' : '' }}>🧹 Уборка</option>
                                <option value="grooming" {{ old('activity_type', $schedule->activity_type) == 'grooming' ? 'selected' : '' }}>✂️ Груминг</option>
                                <option value="other" {{ old('activity_type', $schedule->activity_type) == 'other' ? 'selected' : '' }}>📋 Другое</option>
                            </select>
                            @error('activity_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Питомец (опционально)</label>
                            <select name="pet_id" class="form-select">
                                <option value="">— Не выбран —</option>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->id }}" {{ old('pet_id', $schedule->pet_id) == $pet->id ? 'selected' : '' }}>
                                        {{ $pet->name }} ({{ $pet->category->name ?? 'без категории' }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Можно выбрать конкретного питомца или оставить пустым для общей смены</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Заметки</label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $schedule->notes) }}</textarea>
                            @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('volunteer.schedules.index') }}" class="btn btn-secondary">Отмена</a>
                            <button type="submit" class="btn btn-success">Обновить смену</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection