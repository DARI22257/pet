@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Добавить категорию</h1>
    
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label>Название категории</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        
        <div class="mb-3">
            <label>Описание</label>
            <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-success">Сохранить</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection