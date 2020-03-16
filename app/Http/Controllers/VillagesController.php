<?php

namespace App\Http\Controllers;

use App\Http\Resources\VillagesResource;
use App\Village;
use Illuminate\Http\Request;

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

    /**
     * Получаем по id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function village(Request $request)
    {
        return response()->json([
            'village' => new VillagesResource(Village::where('id', $request->id)->first()),
        ]);
    }

    /**
     * Сохраняем новый
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
            'price' => 'nullable|int',
            'is_hidden' => 'boolean',
        ]);

        $village = new Village();
        $village->name = $request['name'];
        $village->city_id = $request['city_id'];
        $village->price = $request['price'] ?? 0;
        $village->is_hidden = $request['is_hidden'] ?? 0;
        $village->save();

        return response()->json([
            'success' => true,
            'message' => 'Населенный пункт успешно добавлен',
            'data' => new VillagesResource($village),
        ]);
    }

    /**
     * Изменяем
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
            'price' => 'nullable|int',
            'is_hidden' => 'boolean',
        ]);

        $village = Village::find($request['id']);
        $village->name = $request['name'];
        $village->city_id = $request['city_id'];
        $village->price = $request['price'] ?? 0;
        $village->is_hidden = $request['is_hidden'] ?? 0;
        $village->save();

        return response()->json([
            'success' => true,
            'message' => 'Населенный пункт изменен',
            'data' => new VillagesResource($village),
        ]);
    }

}
