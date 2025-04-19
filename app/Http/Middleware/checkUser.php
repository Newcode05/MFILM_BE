<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User as User;

class checkUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $users = User::Where('email', $request->email)->get();
        foreach ($users as $user) {
            if ($user->password == $request->password) {
                return response()->json(
                    [
                        'login_status' => "success",
                        'user' => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email
                        ]
                    ]
                );
            }
        }
        return response()->json(['login_status' => 'fail']);
    }
}
