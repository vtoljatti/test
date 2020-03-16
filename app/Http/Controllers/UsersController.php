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
     * @return \Illuminate\Http\JsonResponse
     */
    public function auth()
    {
        return response()->json([
            'user' => new UserResource(User::where('id', Auth::user()->id)->firstOrFail()),
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
        $errors = [];
        $authUser = User::where('id', Auth::user()->id)->firstOrFail();

        // Проверяем доступ на редактирование
        if ($authUser->role != 'admin' && $authUser->role != 'warehouse') {
            $errors['access'] = [];
            array_push($errors['access'], 'Нет доступа для этой операции. Обратитесь к администратору');
        }

        $this->validate($request, [
            'name' => 'required|string|min:1|max:255',
            'short_name' => 'required|string|min:1|max:255',
            'email' => 'required|email|max:255',
            'city_id' => 'required|int',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'district_id' => 'nullable|int',
            'seller_id' => 'nullable|int',
            'role' => 'required|string|max:50',
            'password' => 'required|confirmed',
            'is_hidden' => 'boolean',
        ]);

        // Проверяем на совпадение email
        if ($pageIsset = User::where('email', $request['email'])->where('id', '!=', $request['id'])->first()) {
            $errors['email'] = [];
            array_push($errors['email'], 'Данный email уже существует');
        }

        $user = new User();
        $user->name = $request['name'];
        $user->short_name = $request['short_name'];
        $user->email = $request['email'];
        $user->city_id = $request['city_id'];
        $user->phone = $request['phone'] ?? '';
        $user->address = $request['address'] ?? '';
        $user->district_id = $request['district_id'] ?? 0;
        $user->seller_id = $request['seller_id'] ?? 0;
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
        $errors = [];
        $authUser = User::where('id', Auth::user()->id)->firstOrFail();

        // Проверяем доступ на редактирование
        if (!$authUser || $request['id'] != $authUser->id) {
            if ($authUser->role != 'admin' && $authUser->role != 'warehouse') {
                $errors['access'] = [];
                array_push($errors['access'], 'Нет доступа для этой операции. Обратитесь к администратору');
            }
        }

        $this->validate($request, [
            'id' => 'int',
            'name' => 'required|string|min:1|max:255',
            'short_name' => 'required|string|min:1|max:255',
            'email' => 'required|email|max:255',
            'city_id' => 'required|int',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'district_id' => 'nullable|int',
            'seller_id' => 'nullable|int',
            'role' => 'required|string|max:50',
            'password' => 'confirmed',
            'is_hidden' => 'boolean',
        ]);

        // Проверяем на совпадение email
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
        $user->phone = $request['phone'] ?? '';
        $user->address = $request['address'] ?? '';
        $user->district_id = $request['district_id'] ?? 0;
        $user->seller_id = $request['seller_id'] ?? 0;
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
