<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Support\Facades\Auth;

class CartService {
    protected $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function create() {

        $this->validateCreateCart();
        return Cart::create([
            'user_id' => Auth::user()->id
        ]);
    }

    public function addToCart($cartData) {
        $this->validateAddProductToCart($cartData->product_id);
        $cartId = $this->validateCart($cartData->product_id);
        //check if the product is already in the Cart,if exist update the quantity, else add to cart.
        $cartItem = CartItem::where(['cart_id' => $cartId , 'product_id' => $cartData->product_id])->first();
        if ($cartItem) {
            $cartItem->quantity += $cartData->quantity;
            $cartItem->update(['quantity' => $cartItem->quantity]);
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cartId,
                'product_id' => $cartData->product_id,
                'quantity' => $cartData->quantity
            ]);
        }
        return [
            'product_id' => intval($cartItem->product_id),
            'quantity' => intval($cartItem->quantity)
        ];
    }

    public function getCart() {
        $cartId = $this->validateCart();
        $cart = CartItem::where('cart_id', $cartId)->with(['product', 'product.store'])->get();
        $total = (float) 0.0;
        $cartPriceSubTotal = (float) 0.0;
        $items = [];
        foreach($cart as $cartItem){
            $items[] = $this->formateCartResponse($cartItem->product, $cartItem->quantity);
            if($cartItem->product->store->is_vat_included == true){
                $total += ($cartItem->product->price * $cartItem->quantity) + ($cartItem->product->store->shipping_cost);
            }else{
                $total += ($cartItem->product->price * $cartItem->quantity) + ($cartItem->product->price * ($cartItem->product->store->vat_percentage/100))+ ($cartItem->product->store->shipping_cost);
            }
            $cartPriceSubTotal += $cartItem->product->price * $cartItem->quantity;
        }
        return [
            'items'     => $items,
            'total'     => $total,
            'subTotal'  => $cartPriceSubTotal
        ];
    }

    private function formateCartResponse($product, $qty)
    {
        return [
            "id"             => $product->id,
            "name_ar"        => $product->name_ar,
            "name_en"        => $product->name_en,
            "description_ar" => $product->description_ar,
            "description_en" => $product->description_en,
            "price"          => $product->price,
            "quantity"       => $qty,
            "store_name"     => $product->store->name,
            "vat_setting"    => $product->store->is_vat_included ? 'Included' : 'Excluded',
            "vat_value"      => $product->store->is_vat_included ? (float)0.0.'%' : $product->store->vat_percentage.'%',
        ];
    }

    /**
     * validateAddProductToCart function
     * check if product exist
     *
     * @param $productId
     * @throw Exception
    */
    private function validateAddProductToCart($productId)
    {
        if($this->productService->getProduct($productId) == null){
            throw new \Exception("Product Not Found", 404);
        }
    }

    /**
     * validateCreateCart function
     * check if auth user only have on cart
     *
     * @throw Exception
    */
    private function validateCreateCart()
    {
        if(!(User::doesntHave('cart')->find(Auth::id()))){
            throw new \Exception("You Can not have more than one cart", 403);
        }
    }

    private function validateCart()
    {
        $cartId = Cart::where('user_id', Auth::user()->id)->pluck('id')->first();
        if($cartId == null){
            throw new \Exception("Cart Not Found", 404);
        }
        return $cartId;
    }
}
