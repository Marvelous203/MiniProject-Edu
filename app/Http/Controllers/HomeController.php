<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FlashcardSet;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredSets = FlashcardSet::query()
            ->with(['category', 'user'])
            ->withCount('flashcards')
            ->where('visibility', 'public')
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::query()
            ->withCount('flashcardSets')
            ->orderByDesc('flashcard_sets_count')
            ->take(5)
            ->get();

        return view('home.index', [
            'featuredSets' => $featuredSets,
            'categories' => $categories,
        ]);
    }
}
