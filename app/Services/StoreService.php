<?php

namespace App\Services;

use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;


class StoreService {

    public function create($request)
    {
        $this->validateCreateStore();
        $storeData = [];
        $storeData['name'] = $request->name;
        $storeData['user_id'] = Auth::user()->id;
        $storeData['is_vat_included'] = isset($request['is_vat_included']) ? intval($request['is_vat_included']) : 1;
        $storeData['vat_percentage'] = isset($request['vat_percentage']) ? intval($request['vat_percentage'])  : 0;
        $storeData['shipping_cost'] = isset($request['shipping_cost']) ? intval($request['shipping_cost']) : 0;
        return Store::create($storeData);
    }

    public function update($request, $id)
    {
        $store = Store::find($id);
        $this->validateUpdateStore($store);
        $store->name = $request->name;
        $store->is_vat_included = $request->is_vat_included;
        $store->vat_percentage = $request->vat_percentage;
        $store->shipping_cost = $request->shipping_cost;
        $store->save();
        return $store;
    }

    public function getStore()
    {
       return Store::where('user_id', Auth::id())->with('user')->get();
    }

    /**
     * validateUpdateStore function
     * check if store exist and belongs to auth user
     *
     * @param $store
     * @throw Exception
    */
    private function validateUpdateStore($store)
    {
        if( $store === null || $store->user_id !== Auth::user()->id){
            throw new \Exception("Store Not Found", 404);
        }
    }

    /**
     * validateCreateStore function
     * check if auth user only have on store
     *
     * @throw Exception
    */
    private function validateCreateStore()
    {
        if(!(User::doesntHave('store')->find(Auth::id()))){
            throw new \Exception("You Can not have more than one store", 403);
        }
    }
}
