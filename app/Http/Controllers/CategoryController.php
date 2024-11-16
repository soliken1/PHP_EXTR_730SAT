<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
}
