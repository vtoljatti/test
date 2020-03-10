<?php

namespace App\Http\Controllers;

use App\City;
use App\CityDistrict;
use App\CityStreets;
use App\Http\Resources\CityDistrictResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\CityStreetsResource;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    /**
     * иПолучаем все города с районами и улицам
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
     * Получаем один город с районами и улицами
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
     * Получаем районы с улицами конкретного города
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function districtsCity(Request $request)
    {
        return response()->json([
            'districts' => CityDistrictResource::collection(CityDistrict::where('city_id', $request->city_id)->get()),
        ]);
    }

    /**
 * Получаем улицы конкретного города
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function streetsCity(Request $request)
    {
        return response()->json([
            'streets' => CityStreetsResource::collection(CityStreets::where('city_id', $request->city_id)->get()),
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
            'streets' => CityStreetsResource::collection(CityStreets::where('city_id', $request->city_id)->where('district_id', $request->district_id)->get()),
        ]);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {

    }
}
