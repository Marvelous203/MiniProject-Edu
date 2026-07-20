@extends('layouts.app')

@section('title', 'FlashLearn - Học với Flashcard')

@section('content')
<section class="hero">
    <div>
        <span class="eyebrow">Flashcard hoc tap</span>
        <h1>Hoc nhanh, on tap de, quan ly bo the bang Laravel MVC.</h1>
        <p>
            FlashLearn la mini project giao duc giup hoc vien tao bo the, hoc theo phien,
            lam quiz nhanh va theo doi tien do nho bai. Giao dien don gian, nghiep vu ro rang,
            phu hop de demo Laravel + Blade + MySQL.
        </p>
        <div class="hero-actions">
            @auth
            <a href="{{ route('flashcard-sets.index') }}" class="btn btn-primary">Quan ly bo the</a>
            <a href="{{ route('progress.index') }}" class="btn btn-outline">Xem tien do</a>
            @else
            <a href="{{ route('register') }}" class="btn btn-primary">Bat dau mien phi</a>
            <a href="{{ route('login') }}" class="btn btn-outline">Dang nhap</a>
            @endauth
        </div>
    </div>

    <div class="metric-grid">
        <div class="metric">
            <strong>{{ $featuredSets->count() }}</strong>
            <span>Bo the cong khai san sang de tham khao</span>
        </div>
        <div class="metric">
            <strong>3 buoc</strong>
            <span>Tao bo the, hoc theo phien, kiem tra bang quiz</span>
        </div>
        <div class="metric">
            <strong>MVC</strong>
            <span>Controller, model va blade duoc tach ro rang</span>
        </div>
    </div>
</section>

<section class="grid grid-2">
    <div class="panel">
        <div class="page-header">
            <span class="eyebrow">Danh muc noi bat</span>
            <h2>Chu de hoc tap pho bien</h2>
        </div>

        <div class="list">
            @forelse ($categories as $category)
            <div class="card">
                <div class="split">
                    <div>
                        <strong>{{ $category->name }}</strong>
                        <span class="small">{{ $category->description ?: 'Danh muc dung de nhom bo the cung chu de.' }}</span>
                    </div>
                    <span class="badge">{{ $category->flashcard_sets_count }} bo the</span>
                </div>
            </div>
            @empty
            <p class="small">Seeder chua duoc chay, danh muc se xuat hien sau khi migrate va seed.</p>
            @endforelse
        </div>
    </div>

    <div class="panel">
        <div class="page-header">
            <span class="eyebrow">Gia tri du an</span>
            <h2>Chuc nang chinh co trong bai demo</h2>
        </div>
        <div class="list">
            <div class="card"><strong>CRUD bo the va flashcard</strong><span class="small">Tao, sua, xoa bo the va quan ly noi dung hoi dap.</span></div>
            <div class="card"><strong>Phien hoc tuong tac</strong><span class="small">Lat the, danh dau da nho hoac quen, luu ket qua theo tung the.</span></div>
            <div class="card"><strong>Quiz nhanh</strong><span class="small">Kiem tra lai kien thuc va luu diem sau moi lan lam quiz.</span></div>
            <div class="card"><strong>Khu quan tri</strong><span class="small">Quan ly danh muc, thong ke nguoi dung va kiem soat bo the cong khai.</span></div>
        </div>
    </div>
</section>

<section class="panel">
    <div class="page-header">
        <span class="eyebrow">Bo the cong khai</span>
        <h2>Bo flashcard mau de tham khao</h2>
    </div>

    <div class="grid grid-3">
        @forelse ($featuredSets as $set)
        <article class="card">
            <div class="split">
                <span class="badge">{{ $set->difficulty_level }}</span>
                <span class="small">{{ $set->category?->name ?: 'Chua gan danh muc' }}</span>
            </div>
            <h3>{{ $set->title }}</h3>
            <p class="small">{{ $set->description ?: 'Bo the nay dung de minh hoa noi dung hoc tap va quiz nhanh.' }}</p>
            <div class="card-actions">
                <span class="small">{{ $set->flashcards_count }} the</span>
                <span class="small">Tao boi {{ $set->user->name }}</span>
            </div>
        </article>
        @empty
        <p class="small">Chua co bo the cong khai. Sau khi chay seeder, du lieu demo se xuat hien tai day.</p>
        @endforelse
    </div>
</section>
@endsection