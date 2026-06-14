@extends('layouts.app')

@section('title', 'Редактировать запись для ' . $pet->name)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">Редактировать запись</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle"></i>
                        <strong>Питомец:</strong> {{ $pet->name }}
                    </div>

                    <form action="{{ route('shelter.pets.histories.update', [$pet, $history]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Дата записи *</label>
                            <input type="date" name="history_date" class="form-control @error('history_date') is-invalid @enderror" value="{{ old('history_date', $history->history_date->format('Y-m-d')) }}" required>
                            @error('history_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Тип записи *</label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="vaccination" {{ old('type', $history->type) == 'vaccination' ? 'selected' : '' }}>💉 Вакцинация</option>
                                <option value="treatment" {{ old('type', $history->type) == 'treatment' ? 'selected' : '' }}>💊 Лечение</option>
                                <option value="examination" {{ old('type', $history->type) == 'examination' ? 'selected' : '' }}>🔍 Осмотр</option>
                                <option value="surgery" {{ old('type', $history->type) == 'surgery' ? 'selected' : '' }}>🏥 Операция</option>
                                <option value="other" {{ old('type', $history->type) == 'other' ? 'selected' : '' }}>📝 Другое</option>
                            </select>
                            @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Описание *</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description', $history->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ветеринар</label>
                            <input type="text" name="veterinarian" class="form-control @error('veterinarian') is-invalid @enderror" value="{{ old('veterinarian', $history->veterinarian) }}" placeholder="ФИО ветеринара">
                            @error('veterinarian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('shelter.pets.histories.index', $pet) }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Отмена
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Обновить запись
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection