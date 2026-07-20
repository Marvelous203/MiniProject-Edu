<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use App\Models\FlashcardSet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizController extends Controller
{
    public function show(Request $request, FlashcardSet $flashcardSet): View
    {
        $this->ensureOwner($request, $flashcardSet);

        $quizCards = $flashcardSet->flashcards()->inRandomOrder()->limit(5)->get();

        return view('quiz.show', [
            'flashcardSet' => $flashcardSet,
            'quizCards' => $quizCards,
            'result' => null,
        ]);
    }

    public function submit(Request $request, FlashcardSet $flashcardSet): View|RedirectResponse
    {
        $this->ensureOwner($request, $flashcardSet);

        $validated = $request->validate([
            'card_ids' => ['required', 'array', 'min:1'],
            'card_ids.*' => ['required', 'integer', 'exists:flashcards,id'],
            'answers' => ['required', 'array'],
        ]);

        $quizCards = Flashcard::query()
            ->where('flashcard_set_id', $flashcardSet->id)
            ->whereIn('id', $validated['card_ids'])
            ->get();

        if ($quizCards->isEmpty()) {
            return redirect()
                ->route('quiz.show', $flashcardSet)
                ->with('error', 'Không tìm thấy câu hỏi để chấm điểm.');
        }

        $answers = $validated['answers'];
        $correctCount = 0;

        foreach ($quizCards as $card) {
            $submittedAnswer = trim((string) ($answers[$card->id] ?? ''));

            if (mb_strtolower($submittedAnswer) === mb_strtolower(trim($card->answer))) {
                $correctCount++;
            }
        }

        $request->user()->quizResults()->create([
            'flashcard_set_id' => $flashcardSet->id,
            'total_questions' => $quizCards->count(),
            'correct_answers' => $correctCount,
        ]);

        return view('quiz.show', [
            'flashcardSet' => $flashcardSet,
            'quizCards' => $quizCards,
            'result' => [
                'correct_count' => $correctCount,
                'total_questions' => $quizCards->count(),
                'answers' => $answers,
            ],
        ]);
    }

    private function ensureOwner(Request $request, FlashcardSet $flashcardSet): void
    {
        abort_if($flashcardSet->user_id !== $request->user()->id, 403);
    }
}
