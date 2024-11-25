<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Budget;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $category = Category::all();
        return response()->json($category);
    }

    public function getUserCategories(Request $request) {
        $validated = $request->validate([
            'userId' => 'required|string'
        ]);
    
        $category = Category::where('userId', $validated['userId'])->get();
    
        return response()->json($category);
    }

    public function addUserCategory(Request $request) {
        $validated = $request->validate([
            'userId' => 'required|string',
            'categoryTitle' => 'required|string|max:255|min:3',
        ]);

        $existingCategory = Category::where('categoryTitle', $validated['categoryTitle'])
                                    ->where('userId', $validated['userId'])
                                    ->first();

        if ($existingCategory) {
            return response()->json([
                'message' => 'Category already exists.',
            ], 409);
        }

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category added successfully',
            'category' => $category,
        ], 201);
    }

    public function updateUserCategory(Request $request, $categoryTitle)
    {
        $validated = $request->validate([
            'userId' => 'required|string',
            'categoryTitle' => 'sometimes|string|max:255|min:3',
        ]);

        $categoryTitle = trim($categoryTitle);

        $category = Category::where('categoryTitle', $categoryTitle)
            ->where('userId', $validated['userId'])
            ->first();

        if (!$category) {
            return response()->json(['message' => 'Category not Found.'], 404);
            
        }

        if (!empty($validated['categoryTitle']) && $validated['categoryTitle'] !== $categoryTitle) {
            $duplicate = Category::where('categoryTitle', $validated['categoryTitle'])
                                ->where('userId', $validated['userId'])
                                ->exists();

            if ($duplicate) {
                return response()->json(['message' => 'Category Title Already Exists.'], 409);
            }
        }

        $category->fill($validated);
        $category->save();

        if (isset($validated['categoryTitle'])) {
            Expense::where('categoryTitle', $categoryTitle)
                ->where('userId', $validated['userId'])
                ->update(['categoryTitle' => $validated['categoryTitle']]);
        }

        if (isset($validated['categoryTitle'])) {
            Budget::where('categoryTitle', $categoryTitle)
                ->where('userId', $validated['userId'])
                ->update(['categoryTitle' => $validated['categoryTitle']]);
        }

        return response()->json([
            'message' => 'Category updated successfully, and associated expenses were updated.',
            'category' => $category,
        ], 200);
    }

    public function deleteUserCategory(Request $request, $categoryTitle)
    {
        $validated = $request->validate([
            'userId' => 'required|string',
        ]);

        $categoryTitle = trim($categoryTitle);

        $category = Category::where('categoryTitle', $categoryTitle)
                            ->where('userId', $validated['userId'])
                            ->first();

        if (!$category) {
            return response()->json(['message' => 'Category not Found.'], 404);
        }

        $category->delete();

        Expense::where('categoryTitle', $categoryTitle)
            ->where('userId', $validated['userId'])
            ->update(['categoryTitle' => 'No Category']);

        Budget::where('categoryTitle', $categoryTitle)
            ->where('userId', $validated['userId'])
            ->update(['categoryTitle' => 'No Category']);

        return response()->json(['message' => 'Category deleted and associated expenses updated successfully.'], 200);
    }
}
