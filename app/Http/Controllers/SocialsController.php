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

    // Definir las redes sociales en un array
    $socials = [
      'Facebook' => 'facebook',
      'Twitter' => 'twitter',
      'Linkedin' => 'linkedin',
      'Mercado libre' => 'freeMarket',
    ];

    $response = ['socials' => $body];

    foreach ($socials as $socialName => $socialField) {
      $social = Social::firstOrNew(['name' => $socialName]);
      $social->save();

      $socialId = $social->id;

      if (isset($body[$socialField])) {
        $userSocial = UserSocial::firstOrNew([
          'user_id' => $user->id,
          'social_id' => $socialId,
        ]);

        $userSocial->link = $body[$socialField];
        $userSocial->save();
      }
    }

    return $this->send_response($response, 'User socials links added successfully.');
  }
}
