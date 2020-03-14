<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Получаем всех пользователей
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'users' => UserResource::collection(User::all()),
        ]);
    }

    /**
     * Получаем пользователя по id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        return response()->json([
            'user' => new UserResource(User::where('id', $request->id)->first()),
        ]);
    }

    /**
     * Сохраняем нового пользователя
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'short_name' => 'nullable|string',
            'email' => 'required|string|email|max:255',
            'city_id' => 'required|int',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'district_id' => 'nullable|int',
            'seller_id' => 'nullable|int',
            'role' => 'required|string',
            'password' => 'required|confirmed',
            'is_hidden' => 'boolean',
        ]);

        if ($pageIsset = User::where('email', $request['email'])->where('id', '!=', $request['id'])->first()) {
            return response()->json([
                'success' => false,
                'message' => 'Данный email уже существует',
            ]);
        }

        $user = new User();
        $user->name = $request['name'];
        $user->short_name = $request['short_name'];
        $user->email = $request['email'];
        $user->city_id = $request['city_id'];
        $user->phone = $request['phone'];
        $user->address = $request['address'];
        $user->district_id = $request['district_id'];
        $user->seller_id = $request['seller_id'];
        $user->role = $request['role'];
        $user->password = Hash::make($request['password']);
        $user->is_hidden = $request['is_hidden'] ?? 0;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Пользователь успешно добавлен',
            'data' => new UserResource($user),
        ]);
    }

    /**
     * Изменяем данные пользователя
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'int',
            'name' => 'required|string',
            'short_name' => 'nullable|string',
            'email' => 'required|string|email|max:255',
            'city_id' => 'required|int',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'district_id' => 'nullable|int',
            'seller_id' => 'nullable|int',
            'role' => 'required|string',
            'password' => 'confirmed',
            'is_hidden' => 'boolean',
        ]);

        // Проверяем на совпадение email
        $errors = [];
        if ($pageIsset = User::where('email', $request['email'])->where('id', '!=', $request['id'])->first()) {
            $errors['email'] = [];
            array_push($errors['email'], 'Данный email уже существует');
        }

        // Отправляем ошибку если она существует
        if (isset($errors) && count($errors) > 0) {
            return response()->json([
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => $errors,
            ], 422);
        }

        // Сохраняем данные
        $user = User::find($request['id']);
        $user->name = $request['name'];
        $user->short_name = $request['short_name'];
        $user->email = $request['email'];
        $user->city_id = $request['city_id'];
        $user->phone = $request['phone'];
        $user->address = $request['address'];
        $user->district_id = $request['district_id'];
        $user->seller_id = $request['seller_id'];
        $user->role = $request['role'];
        if ($request['password'] != '') {
            $user->password = Hash::make($request['password']);
        }
        $user->is_hidden = $request['is_hidden'] ?? 0;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Пользователь успешно изменен',
            'data' => new UserResource($user),
        ]);
    }
}
