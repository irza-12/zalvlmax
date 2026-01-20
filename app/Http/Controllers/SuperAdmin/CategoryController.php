<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('quizzes')
            ->orderBy('order')
            ->paginate(15);

        return view('superadmin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = Category::max('order') + 1;

        $category = Category::create($validated);

        ActivityLog::log(ActivityLog::ACTION_CREATE, "Membuat kategori: {$category->name}", $category);

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        $category->update($validated);

        ActivityLog::log(ActivityLog::ACTION_UPDATE, "Mengupdate kategori: {$category->name}", $category);

        return back()->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy(Category $category)
    {
        $name = $category->name;
        $category->delete();

        ActivityLog::log(ActivityLog::ACTION_DELETE, "Menghapus kategori: {$name}");

        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}
