@extends('layouts.app')

@section('title', $pet->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            @if($pet->primaryPhoto)
                <img src="{{ asset('storage/' . $pet->primaryPhoto->photo_path) }}" class="img-fluid rounded" alt="{{ $pet->name }}">
            @else
                <div class="bg-secondary text-white text-center p-5 rounded">
                    <i class="bi bi-camera" style="font-size: 3rem;"></i>
                    <p>Нет фото</p>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <h1>{{ $pet->name }}</h1>
            <p><strong>Вид:</strong> {{ $pet->category->name ?? 'Не указан' }}</p>
            <p><strong>Порода:</strong> {{ $pet->breed ?? 'Не указана' }}</p>
            <p><strong>Возраст:</strong> {{ $pet->age_estimate ?? 'Не указан' }}</p>
            <p><strong>Пол:</strong> {{ $pet->gender === 'male' ? 'Мальчик' : 'Девочка' }}</p>
            <p><strong>Описание:</strong> {{ $pet->description ?? 'Нет описания' }}</p>
            
            <!-- Кнопка вызова формы заявки -->
            <button type="button" class="btn btn-success btn-lg mt-3" data-bs-toggle="modal" data-bs-target="#applicationModal">
                <i class="bi bi-heart"></i> Хочу усыновить!
            </button>
        </div>
    </div>

    <!-- Модальное окно формы заявки -->
    <div class="modal fade" id="applicationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('applications.apply', $pet) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Заявка на усыновление {{ $pet->name }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ваше ФИО *</label>
                                <input type="text" name="full_name" class="form-control" value="{{ old('full_name', auth()->user()->name ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Телефон *</label>
                                <input type="tel" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Адрес проживания *</label>
                            <textarea name="address" class="form-control" rows="2" required>{{ old('address') }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Опыт содержания животных *</label>
                            <textarea name="experience" class="form-control" rows="3" required>{{ old('experience') }}</textarea>
                            <small class="text-muted">Например: были ли ранее питомцы, какой опыт ухода и т.д.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Цель усыновления *</label>
                            <textarea name="purpose" class="form-control" rows="2" required>{{ old('purpose') }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Условия содержания *</label>
                            <textarea name="living_conditions" class="form-control" rows="3" required>{{ old('living_conditions') }}</textarea>
                            <small class="text-muted">Квартира/дом, наличие других животных, детей и т.д.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-success">Отправить заявку</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Блок истории лечения -->
    @if($pet->histories->count() > 0)
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">📋 История лечения</h4>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @foreach($pet->histories->take(5) as $history)
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <span class="badge bg-{{ $history->type_color }}">
                                            {{ $history->type_label }}
                                        </span>
                                        <strong class="ms-2">{{ $history->formatted_date }}</strong>
                                    </div>
                                </div>
                                <p class="mb-1">{{ $history->description }}</p>
                                @if($history->veterinarian)
                                    <small class="text-muted">Ветеринар: {{ $history->veterinarian }}</small>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    
                    @if($pet->histories->count() > 5)
                        <div class="text-center mt-2">
                            <a href="{{ route('shelter.pets.histories.index', $pet) }}" class="btn btn-sm btn-outline-info">
                                Показать все {{ $pet->histories->count() }} записей
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
@endsection