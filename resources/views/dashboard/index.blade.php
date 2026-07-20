@extends('layouts.app')

@section('title', 'Dashboard - FlashLearn')

@section('content')
    <section class="page-header">
        <span class="eyebrow">Dashboard hoc vien</span>
        <h1 class="page-title">Tong quan hoat dong hoc tap</h1>
        <p class="lead">Theo doi bo the, cac phien hoc gan day va ket qua quiz cua ban.</p>
    </section>

    <section class="grid grid-4 metric-grid">
        <div class="metric">
            <strong>{{ $stats['set_count'] }}</strong>
            <span>Bo flashcard</span>
        </div>
        <div class="metric">
            <strong>{{ $stats['card_count'] }}</strong>
            <span>Tong so the hoc</span>
        </div>
        <div class="metric">
            <strong>{{ $stats['session_count'] }}</strong>
            <span>Phien hoc da luu</span>
        </div>
        <div class="metric">
            <strong>{{ $stats['quiz_count'] }}</strong>
            <span>Luot quiz da lam</span>
        </div>
    </section>

    <section class="grid grid-2">
        <div class="panel">
            <div class="split">
                <div>
                    <span class="eyebrow">Bo the gan day</span>
                    <h2>Quan ly noi dung hoc tap</h2>
                </div>
                <a href="{{ route('flashcard-sets.create') }}" class="btn btn-primary">Tao bo moi</a>
            </div>

            <div class="list">
                @forelse ($flashcardSets as $set)
                    <div class="card">
                        <div class="split">
                            <div>
                                <strong>{{ $set->title }}</strong>
                                <span class="small">{{ $set->category?->name ?: 'Chua co danh muc' }}</span>
                            </div>
                            <span class="badge">{{ $set->flashcards_count }} the</span>
                        </div>
                        <p class="small">{{ $set->description ?: 'Bo the nay chua co mo ta.' }}</p>
                        <a href="{{ route('flashcard-sets.show', $set) }}" class="btn btn-outline">Mo bo the</a>
                    </div>
                @empty
                    <p class="small">Ban chua tao bo the nao.</p>
                @endforelse
            </div>
        </div>

        <div class="panel">
            <span class="eyebrow">Hoat dong gan day</span>
            <h2>Phien hoc va quiz</h2>

            <div class="list">
                @forelse ($recentSessions as $session)
                    <div class="card">
                        <strong>Phien hoc: {{ $session->flashcardSet->title }}</strong>
                        <span class="small">
                            Da nho {{ $session->remembered_cards }}/{{ $session->total_cards }} the
                            - {{ $session->created_at->format('d/m/Y H:i') }}
                        </span>
                    </div>
                @empty
                    <div class="card">
                        <strong>Chua co phien hoc</strong>
                        <span class="small">Hay bat dau hoc mot bo the de thong ke xuat hien.</span>
                    </div>
                @endforelse

                @foreach ($recentQuizResults as $quiz)
                    <div class="card">
                        <strong>Quiz: {{ $quiz->flashcardSet->title }}</strong>
                        <span class="small">
                            Dung {{ $quiz->correct_answers }}/{{ $quiz->total_questions }} cau
                            - {{ $quiz->created_at->format('d/m/Y H:i') }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
