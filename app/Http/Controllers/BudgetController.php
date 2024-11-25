<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;

class BudgetController extends Controller
{
    public function getBudget()
    {
        $expense = Budget::all();
        return response()->json($expense);
    }

    public function getUserBudget(Request $request) {
        $validated = $request->validate([
            'userId' => 'required|string'
        ]);
    
        $budget = Budget::where('userId', $validated['userId'])->get();
    
        return response()->json($budget);
    }

    public function addBudget(Request $request) {
        $validated = $request->validate([
            'userId' => 'required|string',
            'categoryTitle' => 'required|string|max:255|min:3',
            'budget' => 'required|numeric|min:0',
        ]);

        $existingBudget = Budget::where('categoryTitle', $validated['categoryTitle'])
                                ->where('userId', $validated['userId'])
                                ->first();

        if ($existingBudget) {
            return response()->json([
                'message' => 'Budget already exists.',
            ], 409);
        }

        $validated['budget'] = $validated['budget'] ?? 0.00;

        $budget = Budget::create($validated);
    
        return response()->json([
            'message' => 'Budget added successfully',
            'expense' => $budget,
        ], 201);
    }

    public function updateUserBudget(Request $request, $categoryTitle) {
        $validated = $request->validate([
            'userId' => 'required|string',
            'budget' => 'sometimes|numeric|min:0',
        ]);

        $categoryTitle = trim($categoryTitle);

        $budget = Budget::where('categoryTitle', $categoryTitle)
            ->where('userId', $validated['userId'])
            ->first();

        if (!$budget) {
            return response()->json(['message' => 'Budget not Found.'], 404);
        }

        if (!empty($validated['categoryTitle']) && $validated['categoryTitle'] !== $categoryTitle) {
            $duplicate = Budget::where('categoryTitle', $validated['categoryTitle'])
                                ->where('userId', $validated['userId'])
                                ->exists();

            if ($duplicate) {
                return response()->json(['message' => 'Budget For This Category Already Exists.'], 409);
            }
        }

        $budget->fill($validated);
        $budget->save();

        return response()->json([
            'message' => 'Budget updated successfully',
            'budget' => $budget,
        ], 200);
    }

    public function deleteUserBudget(Request $request, $categoryTitle) {
        $validated = $request->validate([
            'userId' => 'required|string',
        ]);
    
        $categoryTitle = trim($categoryTitle);
    
        $budget = Budget::where('categoryTitle', $categoryTitle)
                          ->where('userId', $validated['userId'])
                          ->first();
    
        if (!$budget) {
            return response()->json(['message' => 'Budget not Found.'], 404);
        }
    
        $budget->delete();
    
        return response()->json(['message' => 'Budget deleted successfully.'], 200);
    }    
}
