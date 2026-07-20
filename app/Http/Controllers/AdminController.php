<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FlashcardSet;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $stats = [
            'user_count' => User::query()->count(),
            'student_count' => User::query()->where('role', 'student')->count(),
            'admin_count' => User::query()->where('role', 'admin')->count(),
            'public_set_count' => FlashcardSet::query()->where('visibility', 'public')->count(),
        ];

        return view('admin.index', [
            'stats' => $stats,
            'categories' => Category::query()->withCount('flashcardSets')->orderBy('name')->get(),
            'publicSets' => FlashcardSet::query()
                ->with(['category', 'user'])
                ->withCount('flashcards')
                ->latest()
                ->take(10)
                ->get(),
        ]);
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Category::create($validated);

        return redirect()->route('admin.index')->with('success', 'Đã thêm danh mục mới.');
    }

    public function destroyCategory(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.index')->with('success', 'Đã xóa danh mục.');
    }

    public function toggleSetVisibility(FlashcardSet $flashcardSet): RedirectResponse
    {
        $flashcardSet->update([
            'visibility' => $flashcardSet->visibility === 'public' ? 'private' : 'public',
        ]);

        return redirect()->route('admin.index')->with('success', 'Đã cập nhật trạng thái bộ thẻ.');
    }
}
