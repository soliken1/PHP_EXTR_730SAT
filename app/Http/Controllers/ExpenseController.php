<?php

namespace App\Http\Controllers;

use App\Models\Expense; // Import the Expense model
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    // Fetch all expenses from MongoDB
    public function index()
    {
        // Fetch all expenses from MongoDB
        $expenses = Expense::all();

        // Return the expenses as a JSON response
        return response()->json($expenses);
    }

    // Fetch a single expense by ID
    public function show($id)
    {
        // Find the expense by ID
        $expense = Expense::find($id);

        // If the expense is found, return it, otherwise return a 404
        if ($expense) {
            return response()->json($expense);
        } else {
            return response()->json(['message' => 'Expense not found'], 404);
        }
    }
}
