<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $flashcardSets = $user->flashcardSets()
            ->with('category')
            ->withCount('flashcards')
            ->latest()
            ->take(5)
            ->get();

        $recentSessions = $user->studySessions()
            ->with('flashcardSet')
            ->latest()
            ->take(5)
            ->get();

        $recentQuizResults = $user->quizResults()
            ->with('flashcardSet')
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'set_count' => $user->flashcardSets()->count(),
            'card_count' => $user->flashcardSets()->withCount('flashcards')->get()->sum('flashcards_count'),
            'session_count' => $user->studySessions()->count(),
            'quiz_count' => $user->quizResults()->count(),
        ];

        return view('dashboard.index', [
            'stats' => $stats,
            'flashcardSets' => $flashcardSets,
            'recentSessions' => $recentSessions,
            'recentQuizResults' => $recentQuizResults,
        ]);
    }
}
