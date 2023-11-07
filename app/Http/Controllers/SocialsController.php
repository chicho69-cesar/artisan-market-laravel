<?php

namespace App\Http\Controllers;

use App\Models\Social;
use App\Models\User;
use App\Models\UserSocial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocialsController extends ResponseController {
  public function store(Request $request): JsonResponse {
    $user = $request->user();
    $body = $request->all();

    $socials = [
      'Facebook' => 'facebook',
      'Twitter' => 'twitter',
      'Linkedin' => 'linkedin',
      'Mercado libre' => 'freeMarket',
    ];

    $response = ['socials' => $body];

    foreach ($socials as $social_name => $social_field) {
      $social = Social::firstOrNew(['name' => $social_name]);
      $social->save();

      $social_id = $social->id;

      if (isset($body[$social_field])) {
        $user_social = UserSocial::firstOrNew([
          'user_id' => $user->id,
          'social_id' => $social_id,
        ]);

        $user_social->link = $body[$social_field];
        $user_social->save();
      }
    }

    return $this->send_response($response, 'User socials links added successfully.');
  }

  public function index(Request $request, $id): JsonResponse {
    $user = User::find($id);

    if (!$user) {
      return $this->send_error('User not found');
    }

    $socials = Social::all()->pluck('name', 'id');
    $result = [];

    foreach ($socials as $socialId => $socialName) {
      $link = $user->socials()
        ->where('social_id', $socialId)
        ->value('link');

      $result[$socialName] = $link ?? null;
    }

    $response = [
      'facebook' => $result['Facebook'],
      'twitter' => $result['Twitter'],
      'linkedin' => $result['Linkedin'],
      'freeMarket' => $result['Mercado libre'],
    ];

    return $this->send_response(['socials' => $response], 'User socials links of the.');
  }
}
