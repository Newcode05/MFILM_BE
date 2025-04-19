<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function Insert(Request $request)
    {
        $username = $request['firstname'] . $request['lastname'];
        $email = $request['email'];
        $password = $request['password'];
        $user = User::create([
            'name' => $username,
            'email' => $email,
            'password' => Hash::make($password)
        ]);
        if ($user) {
            return response()
                ->json([
                    'register_status' => 'success',
                    'user' => [
                        'id' => $user->id,
                        'name' => $username,
                        'email' => $email,
                    ]
                ])
                ->cookie('id', $user->id, 60 * 10);
        } else {
            return response()->json(['register_status' => 'fail']);
        }
    }
}
