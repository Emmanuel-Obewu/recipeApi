<?php

namespace App\Http\Controllers\API\v1;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipe::all();

        $data = [
            'success' => true,
            'data' => $recipes
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedInput = $request->validate([
            'title' => 'required|string|max:295',
            // 'description' => 'required|string',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
            'prep_time' => 'required|string',
            'difficulty' => 'required|string',
        ]);

        $recipe = Recipe::create([
            'title' => $validatedInput['title'],
            // 'description' => $validatedInput['description'],
            'ingredients' => $validatedInput['ingredients'],
            'instructions' => $validatedInput['instructions'],
            'prep_time' => $validatedInput['prep_time'],
            'difficulty' => $validatedInput['difficulty'],
            'user_id' => Auth::id(),
        ]);

        return  response()->json([
            'success' => true,
            'data' => $recipe
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $recipe = Recipe::findOrFail($id);

        return response()->json([
            'success' => true,
             'data' => $recipe
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);


        // if ($recipe->user_id !== Auth::id()) {
        //     return response()->json(['message' => 'Unauthorized'], 403);
        // }

        $recipe->delete();

        return response()->json([
            'success' => true,
            'message' => 'Recipe deleted successfully'
        ], 200);
    }
}
