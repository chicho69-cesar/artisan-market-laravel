<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\Message;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

  public function login(Request $request): JsonResponse {
    $body = $request->all();

    if (Auth::attempt(['email' => $body['email'], 'password' => $body['password']])) {
      $user = Auth::user();

      $success['token'] = $user->createToken('MyApp')->accessToken;
      $success['user'] = $user;

      return $this->send_response($success, 'User login successfully.');
    } else {
      return $this->send_error('Unauthorised.', ['error' => 'Unauthorised']);
    }
  }

  public function logout(Request $request): JsonResponse {
    $request->user()->token()->revoke();
    return $this->send_response([], 'User logout successfully.');
  }

  public function edit_profile(Request $request): JsonResponse {
    $body = $request->all();

    $validator = Validator::make($body, [
      'name' => 'required|string|max:255',
      'lastname' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
      return $this->send_error('Validation Error', $validator->errors());
    }

    $user = $request->user();
    $user_to_edit = User::find($user->id);

    $user_to_edit->name = $body['name'];
    $user_to_edit->lastname = $body['lastname'];
    $user_to_edit->picture = $body['picture'];
    $user_to_edit->biography = $body['biography'];
    $user_to_edit->save();

    return $this->send_response($user_to_edit, 'User edited successfully.');
  }

  public function upload_profile_picture(Request $request): JsonResponse {
    $user = $request->user();

    if ($request->hasFile('picture')) {
      if ($user->picture) {
        Storage::disk('public')->delete($user->picture);
      }

      $file = $request->file('picture');
      $path = $file->store('profile_pictures', 'public');

      $user->picture = $path;
      $user->save();

      return $this->send_response(['picture' => $user->picture], 'Profile picture uploaded successfully.');
    }

    return $this->send_error('No file uploaded.', ['error' => 'No file uploaded.']);
  }

  public function follow_user(Request $request): JsonResponse {
    $body = $request->all();
    $user = $request->user();

    $user_to_follow = User::find($body['user_follow']);

    if (!$user_to_follow) {
      return $this->send_error('User to follow not found.', ['error' => 'User to follow not found.']);
    }

    $follow = Follower::create([
      'follower_id' => $user->id,
      'following_id' => $user_to_follow->id,
    ]);
    $follow->save();

    return $this->send_response($follow, 'User followed successfully.');
  }

  public function unfollow_user(Request $request): JsonResponse {
    $body = $request->all();
    $user = $request->user();

    $user_following = User::find($body['user_follow']);

    if (!$user_following) {
      return $this->send_error('User following not found.', ['error' => 'User following not found.']);
    }

    $follow = Follower::where('follower_id', $user->id)
      ->where('following_id', $user_following->id)
      ->first();

    if (!$follow) {
      return $this->send_error('You are not following this user.', ['error' => 'You are not following this user.']);
    }

    $follow->delete();

    return $this->send_response($follow, 'User unfollowed successfully.');
  }

  public function get_followers(Request $request): JsonResponse {
    $user = $request->user();
    $followers = Follower::where('following_id', $user->id)->pluck('follower_id');
    $followerUsers = User::whereIn('id', $followers)->get();

    return $this->send_response($followerUsers, 'Here are your followers');
  }

  public function get_followings(Request $request): JsonResponse {
    $user = $request->user();
    $followers = Follower::where('follower_id', $user->id)->pluck('following_id');
    $followerUsers = User::whereIn('id', $followers)->get();

    return $this->send_response($followerUsers, 'Here are your followings');
  }

  public function send_message(Request $request): JsonResponse {
    $body = $request->all();
    $user = $request->user();

    $user_to_send_message = User::find($body['user_to_send_message']);

    if (!$user_to_send_message) {
      return $this->send_error('User to send message not found.', ['error' => 'User to send message not found.']);
    }

    $message = Message::create([
      'user_send_id' => $user->id,
      'user_receive_id' => $user_to_send_message->id,
      'message' => $body['message'],
      'date' => date('Y-m-d H:i:s'),
    ]);
    $message->save();

    return $this->send_response($message, 'Message sent successfully.');
  }

  public function get_conversation_messages(Request $request, string $user_conversation): JsonResponse {
    $user = $request->user();

    $send = Message::where('user_send_id', $user->id)->where('user_receive_id', $user_conversation)->get();
    $receive = Message::where('user_send_id', $user_conversation)->where('user_receive_id', $user->id)->get();

    $conversation = [
      'send' => $send,
      'receive' => $receive,
    ];

    return $this->send_response($conversation, 'Here are your conversation messages');
  }
}
