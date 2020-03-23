<?php

namespace App\Http\Controllers;

use App\City;
use App\District;
use App\Http\Resources\SellerResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\VillagesResource;
use App\Seller;
use App\Streets;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\StreetsResource;
use App\User;
use App\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitiesController extends Controller
{
    /**
     * иПолучаем все города
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'cities' => CityResource::collection(City::all()),
        ]);
    }

    /**
     * Получаем город по id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function city(Request $request)
    {
        return response()->json([
            'city' => new CityResource(City::where('id', $request->id)->first()),
        ]);
    }

    /**
     * Сохраняем нового города
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:1|max:255',
            'is_hidden' => 'boolean',
        ]);

        $city = new City();
        $city->name = $request['name'];
        $city->is_hidden = $request['is_hidden'] ?? 0;
        $city->save();

        return response()->json([
            'success' => true,
            'message' => 'Город успешно добавлен',
            'data' => new CityResource($city),
        ]);
    }

    /**
     * Изменяем город
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:1|max:255',
            'is_hidden' => 'boolean',
        ]);

        $city = City::find($request['id']);
        $city->name = $request['name'];
        $city->is_hidden = $request['is_hidden'] ?? 0;
        $city->save();

        return response()->json([
            'success' => true,
            'message' => 'Город изменен',
            'data' => new CityResource($city),
        ]);
    }

    /**
     * Получаем районы города
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function districtsCity(Request $request)
    {
        return response()->json([
            'districts' => DistrictResource::collection(District::where('city_id', $request->id)->get()),
        ]);
    }

    /**
     * Получаем продавцов города
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sellersCity(Request $request)
    {
        return response()->json([
            'sellers' => SellerResource::collection(Seller::where('city_id', $request->id)->get()),
        ]);
    }

    /**
     * Получаем улицы
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function streetsCity(Request $request)
    {
        return response()->json([
            'streets' => StreetsResource::collection(Streets::where('city_id', $request->id)->get()),
        ]);
    }

    /**
     * Получаем районы конкретного города
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function districtCity(Request $request)
    {
        return response()->json([
            'districts' => DistrictResource::collection(District::where('city_id', $request->id)->get()),
        ]);
    }

    /**
     * Получаем улицы конкретного города и района
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function streetsDistrictCity(Request $request)
    {
        return response()->json([
            'streets' => StreetsResource::collection(Streets::where('city_id', $request->id)->where('district_id', $request->district_id)->get()),
        ]);
    }

    /**
     * Получаем населенные пункты конкретного города и района
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function villagesCity(Request $request)
    {
        return response()->json([
            'villages' => VillagesResource::collection(Village::where('city_id', $request->id)->get()),
        ]);
    }

}
