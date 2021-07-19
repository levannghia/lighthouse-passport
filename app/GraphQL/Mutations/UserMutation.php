<?php
namespace App\GraphQL\Mutations;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserMutation {
    public function login($root, array $args)
    {
        $Check = Arr::only($args, ['email', 'password']);

        if(Auth::once($Check)){
            $token = Str::random(60);

            $user = auth()->user();
            $user->api_token = $token;

            $user->save();

            return $token;
        }

        return null;
    }
}