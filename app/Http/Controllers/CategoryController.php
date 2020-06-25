<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categorie = Category::create([
            'name' => $request['name'],

        ]);
        return response()->json(['message' => 'la categoria ha sido creado'], 200);
    }
}