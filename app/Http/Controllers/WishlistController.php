<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\User_data;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;


class WishlistController extends Controller
{
    public function getWishlistProducts()
    {
        $wishlist_products = [];

        $user_id = $this->getUser(request());

        $wishlist_items = Wishlist::where("user_id", $user_id)->get();

        foreach ($wishlist_items as $item) {
            $wishlist_item = Products::where("id", $item->product_id)->get()->first();
            $wishlist_products[] = $wishlist_item;
        }

        return response()->json([
            "status" => true,
            "data" => $wishlist_products
        ], 200);

    }

    private function getUser($request): string
    {
        $token = $request->bearerToken();
        $userToken = PersonalAccessToken::findToken($token);
        $user = $userToken->tokenable;
        return $user->id;
    }

    public function storeWishlistProducts(Request $request)
    {
        $user_id = $this->getUser(request());

        Wishlist::create([
            "user_id" => User_data::where('user_id', $user_id)->first()->id,
            "product_id" => $request->product_id
        ]);

        return response()->json([
            "status" => true,
            "message" => "Product added to wishlist"
        ]);
    }

    public function deleteWishlistProducts(Request $request)
    {
        $user_id = $this->getUser(request());

        $wishlist_arr = Wishlist::where('user_id', $user_id)->where('product_id', $request->product_id)->delete();

        return response()->json([
            "status" => true,
            "message" => "Product deleted from wishlist"
        ]);
    }

}
