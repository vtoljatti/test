<?php

namespace App\Http\Controllers;

use App\City;
use App\District;
use App\Streets;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\StreetsResource;
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
     * Получаем один город
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        return response()->json([
            'city' => new CityResource(City::where('id', $request->city_id)->first()),
        ]);
    }

    /**
     * Получаем районы
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function districtsCity(Request $request)
    {
        return response()->json([
            'districts' => DistrictResource::collection(District::where('city_id', $request->city_id)->get()),
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
            'streets' => StreetsResource::collection(Streets::where('city_id', $request->city_id)->get()),
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
            'streets' => StreetsResource::collection(Streets::where('city_id', $request->city_id)->where('district_id', $request->district_id)->get()),
        ]);
    }

}
