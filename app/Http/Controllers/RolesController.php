<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Role;

class RolesController extends Controller
{
    /**
     * Получаем все населенные пункты
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'roles' => RoleResource::collection(Role::all()),
        ]);
    }

}
