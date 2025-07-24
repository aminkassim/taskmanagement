<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getListUsers(Request $request)
    {
        return Users::all();
    }

    public function addUser(Request $request)
    {
        $input = $request->all();

        // Create and save user
        $user = Users::create([
         'name' => $input['name'],
         'email' => $input['email'],
         'password' => Hash::make($input['password'])
        ]);

        // $user->createToken('auth_token', ['view-task'])->plainTextToken;

        // Return response with 201 Created
        return response()->json([
          'message' => 'User created successfully.',
          'user' => $user,
        ], Response::HTTP_CREATED); // 201
    }

   

}
