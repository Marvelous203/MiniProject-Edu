@extends('layouts.app')

@section('title', $flashcardSet->title . ' - FlashLearn')

@section('content')
    <section class="page-header split">
        <div>
            <span class="eyebrow">Chi tiet bo the</span>
            <h1 class="page-title">{{ $flashcardSet->title }}</h1>
            <p class="lead">{{ $flashcardSet->description ?: 'Bo the nay duoc dung de hoc theo phien va lam quiz nhanh.' }}</p>
        </div>
        <div class="card-actions">
            <a href="{{ route('flashcard-sets.edit', $flashcardSet) }}" class="btn btn-outline">Sua thong tin</a>
            <form method="POST" action="{{ route('flashcard-sets.destroy', $flashcardSet) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Xoa bo the</button>
            </form>
        </div>
    </section>

    <section class="grid grid-3">
        <div class="metric">
            <strong>{{ $flashcardSet->flashcards->count() }}</strong>
            <span>Flashcard trong bo</span>
        </div>
        <div class="metric">
            <strong>{{ $flashcardSet->studySessions->count() }}</strong>
            <span>Phien hoc da luu</span>
        </div>
        <div class="metric">
            <strong>{{ $flashcardSet->quizResults->count() }}</strong>
            <span>Lan quiz da lam</span>
        </div>
    </section>

    <section class="panel">
        <div class="split">
            <div>
                <span class="eyebrow">Hanh dong nhanh</span>
                <h2>Hoc va kiem tra</h2>
            </div>
            <div class="card-actions">
                <form method="POST" action="{{ route('study-sessions.start', $flashcardSet) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Bat dau hoc</button>
                </form>
                <a href="{{ route('quiz.show', $flashcardSet) }}" class="btn btn-secondary">Lam quiz</a>
            </div>
        </div>
    </section>

    <section class="grid grid-2">
        <div class="panel">
            <span class="eyebrow">Them flashcard</span>
            <h2>Tao noi dung hoi dap</h2>

            <form method="POST" action="{{ route('flashcards.store', $flashcardSet) }}" class="form-grid">
                @csrf
                <label>
                    Cau hoi / Mat truoc
                    <textarea name="question" required>{{ old('question') }}</textarea>
                </label>

                <label>
                    Dap an / Mat sau
                    <textarea name="answer" required>{{ old('answer') }}</textarea>
                </label>

                <label>
                    Ghi chu bo sung
                    <textarea name="note">{{ old('note') }}</textarea>
                </label>

                <button type="submit" class="btn btn-primary">Them the hoc</button>
            </form>
        </div>

        <div class="panel">
            <span class="eyebrow">Thong tin bo the</span>
            <h2>Cau hinh hien tai</h2>
            <div class="list">
                <div class="card"><strong>Danh muc</strong><span class="small">{{ $flashcardSet->category?->name ?: 'Chua gan danh muc' }}</span></div>
                <div class="card"><strong>Do kho</strong><span class="small">{{ $flashcardSet->difficulty_level }}</span></div>
                <div class="card"><strong>Trang thai</strong><span class="small">{{ $flashcardSet->visibility }}</span></div>
            </div>
        </div>
    </section>

    <section class="panel">
        <span class="eyebrow">Danh sach the</span>
        <h2>Quan ly tung flashcard</h2>

        <div class="list">
            @forelse ($flashcardSet->flashcards as $card)
                <details class="card">
                    <summary><strong>{{ $loop->iteration }}. {{ \Illuminate\Support\Str::limit($card->question, 80) }}</strong></summary>
                    <form method="POST" action="{{ route('flashcards.update', [$flashcardSet, $card]) }}" class="form-grid" style="margin-top:16px;">
                        @csrf
                        @method('PUT')
                        <label>
                            Cau hoi
                            <textarea name="question" required>{{ $card->question }}</textarea>
                        </label>
                        <label>
                            Dap an
                            <textarea name="answer" required>{{ $card->answer }}</textarea>
                        </label>
                        <label>
                            Ghi chu
                            <textarea name="note">{{ $card->note }}</textarea>
                        </label>
                        <div class="split">
                            <button type="submit" class="btn btn-outline">Cap nhat the</button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('flashcards.destroy', [$flashcardSet, $card]) }}" style="margin-top:12px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xoa the nay</button>
                    </form>
                </details>
            @empty
                <p class="small">Chua co flashcard nao trong bo nay.</p>
            @endforelse
        </div>
    </section>
@endsection
