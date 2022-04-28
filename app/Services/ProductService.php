<?php

namespace App\Services;

use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class ProductService {

    public function create($product) {
        $storeId = Store::where('user_id', Auth::user()->id)->pluck('id')->first();
        return Product::create([
            'name_ar' => $product->name_ar,
            'name_en' => $product->name_en,
            'description_ar' => $product->description_ar,
            'description_en' => $product->description_en,
            'price' => $product->price,
            'store_id' => $storeId
        ]);
    }

    public function getProducts() {
        return Product::with('store')->paginate();
    }

    public function getProduct($id) {
        return Product::with('store')->find($id);
    }

}
