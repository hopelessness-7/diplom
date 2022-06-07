<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    /**
     * Маршруты для администратора
     *
     * @return \Illuminate\Http\Response
     */
    // Показ всех пользователей
    public function index()
    {
        $users = User::all();

        return response()->json(['data'=> $users,], 200);
    }

    /**
     * Создание пользователя
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string|unique:users',
            'document_number' => 'required|string|max:10|min:10|unique:users',
            'email' => 'unique:users'
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors()
                ]
            ], 422);
        };

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'Successfull',
            'user' => $user
        ], 200);
    }

    /**
     * Обновление данных пользователя
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'document_number' => 'required|string|max:10|min:10',
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'errors' => $validator->errors()
                ]
            ], 422);
        };

        $user->update(array_merge(
            $validator->validated(),
        ));

        return response()->json([
            'message' => 'Successfull',
            'user' => $user
        ], 200);

    }

    /**
     * Удаления пользователя
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response(null, Response::HTTP_OK);
    }
}
