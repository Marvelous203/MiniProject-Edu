@extends('layouts.app')

@section('title', 'Bo flashcard - FlashLearn')

@section('content')
    <section class="page-header split">
        <div>
            <span class="eyebrow">Bo flashcard</span>
            <h1 class="page-title">Thu vien hoc tap cua ban</h1>
            <p class="lead">Sap xep cac bo the theo chu de, muc do va kha nang chia se cong khai.</p>
        </div>
        <a href="{{ route('flashcard-sets.create') }}" class="btn btn-primary">Tao bo flashcard</a>
    </section>

    <section class="grid grid-3">
        @forelse ($flashcardSets as $set)
            <article class="card">
                <div class="split">
                    <span class="badge">{{ $set->visibility }}</span>
                    <span class="small">{{ $set->difficulty_level }}</span>
                </div>
                <h3>{{ $set->title }}</h3>
                <p class="small">{{ $set->description ?: 'Bo flashcard nay chua co mo ta.' }}</p>
                <div class="card-actions">
                    <span class="small">{{ $set->flashcards_count }} the</span>
                    <span class="small">{{ $set->category?->name ?: 'Khong co danh muc' }}</span>
                </div>
                <a href="{{ route('flashcard-sets.show', $set) }}" class="btn btn-outline">Xem chi tiet</a>
            </article>
        @empty
            <div class="panel">
                <strong>Chua co bo flashcard nao</strong>
                <p class="small">Hay tao bo dau tien de bat dau hoc tap.</p>
            </div>
        @endforelse
    </section>

    <section class="panel">
        {{ $flashcardSets->links() }}
    </section>
@endsection
