@extends('layouts.app')

@section('title', 'Dang ky - FlashLearn')

@section('content')
    <div class="auth-layout">
        <section class="auth-card stack-vertical">
            <div>
                <span class="eyebrow">Tao tai khoan</span>
                <h1 class="page-title">Khoi tao khong gian hoc bang flashcard</h1>
                <p class="lead">Tao tai khoan hoc vien de bat dau xay dung bo the hoc tap cua rieng ban.</p>
            </div>

            <form method="POST" action="{{ route('register.store') }}" class="form-grid">
                @csrf

                <label>
                    Ho ten
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </label>

                <label>
                    Email
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </label>

                <label>
                    Mat khau
                    <input type="password" name="password" required>
                </label>

                <label>
                    Xac nhan mat khau
                    <input type="password" name="password_confirmation" required>
                </label>

                <button type="submit" class="btn btn-primary">Dang ky</button>
            </form>
        </section>
    </div>
@endsection
