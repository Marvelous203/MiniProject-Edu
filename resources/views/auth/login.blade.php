@extends('layouts.app')

@section('title', 'Dang nhap - FlashLearn')

@section('content')
<div class="auth-layout">
    <section class="auth-card stack-vertical">
        <div>
            <span class="eyebrow">Dang nhap</span>
            <h1 class="page-title">Tiep tuc phien hoc cua ban</h1>
            <p class="lead">Dang nhap de quan ly bo the, hoc flashcard va xem tien do on tap.</p>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="form-grid">
            @csrf

            <label>
                Email
                <input type="email" name="email" value="{{ old('email') }}" required>
            </label>

            <label>
                Mat khau
                <input type="password" name="password" required>
            </label>

            <label class="small">
                <input type="checkbox" name="remember" value="1" style="width:auto;">
                Ghi nho dang nhap tren trinh duyet nay
            </label>

            <button type="submit" class="btn btn-primary">Dang nhap</button>
        </form>
    </section>
</div>
@endsection