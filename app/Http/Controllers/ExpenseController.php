<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
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
    
}
