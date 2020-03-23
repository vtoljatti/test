<?php

namespace App\Http\Controllers;

use App\Act;
use App\Http\Resources\ActResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ActsController extends Controller
{
     /**
     * Получаем акты
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json([
            'acts' => ActResource::collection(Act::all()),
        ]);
    }

    /**
     * Получаем акт по id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function act(Request $request)
    {
        return response()->json([
            'act' => new ActResource(Act::where('id', $request->id)->first()),
        ]);
    }

    /**
     * Получаем акт по id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function actsDay(Request $request)
    {
        return response()->json([
            'success' => true,
            'acts' => ActResource::collection(Act::where('date', $request->date)->where('act_city_id', Auth::user()->city_id)->get()),
        ]);
    }

    /**
     * Сохраняем новый акт
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'time' => 'required',
            'number_sales_1' => 'required|int',
            'number_sales_2' => 'nullable|int',
            'number_sales_3' => 'nullable|int',
            'city' => 'required|string',
            'city_id' => 'nullable|int',
            'district_id' => 'nullable|int',
            'cost' => 'required|int',
            'is_to_bring' => 'boolean',
            'is_exchange' => 'boolean',
            'street' => 'required|string',
            'home' => 'nullable|string',
            'apartment' => 'nullable|string',
            'porch' => 'nullable|string',
            'last_name' => 'nullable|string',
            'phone_1' => 'nullable|string',
            'phone_2' => 'nullable|string',
            'phone_3' => 'nullable|string',
            'is_dialing' => 'boolean',
            'time_dialing' => 'nullable|int',
            'is_lift_up' => 'boolean',
            'is_questionable' => 'boolean',
            'is_elevator' => 'boolean',
            'comment' => 'nullable|string',
            'floor' => 'nullable|int',
            'seller_id' => 'required|int',
            'is_hidden' => 'boolean',
        ]);

        $act = new Act();
        $act->date = $request['date'];
        $act->time = $request['time'];
        $act->number_sales_1 = $request['number_sales_1'];
        $act->number_sales_2 = $request['number_sales_2'] ?? 0;
        $act->number_sales_3 = $request['number_sales_3'] ?? 0;
        $act->city = $request['city'];
        $act->city_id = $request['city_id'] ?? 0;
        $act->district_id = $request['district_id'] ?? 0;
        $act->cost = $request['cost'];
        $act->is_to_bring = $request['is_to_bring'] ?? false;
        $act->is_exchange = $request['is_exchange'] ?? false;
        $act->street = $request['street'];
        $act->home = $request['home'];
        $act->apartment = $request['apartment'];
        $act->porch = $request['porch'];
        $act->last_name = $request['last_name'];
        $act->phone_1 = $request['phone_1'];
        $act->phone_2 = $request['phone_2'];
        $act->phone_3 = $request['phone_3'];
        $act->is_dialing = $request['is_dialing'] ?? false;
        $act->time_dialing = $request['time_dialing'];
        $act->is_lift_up = $request['is_lift_up'] ?? false;
        $act->is_questionable = $request['is_questionable'] ?? false;
        $act->is_elevator = $request['is_elevator'] ?? false;
        $act->comment = $request['comment'];
        $act->floor = $request['floor'];
        $act->seller_id = $request['seller_id'];
        $act->driver_id = $request['driver_id'] ?? 0;
        $act->user_id = Auth::user()->id;
        $act->is_hidden = $request['is_hidden'] ?? false;
        $act->act_city_id = Auth::user()->city_id;
        $act->save();

        if ($request['seller_id'] !== Auth::user()->seller_id) {
            $user = User::find(Auth::user()->id);
            $user->seller_id = $request['seller_id'];
            $user->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Акт успешно добавлен',
            'data' => new ActResource($act),
        ]);
    }

    /**
     * Изменяем акт
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'time' => 'required',
            'number_sales_1' => 'required|int',
            'number_sales_2' => 'nullable|int',
            'number_sales_3' => 'nullable|int',
            'city' => 'required|string',
            'city_id' => 'nullable|int',
            'district_id' => 'nullable|int',
            'cost' => 'required|int',
            'is_to_bring' => 'boolean',
            'is_exchange' => 'boolean',
            'street' => 'required|string',
            'home' => 'nullable|string',
            'apartment' => 'nullable|string',
            'porch' => 'nullable|string',
            'last_name' => 'nullable|string',
            'phone_1' => 'nullable|string',
            'phone_2' => 'nullable|string',
            'phone_3' => 'nullable|string',
            'is_dialing' => 'boolean',
            'time_dialing' => 'nullable|int',
            'is_lift_up' => 'boolean',
            'is_questionable' => 'boolean',
            'is_elevator' => 'boolean',
            'comment' => 'nullable|string',
            'floor' => 'nullable|int',
            'seller_id' => 'required|int',
        ]);

        $act = Act::find($request['id']);
        $act->date = $request['date'];
        $act->time = $request['time'];
        $act->number_sales_1 = $request['number_sales_1'];
        $act->number_sales_2 = $request['number_sales_2'] ?? 0;
        $act->number_sales_3 = $request['number_sales_3'] ?? 0;
        $act->city = $request['city'];
        $act->city_id = $request['city_id'] ?? 0;
        $act->district_id = $request['city_id'] ? $request['district_id'] : 0;
        $act->cost = $request['cost'];
        $act->is_to_bring = $request['is_to_bring'] ?? false;
        $act->is_exchange = $request['is_exchange'] ?? false;
        $act->home = $request['home'];
        $act->street = $request['street'];
        $act->apartment = $request['apartment'];
        $act->porch = $request['porch'];
        $act->last_name = $request['last_name'];
        $act->phone_1 = $request['phone_1'];
        $act->phone_2 = $request['phone_2'];
        $act->phone_3 = $request['phone_3'];
        $act->is_dialing = $request['is_dialing'] ?? false;
        $act->time_dialing = $request['time_dialing'];
        $act->is_lift_up = $request['is_lift_up'] ?? false;
        $act->is_questionable = $request['is_questionable'] ?? false;
        $act->is_elevator = $request['is_elevator'] ?? false;
        $act->comment = $request['comment'];
        $act->floor = $request['floor'];
        $act->seller_id = $request['seller_id'];
        $act->driver_id = $request['driver_id'] ?? 0;
        $act->user_id = Auth::user()->id;
        $act->is_hidden = $request['is_hidden'] ?? false;
        $act->act_city_id = Auth::user()->city_id;
        $act->save();

        if ($request['seller_id'] !== Auth::user()->seller_id) {
            $user = User::find(Auth::user()->id);
            $user->seller_id = $request['seller_id'];
            $user->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Акт изменен',
            'data' => new ActResource($act),
        ]);
    }

}
