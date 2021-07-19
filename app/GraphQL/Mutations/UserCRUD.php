<?php
namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;

class UserCRUD {
    public function create($root, array $args)
    {
        if(Auth::guard('api')->user()){
            
            $token = Str::random(60);
            $user = new User();
            $user->name = $args['name'];
            $user->email = $args['email'];
            $user->password = Hash::make($args['password']);
            $user->api_token = $token;

            $user->save();
            return [
                'user' => $user,
                'token' => $token
            ];
        }
        else
        {
            return [
                'token' => ''
            ];
        }
    }

    public function update($root, array $args)
    {
         if (Auth::guard('api')->user()){
            $user = User::find($args['id']);
            $user->fill($args);
            $user->save();
    
            return $user;
         }
        
    }

    public function delete($root, array $args)
    {
        if (Auth::guard('api')->user())
        {
            $user = User::find($args['id']);
            $status = $user->delete();

            return [
                'status' => $status,
                'message' => 'User deleted'
            ];
        }
        else{
                
            $status = false;
            return [
                'status' => $status,
                'message' => 'unAuthenticated'
            ];
        }
    }
}