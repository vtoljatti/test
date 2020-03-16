<?php

namespace App\Http\Controllers;

use App\Streets;
use App\Http\Resources\StreetsResource;
use Illuminate\Http\Request;

class StreetsController extends Controller
{
     /**
     * Получаем улицу
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json([
            'streets' => StreetsResource::collection(Streets::all()),
        ]);
    }

    /**
     * Получаем улицу по id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function street(Request $request)
    {
        return response()->json([
            'street' => new StreetsResource(Streets::where('id', $request->id)->first()),
        ]);
    }

    /**
     * Сохраняем новую улицу
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
            'district_id' => 'required|int',
            'is_hidden' => 'boolean',
        ]);

        $street = new Streets();
        $street->name = $request['name'];
        $street->city_id = $request['city_id'];
        $street->district_id = $request['district_id'];
        $street->is_hidden = $request['is_hidden'] ?? 0;
        $street->save();

        return response()->json([
            'success' => true,
            'message' => 'Район успешно добавлен',
            'data' => new StreetsResource($street),
        ]);
    }

    /**
     * Изменяем улицу
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
            'district_id' => 'required|int',
            'is_hidden' => 'boolean',
        ]);

        $street = Streets::find($request['id']);
        $street->name = $request['name'];
        $street->city_id = $request['city_id'];
        $street->district_id = $request['district_id'];
        $street->is_hidden = $request['is_hidden'] ?? 0;
        $street->save();

        return response()->json([
            'success' => true,
            'message' => 'Район изменен',
            'data' => new StreetsResource($street),
        ]);
    }

}
