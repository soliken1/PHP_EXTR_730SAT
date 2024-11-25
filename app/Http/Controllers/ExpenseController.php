<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function getExpenses()
    {
        $expense = Expense::all();
        return response()->json($expense);
    }

    public function getUserExpenses(Request $request) {
        $validated = $request->validate([
            'userId' => 'required|string'
        ]);
    
        $expenses = Expense::where('userId', $validated['userId'])->get();
    
        return response()->json($expenses);
    }

    public function addUserExpense(Request $request) {
        $validated = $request->validate([
            'expenseName' => 'required|string|max:255',
            'expenseDescription' => 'required|string|max:255',
            'categoryTitle' => 'required|string|max:255|nullable',
            'userId' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $existingExpense = Expense::where('expenseName', $validated['expenseName'])
                                    ->where('userId', $validated['userId'])
                                    ->first();

        if ($existingExpense) {
            return response()->json([
                'message' => 'Expense already exists.',
            ], 409);
        }

        $validated['amount'] = $validated['amount'] ?? 0.00;
        if (empty($validated['categoryTitle'])) {
            $validated['categoryTitle'] = 'No Category';
        }
        $expense = Expense::create($validated);
    
        return response()->json([
            'message' => 'Expense added successfully',
            'expense' => $expense,
        ], 201);
    }

    public function updateUserExpense(Request $request, $expenseName) {
        $validated = $request->validate([
            'userId' => 'required|string',
            'expenseName' => 'sometimes|string|max:255',
            'expenseDescription' => 'sometimes|string|max:255',
            'categoryTitle' => 'sometimes|string|max:255|min:3',
            'amount' => 'sometimes|numeric|min:0',
            'date' => 'sometimes|date_format:Y-m-d H:i:s',
        ]);
    
        $expenseName = trim($expenseName);
    
        $expense = Expense::where('expenseName', $expenseName)
                            ->where('userId', $validated['userId'])
                            ->first();
    
        if (!$expense) {
            return response()->json(['message' => 'Expense not Found.'], 404);
        }

        if (!empty($validated['expenseName']) && $validated['expenseName'] !== $expenseName) {
            $duplicate = Expense::where('expenseName', $validated['expenseName'])
                                ->where('userId', $validated['userId'])
                                ->exists();

            if ($duplicate) {
                return response()->json(['message' => 'Expense Name Already Exists.'], 409);
            }
        }
    
        $expense->fill($validated);
        $expense->save();
    
        return response()->json([
            'message' => 'Expense updated successfully.',
            'expense' => $expense,
        ], 200);
    }

    public function deleteUserExpense(Request $request, $expenseName) {
        $validated = $request->validate([
            'userId' => 'required|string',
        ]);
    
        $expenseName = trim($expenseName);
    
        $expense = Expense::where('expenseName', $expenseName)
                          ->where('userId', $validated['userId'])
                          ->first();
    
        if (!$expense) {
            return response()->json(['message' => 'Expense not Found.'], 404);
        }
    
        $expense->delete();
    
        return response()->json(['message' => 'Expense deleted successfully.'], 200);
    }    
}