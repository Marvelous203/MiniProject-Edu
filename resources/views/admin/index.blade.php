@extends('layouts.app')

@section('title', 'Quan tri - FlashLearn')

@section('content')
    <section class="page-header">
        <span class="eyebrow">Khu quan tri</span>
        <h1 class="page-title">Tong quan he thong</h1>
        <p class="lead">Quan ly danh muc, thong ke nguoi dung va kiem soat bo the cong khai.</p>
    </section>

    <section class="grid grid-3">
        <div class="metric"><strong>{{ $stats['user_count'] }}</strong><span>Tong nguoi dung</span></div>
        <div class="metric"><strong>{{ $stats['student_count'] }}</strong><span>Hoc vien</span></div>
        <div class="metric"><strong>{{ $stats['public_set_count'] }}</strong><span>Bo the cong khai</span></div>
    </section>

    <section class="grid grid-2">
        <div class="panel">
            <span class="eyebrow">Danh muc</span>
            <h2>Tao danh muc moi</h2>

            <form method="POST" action="{{ route('admin.categories.store') }}" class="form-grid">
                @csrf
                <label>
                    Ten danh muc
                    <input type="text" name="name" required>
                </label>
                <label>
                    Mo ta ngan
                    <input type="text" name="description">
                </label>
                <button type="submit" class="btn btn-primary">Them danh muc</button>
            </form>

            <div class="list" style="margin-top:20px;">
                @foreach ($categories as $category)
                    <div class="card split">
                        <div>
                            <strong>{{ $category->name }}</strong>
                            <span class="small">{{ $category->flashcard_sets_count }} bo the</span>
                        </div>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xoa</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="panel">
            <span class="eyebrow">Bo the cong khai</span>
            <div class="list">
                @forelse ($publicSets as $set)
                    <div class="card">
                        <div class="split">
                            <div>
                                <strong>{{ $set->title }}</strong>
                                <span class="small">{{ $set->user->name }} - {{ $set->category?->name ?: 'Khong co danh muc' }}</span>
                            </div>
                            <span class="badge">{{ $set->flashcards_count }} the</span>
                        </div>

                        <form method="POST" action="{{ route('admin.sets.toggle', $set) }}" style="margin-top:12px;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline">
                                Chuyen sang {{ $set->visibility === 'public' ? 'private' : 'public' }}
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="small">Chua co bo the cong khai nao.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
