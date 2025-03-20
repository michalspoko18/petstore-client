@extends('layouts.app')

@section('content')
    <h1>Dodaj nowe zwierzę</h1>
    
    <form action="{{ route('pets.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="name" class="form-label">Nazwa</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Dostępny</option>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Oczekujący</option>
                <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Sprzedany</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="category_name" class="form-label">Kategoria</label>
            <input type="text" class="form-control @error('category_name') is-invalid @enderror" id="category_name" name="category_name" value="{{ old('category_name') }}">
            @error('category_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="photo_url" class="form-label">URL zdjęcia</label>
            <input type="url" class="form-control" id="photo_url" name="photo_url" value="{{ old('photo_url') }}">
        </div>
        
        <button type="submit" class="btn btn-primary">Dodaj zwierzę</button>
        <a href="{{ route('pets.index') }}" class="btn btn-secondary">Anuluj</a>
    </form>
@endsection
