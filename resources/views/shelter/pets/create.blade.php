@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Добавить питомца</h1>
    
    <form action="{{ route('shelter.pets.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label>Кличка</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        
        <div class="mb-3">
            <label>Вид</label>
            <select name="species_id" class="form-control @error('species_id') is-invalid @enderror" required>
                <option value="">Выберите вид</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('species_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('species_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        
        <div class="mb-3">
            <label>Порода</label>
            <input type="text" name="breed" class="form-control" value="{{ old('breed') }}">
        </div>
        
        <div class="mb-3">
            <label>Возраст</label>
            <input type="text" name="age_estimate" class="form-control" value="{{ old('age_estimate') }}" required>
        </div>
        
        <div class="mb-3">
            <label>Пол</label>
            <select name="gender" class="form-control" required>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Мальчик</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Девочка</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label>Описание</label>
            <textarea name="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
        </div>
        
        <div class="mb-3">
            <label>Статус</label>
            <select name="status" class="form-control" required>
                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Доступен</option>
                <option value="treatment" {{ old('status') == 'treatment' ? 'selected' : '' }}>На лечении</option>
                <option value="adopted" {{ old('status') == 'adopted' ? 'selected' : '' }}>Усыновлён</option>
                <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Зарезервирован</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-success">Сохранить</button>
        <a href="{{ route('shelter.pets.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection