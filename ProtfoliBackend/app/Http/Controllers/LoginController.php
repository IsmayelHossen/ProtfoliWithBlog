<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        //dd($request);
        $user = User::where('email', $request->email)->first();
        // print_r($data);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['Password Or Email Wrong.']
            ], 404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'status' => 200,
            'user' => $user,
            'token' => $token
        ];

        return response($response, 200);
    }
    public function Getdata()
    {
        return response()->json([
            "success" => true,
            "msg" => "get data ok"
        ]);
    }
    public function Register(Request $request)
    {
        $result = DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return response()->json([
            'status' => 200,
            'msg' => "data save"
        ]);
    }
}
