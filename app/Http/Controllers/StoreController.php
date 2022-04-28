<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\StoreService;
use App\Http\Requests\CreateStoreRequest;
use App\Http\Requests\UpdateStoreRequest;

class StoreController extends Controller
{
    protected $storeService;

    public function __construct(StoreService $storeService) {
        $this->storeService = $storeService;
    }

    public function index()
    {
        $store = $this->storeService->getStore();
        return $this->handleResponse($store);
    }

    public function store(CreateStoreRequest $request)
    {
        try {
            $store = $this->storeService->create($request);
            return $this->handleResponse($store, 'Store created successfully');
        } catch (Exception $ex) {
            return $this->handleError($ex->getMessage() ,null ,$ex->getCode());

        }
    }

    public function update(UpdateStoreRequest $request, $id)
    {
        try {
            $store = $this->storeService->update($request, $id);
            return $this->handleResponse($store, 'Store Updated successfully');
        } catch (Exception $ex) {
            return $this->handleError($ex->getMessage() ,null ,$ex->getCode());

        }
    }
}
