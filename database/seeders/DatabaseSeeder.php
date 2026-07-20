<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FlashcardSet;
use App\Models\Flashcard;
use App\Models\QuizResult;
use App\Models\StudySession;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@flashlearn.test'],
            [
                'name' => 'Admin FlashLearn',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        $student = User::query()->updateOrCreate(
            ['email' => 'student@flashlearn.test'],
            [
                'name' => 'Student Demo',
                'role' => 'student',
                'password' => Hash::make('password'),
            ]
        );

        $categories = collect([
            ['name' => 'Tu vung tieng Anh', 'description' => 'Hoc tu vung co ban va hoc thuat'],
            ['name' => 'Cong nghe thong tin', 'description' => 'Khai niem lap trinh, mang va co so du lieu'],
            ['name' => 'Lich su', 'description' => 'Moc su kien va nhan vat quan trong'],
        ])->map(fn (array $category) => Category::query()->firstOrCreate(
            ['name' => $category['name']],
            ['description' => $category['description']]
        ));

        $englishSet = FlashcardSet::query()->updateOrCreate(
            ['user_id' => $student->id, 'title' => 'English Core Vocabulary'],
            [
                'category_id' => $categories[0]->id,
                'description' => 'Bo the giup on tap tu vung can ban trong giao tiep va hoc tap.',
                'visibility' => 'public',
                'difficulty_level' => 'easy',
            ]
        );

        $techSet = FlashcardSet::query()->updateOrCreate(
            ['user_id' => $student->id, 'title' => 'Database Fundamentals'],
            [
                'category_id' => $categories[1]->id,
                'description' => 'On tap cac khai niem chinh trong he quan tri co so du lieu.',
                'visibility' => 'private',
                'difficulty_level' => 'medium',
            ]
        );

        $historySet = FlashcardSet::query()->updateOrCreate(
            ['user_id' => $admin->id, 'title' => 'Vietnam History Milestones'],
            [
                'category_id' => $categories[2]->id,
                'description' => 'Bo the cong khai de tham khao cac su kien lich su tieu bieu.',
                'visibility' => 'public',
                'difficulty_level' => 'medium',
            ]
        );

        $this->seedCards($englishSet, [
            ['question' => 'Hello', 'answer' => 'Xin chao', 'note' => 'Dung khi chao hoi thong dung.'],
            ['question' => 'Improve', 'answer' => 'Cai thien', 'note' => 'Dong tu dung de chi su tien bo.'],
            ['question' => 'Schedule', 'answer' => 'Lich trinh', 'note' => 'Thuong dung trong hoc tap va cong viec.'],
        ]);

        $this->seedCards($techSet, [
            ['question' => 'Primary Key la gi?', 'answer' => 'Khoa chinh dinh danh duy nhat moi ban ghi', 'note' => 'Khong duoc trung lap.'],
            ['question' => 'SQL viet tat cua?', 'answer' => 'Structured Query Language', 'note' => 'Ngon ngu truy van co so du lieu.'],
            ['question' => 'Relationship 1-n la gi?', 'answer' => 'Mot ban ghi lien ket nhieu ban ghi o bang khac', 'note' => 'Vi du category va products.'],
        ]);

        $this->seedCards($historySet, [
            ['question' => 'Quoc khanh Viet Nam la ngay nao?', 'answer' => '2/9', 'note' => 'Ngay doc Tuyen ngon Doc lap.'],
            ['question' => 'Tran Bach Dang gan voi danh tuong nao?', 'answer' => 'Ngo Quyen', 'note' => 'Tran danh noi tieng trong lich su dan toc.'],
            ['question' => 'Chien dich Dien Bien Phu ket thuc nam nao?', 'answer' => '1954', 'note' => 'Cot moc quan trong cua khang chien.'],
        ]);

        $studySession = StudySession::query()->updateOrCreate(
            [
                'user_id' => $student->id,
                'flashcard_set_id' => $englishSet->id,
            ],
            [
                'started_at' => now()->subDay(),
                'ended_at' => now()->subDay()->addMinutes(10),
                'total_cards' => $englishSet->flashcards()->count(),
                'remembered_cards' => 2,
            ]
        );

        QuizResult::query()->updateOrCreate(
            [
                'user_id' => $student->id,
                'flashcard_set_id' => $techSet->id,
            ],
            [
                'total_questions' => 3,
                'correct_answers' => 2,
            ]
        );
    }

    /**
     * @param array<int, array<string, string>> $cards
     */
    private function seedCards(FlashcardSet $flashcardSet, array $cards): void
    {
        foreach ($cards as $card) {
            Flashcard::query()->updateOrCreate(
                [
                    'flashcard_set_id' => $flashcardSet->id,
                    'question' => $card['question'],
                ],
                [
                    'answer' => $card['answer'],
                    'note' => $card['note'],
                ]
            );
        }
    }
}
