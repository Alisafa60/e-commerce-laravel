<?php
namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the user's cart items
        $cartItems = $user->cartItems;

        return response()->json(['cartItems' => $cartItems]);
    }

    public function addProduct(Request $request)
    {
        // Validate the request data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the product
        $product = Product::find($request->input('product_id'));

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Add the product to the user's cart
        $cartItem = CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $request->input('quantity'),
        ]);

        return response()->json(['cartItem' => $cartItem, 'message' => 'Product added to cart successfully'], 201);
    }

    public function removeProduct($productId)
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Find and delete the cart item for the given product and user
        $cartItem = CartItem::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['message' => 'Product removed from cart successfully']);
        } else {
            return response()->json(['message' => 'Product not found in the cart'], 404);
        }
    }
}