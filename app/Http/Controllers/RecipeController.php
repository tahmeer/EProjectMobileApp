<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'total_time' => 'required',
            'image'=>'required',
            'ingredient_id' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $recipe = new Recipe();
        $recipe->name = $request->name;
        $recipe->description = $request->description;
        $recipe->total_time = $request->total_time;
        $path = 'public\Images\Recipe';
        $image = $request->image->store($path);
        $recipe->image = str_replace('public/','',$image);
        $recipe->ingredient_id = $request->ingredient_id;
        $recipe->user_id = $request->user_id;
        $recipe->save();
        return response()->json(['recipe'=>$recipe],200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'total_time' => 'required',
            'image'=>'required',
            'ingredient_id' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $recipe = Recipe::findOrFail($request->id);
        if(Storage::exists($recipe->image)){
            Storage::delete($recipe->image);
        }

        $recipe->name = $request->name;
        $recipe->description = $request->description;
        $recipe->total_time = $request->total_time;
        $path = 'public\Images\Recipe';
        $image = $request->image->store($path);
        $recipe->image = str_replace('public/','',$image);
        $recipe->ingredient_id = $request->ingredient_id;
        $recipe->user_id = $request->user_id;
        $recipe->save();
        return response()->json(['recipe'=>$recipe],200);
    }
    public function RecipeByIngredient($id){
        $recipebyingredient = Recipe::where('ingredient_id',$id)->get();
        if(count($recipebyingredient) > 0){
        return response()->json(['recipebyingredient'=>$recipebyingredient],200);
        }
        return response()->json(['error'=>'Not Found'],404);
    }
}
