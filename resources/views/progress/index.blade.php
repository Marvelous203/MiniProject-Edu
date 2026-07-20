@extends('layouts.app')

@section('title', 'Tien do hoc tap - FlashLearn')

@section('content')
<section class="page-header">
    <span class="eyebrow">Tien do hoc tap</span>
    <h1 class="page-title">Bao cao tong hop</h1>
    <p class="lead">Theo doi ti le ghi nho, so lan hoc va ket qua quiz theo tung bo the.</p>
</section>

<section class="panel">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Bo the</th>
                    <th>So the</th>
                    <th>Phien hoc</th>
                    <th>The da nho</th>
                    <th>Quiz</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($setProgress as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->flashcards_count }}</td>
                    <td>{{ $item->study_sessions_count }}</td>
                    <td>{{ $item->study_sessions_sum_remembered_cards ?? 0 }}</td>
                    <td>{{ $item->quiz_results_count }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="small">Chua co du lieu tien do.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<section class="grid grid-2">
    <div class="panel">
        <span class="eyebrow">Phien hoc gan day</span>
        <div class="list">
            @forelse ($recentSessions as $session)
            <div class="card">
                <strong>{{ $session->flashcardSet->title }}</strong>
                <span class="small">Da nho {{ $session->remembered_cards }}/{{ $session->total_cards }} the</span>
            </div>
            @empty
            <p class="small">Chua co phien hoc nao.</p>
            @endforelse
        </div>
    </div>

    <div class="panel">
        <span class="eyebrow">Ket qua quiz</span>
        <div class="list">
            @forelse ($recentQuizResults as $quiz)
            <div class="card">
                <strong>{{ $quiz->flashcardSet->title }}</strong>
                <span class="small">Dung {{ $quiz->correct_answers }}/{{ $quiz->total_questions }} cau</span>
            </div>
            @empty
            <p class="small">Chua co luot quiz nao.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection