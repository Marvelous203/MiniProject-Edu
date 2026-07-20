<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use App\Models\FlashcardSet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FlashcardController extends Controller
{
    public function store(Request $request, FlashcardSet $flashcardSet): RedirectResponse
    {
        $this->ensureOwner($request, $flashcardSet);

        $flashcardSet->flashcards()->create($this->validateFlashcard($request));

        return redirect()
            ->route('flashcard-sets.show', $flashcardSet)
            ->with('success', 'Đã thêm thẻ học mới.');
    }

    public function update(Request $request, FlashcardSet $flashcardSet, Flashcard $flashcard): RedirectResponse
    {
        $this->ensureOwner($request, $flashcardSet, $flashcard);

        $flashcard->update($this->validateFlashcard($request));

        return redirect()
            ->route('flashcard-sets.show', $flashcardSet)
            ->with('success', 'Đã cập nhật flashcard.');
    }

    public function destroy(Request $request, FlashcardSet $flashcardSet, Flashcard $flashcard): RedirectResponse
    {
        $this->ensureOwner($request, $flashcardSet, $flashcard);

        $flashcard->delete();

        return redirect()
            ->route('flashcard-sets.show', $flashcardSet)
            ->with('success', 'Đã xóa flashcard.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateFlashcard(Request $request): array
    {
        return $request->validate([
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
            'note' => ['nullable', 'string'],
        ]);
    }

    private function ensureOwner(Request $request, FlashcardSet $flashcardSet, ?Flashcard $flashcard = null): void
    {
        abort_if($flashcardSet->user_id !== $request->user()->id, 403);
        abort_if($flashcard && $flashcard->flashcard_set_id !== $flashcardSet->id, 404);
    }
}
