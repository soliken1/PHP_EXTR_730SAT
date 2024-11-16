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
}
