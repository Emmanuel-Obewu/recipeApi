<?php

namespace App\Http\Controllers\v1;
use App\Models\Recipe;
use Illuminate\Http\Request;
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
    public function update(Request $request, Recipe $recipe)
    {
        if ($recipe->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'You are not authorized to update this recipe.',
            ], 403);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'ingredients' => 'sometimes|required|string',
            'instructions' => 'sometimes|required|string',
            'prep_time' => 'sometimes|required|integer',
            'difficulty' => 'sometimes|required|string',
        ]);

        $recipe->update($request->only(['title', 'ingredients', 'instructions', 'prep_time', 'difficulty']));

        return response()->json([
            'message' => 'Recipe updated successfully!',
            'recipe' => $recipe,
        ], 200);
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
