<?php

namespace App\Http\Controllers;

use App\Http\Resources\SellerResource;
use App\Seller;

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

}
