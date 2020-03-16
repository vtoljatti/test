<?php

namespace App\Http\Controllers;

use App\District;
use App\Http\Resources\DistrictResource;
use Illuminate\Http\Request;

class DistrictsController extends Controller
{
     /**
     * Получаем районы
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json([
            'districts' => DistrictResource::collection(District::all()),
        ]);
    }

    /**
     * Получаем район по id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function district(Request $request)
    {
        return response()->json([
            'district' => new DistrictResource(District::where('id', $request->id)->first()),
        ]);
    }

    /**
     * Сохраняем новый район
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

        $district = new District();
        $district->name = $request['name'];
        $district->city_id = $request['city_id'];
        $district->is_hidden = $request['is_hidden'] ?? 0;
        $district->save();

        return response()->json([
            'success' => true,
            'message' => 'Район успешно добавлен',
            'data' => new DistrictResource($district),
        ]);
    }

    /**
     * Изменяем район
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

        $district = District::find($request['id']);
        $district->name = $request['name'];
        $district->city_id = $request['city_id'];
        $district->is_hidden = $request['is_hidden'] ?? 0;
        $district->save();

        return response()->json([
            'success' => true,
            'message' => 'Район изменен',
            'data' => new DistrictResource($district),
        ]);
    }

}
