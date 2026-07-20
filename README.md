# FlashLearn

FlashLearn la mini project giao duc chu de Flashcard hoc tap, duoc xay dung bang `Laravel`, `Blade Template`, `MySQL` va mo hinh `MVC`.

## Chuc nang chinh

- Dang ky, dang nhap, dang xuat bang session auth.
- CRUD bo flashcard va CRUD flashcard trong tung bo.
- Phien hoc flashcard voi thao tac lat the, danh dau da nho/chua nho.
- Quiz nhanh tu bo the va luu ket qua.
- Dashboard hoc vien va trang tien do hoc tap.
- Khu vuc quan tri de quan ly danh muc va bo the cong khai.

## Database

He thong su dung cac bang chinh:

- `users`
- `categories`
- `flashcard_sets`
- `flashcards`
- `study_sessions`
- `session_results`
- `quiz_results`

## Docker Setup

### 1. Tao file moi truong

```bash
copy .env.example .env
```

### 2. Build va khoi dong container

```bash
docker compose up -d --build
```

### 3. Cai dependency trong container app

```bash
docker compose exec app composer install
```

### 4. Tao khoa ung dung va migrate

```bash
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

### 5. Phan quyen cho storage neu can

```bash
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
```

### 6. Truy cap he thong

- App: `http://localhost:8000`
- phpMyAdmin: `http://localhost:8080`

## Tai khoan demo

- Admin: `admin@flashlearn.test` / `password`
- Hoc vien: `student@flashlearn.test` / `password`

## Cau truc chinh

- `app/Http/Controllers`: Controller xu ly nghiep vu
- `app/Models`: Model va relationship Eloquent
- `resources/views`: Blade view
- `database/migrations`: Migration tao bang
- `database/seeders`: Seed du lieu mau
- `docker-compose.yml`, `Dockerfile`: cau hinh Docker

## Ghi chu

- Trong moi truong hien tai, Docker registry dang co luc loi mang khi pull image, vi vay project da duoc scaffold san va cau hinh Docker da hoan tat. Chi can moi truong pull image on dinh la co the chay theo cac lenh tren.
