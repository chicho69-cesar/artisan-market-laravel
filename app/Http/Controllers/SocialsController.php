<?php

namespace App\Http\Controllers;

use App\Models\Social;
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
}
