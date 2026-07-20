@extends('layouts.app')

@section('title', $pageTitle . ' - FlashLearn')

@section('content')
    <section class="page-header">
        <span class="eyebrow">Quan ly bo the</span>
        <h1 class="page-title">{{ $pageTitle }}</h1>
        <p class="lead">Nhap thong tin co ban de to chuc bo flashcard theo dung danh muc va muc do.</p>
    </section>

    <section class="panel">
        <form method="POST" action="{{ $formAction }}" class="form-grid">
            @csrf
            @if ($formMethod !== 'POST')
                @method($formMethod)
            @endif

            <label>
                Ten bo flashcard
                <input type="text" name="title" value="{{ old('title', $flashcardSet->title) }}" required>
            </label>

            <label>
                Mo ta
                <textarea name="description">{{ old('description', $flashcardSet->description) }}</textarea>
            </label>

            <div class="form-grid two">
                <label>
                    Danh muc
                    <select name="category_id">
                        <option value="">Chon danh muc</option>
                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected((string) old('category_id', $flashcardSet->category_id) === (string) $category->id)
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label>
                    Muc do
                    <select name="difficulty_level" required>
                        @foreach (['easy' => 'De', 'medium' => 'Trung binh', 'hard' => 'Kho'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('difficulty_level', $flashcardSet->difficulty_level ?: 'medium') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>

            <label>
                Che do hien thi
                <select name="visibility" required>
                    <option value="private" @selected(old('visibility', $flashcardSet->visibility ?: 'private') === 'private')>Private</option>
                    <option value="public" @selected(old('visibility', $flashcardSet->visibility) === 'public')>Public</option>
                </select>
            </label>

            <div class="card-actions">
                <button type="submit" class="btn btn-primary">Luu bo the</button>
                <a href="{{ route('flashcard-sets.index') }}" class="btn btn-outline">Quay lai</a>
            </div>
        </form>
    </section>
@endsection
