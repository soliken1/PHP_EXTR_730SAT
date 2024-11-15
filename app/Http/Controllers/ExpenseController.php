<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function getExpenses()
    {
        $users = DB::connection('mongodb')->table('expenses')->get();
        return response()->json($users);
    }
}
