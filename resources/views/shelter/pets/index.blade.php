@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Управление питомцами</h1>
    <a href="{{ route('shelter.pets.create') }}" class="btn btn-primary mb-3">Добавить питомца</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <table class="table table-bordered">
        <thead>
            <tr><th>ID</th><th>Кличка</th><th>Вид</th><th>Статус</th><th>Действия</th></tr>
        </thead>
        <tbody>
            @foreach($pets as $pet)
            <tr>
                <td>{{ $pet->id }}</td>
                <td>{{ $pet->name }}</td>
                <td>{{ $pet->category->name ?? '-' }}</td>
                <td><span class="badge bg-{{ $pet->statusColor }}">{{ $pet->statusLabel }}</span></td>
                <td>
                    <a href="{{ route('shelter.pets.edit', $pet) }}" class="btn btn-sm btn-warning">Ред.</a>
                    <form action="{{ route('shelter.pets.destroy', $pet) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Удалить?')">Уд.</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $pets->links() }}
</div>
@endsection