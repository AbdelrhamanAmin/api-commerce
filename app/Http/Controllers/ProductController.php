<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\ProductService;
use App\Http\Requests\CreateProductRequest;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function index()
    {
        $store = $this->productService->getProducts();
        return $this->handleResponse($store);
    }

    public function store(CreateProductRequest $request)
    {
        try {
            $product = $this->productService->create($request);
            return $this->handleResponse($product, 'Product created successfully');
        } catch (Exception $ex) {
            return $this->handleError($ex->getMessage() ,null ,$ex->getCode());

        }
    }
}
