<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FlashcardSet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FlashcardSetController extends Controller
{
    public function index(Request $request): View
    {
        $flashcardSets = $request->user()->flashcardSets()
            ->with('category')
            ->withCount('flashcards')
            ->latest()
            ->paginate(9);

        return view('flashcard_sets.index', [
            'flashcardSets' => $flashcardSets,
        ]);
    }

    public function create(): View
    {
        return view('flashcard_sets.form', [
            'flashcardSet' => new FlashcardSet(),
            'categories' => Category::query()->orderBy('name')->get(),
            'formAction' => route('flashcard-sets.store'),
            'formMethod' => 'POST',
            'pageTitle' => 'Tạo bộ flashcard',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateFlashcardSet($request);

        $flashcardSet = $request->user()->flashcardSets()->create($validated);

        return redirect()
            ->route('flashcard-sets.show', $flashcardSet)
            ->with('success', 'Đã tạo bộ flashcard mới.');
    }

    public function show(Request $request, FlashcardSet $flashcardSet): View
    {
        $this->ensureOwner($request, $flashcardSet);

        $flashcardSet->load(['category', 'flashcards', 'studySessions', 'quizResults']);

        return view('flashcard_sets.show', [
            'flashcardSet' => $flashcardSet,
        ]);
    }

    public function edit(Request $request, FlashcardSet $flashcardSet): View
    {
        $this->ensureOwner($request, $flashcardSet);

        return view('flashcard_sets.form', [
            'flashcardSet' => $flashcardSet,
            'categories' => Category::query()->orderBy('name')->get(),
            'formAction' => route('flashcard-sets.update', $flashcardSet),
            'formMethod' => 'PUT',
            'pageTitle' => 'Cập nhật bộ flashcard',
        ]);
    }

    public function update(Request $request, FlashcardSet $flashcardSet): RedirectResponse
    {
        $this->ensureOwner($request, $flashcardSet);

        $flashcardSet->update($this->validateFlashcardSet($request));

        return redirect()
            ->route('flashcard-sets.show', $flashcardSet)
            ->with('success', 'Đã cập nhật bộ flashcard.');
    }

    public function destroy(Request $request, FlashcardSet $flashcardSet): RedirectResponse
    {
        $this->ensureOwner($request, $flashcardSet);

        $flashcardSet->delete();

        return redirect()->route('flashcard-sets.index')->with('success', 'Đã xóa bộ flashcard.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateFlashcardSet(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'visibility' => ['required', 'in:private,public'],
            'difficulty_level' => ['required', 'in:easy,medium,hard'],
        ]);
    }

    private function ensureOwner(Request $request, FlashcardSet $flashcardSet): void
    {
        abort_if($flashcardSet->user_id !== $request->user()->id, 403);
    }
}
