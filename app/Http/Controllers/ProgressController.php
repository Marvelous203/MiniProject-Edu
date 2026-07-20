<?php

namespace App\Http\Controllers;

use App\Models\FlashcardSet;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgressController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $setProgress = FlashcardSet::query()
            ->where('user_id', $user->id)
            ->withCount('flashcards')
            ->withSum('studySessions', 'remembered_cards')
            ->withCount('studySessions')
            ->withCount('quizResults')
            ->latest()
            ->get();

        $recentSessions = $user->studySessions()
            ->with('flashcardSet')
            ->latest()
            ->take(10)
            ->get();

        $recentQuizResults = $user->quizResults()
            ->with('flashcardSet')
            ->latest()
            ->take(10)
            ->get();

        return view('progress.index', [
            'setProgress' => $setProgress,
            'recentSessions' => $recentSessions,
            'recentQuizResults' => $recentQuizResults,
        ]);
    }
}
