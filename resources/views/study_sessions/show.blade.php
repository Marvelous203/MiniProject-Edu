@extends('layouts.app')

@section('title', 'Phien hoc - FlashLearn')

@section('content')
<section class="page-header">
    <span class="eyebrow">Phien hoc</span>
    <h1 class="page-title">{{ $studySession->flashcardSet->title }}</h1>
    <p class="lead">
        Da hoan thanh {{ $answeredCount }}/{{ $studySession->total_cards }} the.
        So the da nho: {{ $studySession->remembered_cards }}.
    </p>
</section>

<section class="study-card">
    @if ($completed)
    <div class="stack-vertical">
        <span class="eyebrow">Hoan thanh</span>
        <h2>Ban da ket thuc phien hoc nay</h2>
        <p class="lead">
            Tong ket:
            {{ $studySession->remembered_cards }}/{{ $studySession->total_cards }} the duoc danh dau da nho.
        </p>

        <div class="card-actions">
            <a href="{{ route('flashcard-sets.show', $studySession->flashcardSet) }}" class="btn btn-outline">Quay lai bo the</a>
            <a href="{{ route('progress.index') }}" class="btn btn-primary">Xem tien do</a>
        </div>
    </div>
    @else
    <div class="stack-vertical">
        <div class="flashcard-face">
            <span class="eyebrow">The tiep theo</span>
            <h2>{{ $nextCard->question }}</h2>

            <button type="button" class="btn btn-outline" onclick="document.getElementById('flashcard-answer').classList.toggle('hidden')">
                Lat the xem dap an
            </button>

            <div id="flashcard-answer" class="flashcard-answer hidden">
                <strong>Dap an</strong>
                <p>{{ $nextCard->answer }}</p>

                @if ($nextCard->note)
                <p class="small">Ghi chu: {{ $nextCard->note }}</p>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('study-sessions.answer', $studySession) }}" class="study-actions">
            @csrf
            <input type="hidden" name="flashcard_id" value="{{ $nextCard->id }}">

            <button type="submit" name="result" value="forgotten" class="btn btn-danger">Chua nho</button>
            <button type="submit" name="result" value="remembered" class="btn btn-primary">Da nho</button>
        </form>
    </div>
    @endif
</section>

<section class="panel">
    <span class="eyebrow">Lich su phien hoc</span>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Cau hoi</th>
                    <th>Ket qua</th>
                    <th>Thoi gian</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($studySession->sessionResults as $result)
                <tr>
                    <td>{{ $result->flashcard->question }}</td>
                    <td>{{ $result->result }}</td>
                    <td>{{ $result->reviewed_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="small">Chua co ket qua nao trong phien hoc nay.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection