<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends ResponseController {
  public function register(Request $request): JsonResponse {
    $body = $request->all();

    $validator = Validator::make($body, [
      'name' => 'required|string|max:255',
      'lastname' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:6',
      'confirm_password' => 'required|string|same:password',
      'role' => [
        'required',
        'string',
        Rule::in(['seller', 'user']),
      ],
    ]);

    if ($validator->fails()) {
      return $this->send_error('Validation Error', $validator->errors());
    }

    $role = Role::where('name', $body['role'])->first();
    $role_id = 0;

    if (!$role) {
      $created_role = Role::create([
        'name' => $body['role']
      ]);

      $created_role->save();
      $role_id = $created_role->id;
    } else {
      $role_id = $role->id;
    }

    $body = $request->all();
    $body['password'] = bcrypt($body['password']);
    $body['role_id'] = $role_id;

    $user = User::create($body);

    $success['token'] = $user->createToken('MyApp')->accessToken;
    $success['user'] = $user;

    return $this->send_response($success, 'User register successfully.');
  }
}