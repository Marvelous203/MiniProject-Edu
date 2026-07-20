@extends('layouts.app')

@section('title', 'Quiz nhanh - FlashLearn')

@section('content')
    <section class="page-header">
        <span class="eyebrow">Quiz nhanh</span>
        <h1 class="page-title">{{ $flashcardSet->title }}</h1>
        <p class="lead">Nhap dap an tu do de kiem tra kha nang ghi nho cua ban.</p>
    </section>

    @if ($result)
        <section class="panel">
            <div class="metric">
                <strong>{{ $result['correct_count'] }}/{{ $result['total_questions'] }}</strong>
                <span>So cau tra loi dung trong lan quiz nay</span>
            </div>
        </section>
    @endif

    <section class="panel">
        @if ($quizCards->isEmpty())
            <p class="small">Bo the nay chua du flashcard de tao quiz.</p>
        @else
            <form method="POST" action="{{ route('quiz.submit', $flashcardSet) }}" class="form-grid">
                @csrf

                @foreach ($quizCards as $card)
                    <div class="card">
                        <input type="hidden" name="card_ids[]" value="{{ $card->id }}">
                        <strong>Cau {{ $loop->iteration }}: {{ $card->question }}</strong>
                        <label style="margin-top:12px;">
                            Dap an cua ban
                            <input
                                type="text"
                                name="answers[{{ $card->id }}]"
                                value="{{ old("answers.$card->id", $result['answers'][$card->id] ?? '') }}"
                                required
                            >
                        </label>

                        @if ($result)
                            <div class="small" style="margin-top:10px;">
                                Dap an dung: <strong>{{ $card->answer }}</strong>
                            </div>
                        @endif
                    </div>
                @endforeach

                <div class="card-actions">
                    <button type="submit" class="btn btn-primary">Cham diem quiz</button>
                    <a href="{{ route('quiz.show', $flashcardSet) }}" class="btn btn-outline">Tao de moi</a>
                </div>
            </form>
        @endif
    </section>
@endsection
