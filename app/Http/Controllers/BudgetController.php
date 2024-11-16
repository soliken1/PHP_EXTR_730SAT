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
}
