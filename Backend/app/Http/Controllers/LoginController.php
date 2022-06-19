<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        //dd($request);
        $user = User::where('email', $request->email)->first();
        // print_r($data);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 404,
                'user' => $user
            ]);
        }

        //  $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'success' => true,
            'status' => 200,
            'user' => $user,



        ];

        return response($response, 200);
    }
    public function Getdata()
    {
        return response()->json([
            "success" => true,
            "msg" => "hello sobai"
        ]);
    }
    public function Register(Request $request)


    {
        $formData = $request->all();
        $validator = Validator::make($formData, [
            'name' => 'required',
            //'toemail' => 'required|email',
            'password' => 'required',
            'email' => 'required|email|unique:users',

        ], [
            'name.required' => 'Please provide your name',
            'password.required' => 'Please entire password',
            'email.required' => 'Please Write your valid email',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 401,
                'message' => $validator->getMessageBag()->first(),
                'errors' => $validator->getMessageBag(),

            ]);
        }

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
