<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\CartService;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\CreateCartRequest;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService) {
        $this->cartService = $cartService;
    }

    public function store(CreateCartRequest $request)
    {
        try {
            $cart = $this->cartService->create($request);
            return $this->handleResponse($cart, 'A new cart have been created for you!');
        } catch (Exception $ex) {
            return $this->handleError($ex->getMessage() ,null ,$ex->getCode());
        }
    }

    public function addToCart(AddToCartRequest $request) {
        try {
            $result = $this->cartService->addToCart($request);
            return $this->handleResponse( $result, 'Added to cart');
        } catch (Exception $ex) {
            return $this->handleError($ex->getMessage() ,null ,$ex->getCode());
        }

    }

    public function index() {
        $cart = $this->cartService->getCart();
        return $this->handleResponse($cart);
    }
}
