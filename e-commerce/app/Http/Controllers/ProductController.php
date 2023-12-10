<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user || !$user->isSeller()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'img_url' => 'required|string',
        ]);

        $product = Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'img_url' => $request->input('img_url'),
            'seller_id' => $user->id,
        ]);

        return response()->json(['product' => $product, 'message' => 'Product added successfully'], 201);
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $product = Product::find($id);

        // Check if the user is a seller and is the owner of the product
        if (!$user || !$user->isSeller() || !$product || $product->seller_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Delete the product
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}