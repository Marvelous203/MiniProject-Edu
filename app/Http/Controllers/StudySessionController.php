<?php

namespace App\Http\Controllers;

use App\Models\FlashcardSet;
use App\Models\SessionResult;
use App\Models\StudySession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudySessionController extends Controller
{
    public function start(Request $request, FlashcardSet $flashcardSet): RedirectResponse
    {
        $this->ensureOwner($request, $flashcardSet);

        $flashcardCount = $flashcardSet->flashcards()->count();

        if ($flashcardCount === 0) {
            return redirect()
                ->route('flashcard-sets.show', $flashcardSet)
                ->with('error', 'Bộ thẻ chưa có nội dung để bắt đầu học.');
        }

        $session = $request->user()->studySessions()->create([
            'flashcard_set_id' => $flashcardSet->id,
            'started_at' => now(),
            'total_cards' => $flashcardCount,
            'remembered_cards' => 0,
        ]);

        return redirect()->route('study-sessions.show', $session);
    }

    public function show(Request $request, StudySession $studySession): View
    {
        $this->ensureSessionOwner($request, $studySession);

        $studySession->load([
            'flashcardSet.flashcards',
            'sessionResults.flashcard',
        ]);

        $answeredIds = $studySession->sessionResults->pluck('flashcard_id')->all();

        $nextCard = $studySession->flashcardSet->flashcards
            ->first(fn($card) => ! in_array($card->id, $answeredIds, true));

        $completed = $nextCard === null;

        if ($completed && $studySession->ended_at === null) {
            $studySession->update(['ended_at' => now()]);
            $studySession->refresh();
        }

        return view('study_sessions.show', [
            'studySession' => $studySession,
            'nextCard' => $nextCard,
            'completed' => $completed,
            'answeredCount' => count($answeredIds),
        ]);
    }

    public function answer(Request $request, StudySession $studySession): RedirectResponse
    {
        $this->ensureSessionOwner($request, $studySession);

        $validated = $request->validate([
            'flashcard_id' => ['required', 'exists:flashcards,id'],
            'result' => ['required', 'in:remembered,forgotten'],
        ]);

        abort_unless(
            $studySession->flashcardSet()->firstOrFail()->flashcards()->whereKey($validated['flashcard_id'])->exists(),
            403
        );

        SessionResult::updateOrCreate(
            [
                'study_session_id' => $studySession->id,
                'flashcard_id' => $validated['flashcard_id'],
            ],
            [
                'result' => $validated['result'],
                'reviewed_at' => now(),
            ]
        );

        $rememberedCount = $studySession->sessionResults()->where('result', 'remembered')->count();
        $reviewedCount = $studySession->sessionResults()->count();

        $studySession->update([
            'remembered_cards' => $rememberedCount,
            'ended_at' => $reviewedCount >= $studySession->total_cards ? now() : null,
        ]);

        return redirect()
            ->route('study-sessions.show', $studySession)
            ->with('success', 'Đã lưu phản hồi học tập.');
    }

    private function ensureOwner(Request $request, FlashcardSet $flashcardSet): void
    {
        abort_if($flashcardSet->user_id !== $request->user()->id, 403);
    }

    private function ensureSessionOwner(Request $request, StudySession $studySession): void
    {
        abort_if($studySession->user_id !== $request->user()->id, 403);
    }
}
