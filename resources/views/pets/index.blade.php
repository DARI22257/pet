@extends('layouts.app')

@section('title', 'Каталог питомцев')

@section('content')
<!-- Фильтры -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Поиск</label>
                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Кличка или порода">
            </div>
            <div class="col-md-3">
                <label class="form-label">Вид</label>
                <select name="category" class="form-select">
                    <option value="">Все</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Пол</label>
                <select name="gender" class="form-select">
                    <option value="">Все</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Мальчик</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Девочка</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Сортировка</label>
                <select name="sort" class="form-select">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Сначала новые</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Сначала старые</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>По кличке (А-Я)</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>По кличке (Я-А)</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Применить</button>
                <a href="{{ route('pets.index') }}" class="btn btn-secondary">Сбросить</a>
            </div>
        </form>
    </div>
</div>
<div class="container">
    <h1 class="mb-4">Наши питомцы</h1>
    
    <div class="row">
        @forelse($pets as $pet)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $pet->name }}</h5>
                        <p class="card-text">
                            <strong>Порода:</strong> {{ $pet->breed ?? 'Не указана' }}<br>
                            <strong>Возраст:</strong> {{ $pet->age_estimate ?? 'Не указан' }}
                        </p>
                        <a href="{{ route('pets.show', $pet) }}" class="btn btn-primary">Подробнее</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Пока нет питомцев. Добавьте первого питомца!</div>
            </div>
        @endforelse
    </div>
    
    {{ $pets->links() }}
</div>
@endsection