<?php

namespace App\Http\Controllers;

use App\Http\Resources\VillagesResource;
use App\Village;

class VillagesController extends Controller
{
    /**
     * Получаем все населенные пункты
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'villages' => VillagesResource::collection(Village::all()),
        ]);
    }

}
