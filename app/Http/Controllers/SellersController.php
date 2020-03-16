<?php

namespace App\Http\Controllers;

use App\Http\Resources\SellerResource;
use App\Http\Resources\UserResource;
use App\Seller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SellersController extends Controller
{
    /**
     * Получаем все населенные пункты
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'sellers' => SellerResource::collection(Seller::all()),
        ]);
    }

    /**
     * Получаем продавца по id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function seller(Request $request)
    {
        return response()->json([
            'seller' => new SellerResource(Seller::where('id', $request->id)->first()),
        ]);
    }

    /**
     * Сохраняем нового продавца
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:1|max:255',
            'city_id' => 'required|int',
            'is_hidden' => 'boolean',
        ]);

        $seller = new Seller();
        $seller->name = $request['name'];
        $seller->city_id = $request['city_id'];
        $seller->is_hidden = $request['is_hidden'] ?? 0;
        $seller->save();

        return response()->json([
            'success' => true,
            'message' => 'Продавец успешно добавлен',
            'data' => new SellerResource($seller),
        ]);
    }

    /**
     * Изменяем продавца
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:1|max:255',
            'city_id' => 'required|int',
            'is_hidden' => 'boolean',
        ]);

        $seller = Seller::find($request['id']);
        $seller->name = $request['name'];
        $seller->city_id = $request['city_id'];
        $seller->is_hidden = $request['is_hidden'] ?? 0;
        $seller->save();

        return response()->json([
            'success' => true,
            'message' => 'Продавец изменен',
            'data' => new SellerResource($seller),
        ]);
    }

}
