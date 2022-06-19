<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    public function profileinfo(Request $request)
    {
        $userId = $request->header('userId');
        $result = DB::table('users')
            ->join('intros', 'users.id', '=', 'intros.user_id')
            ->select('users.*', 'intros.*')->where("users.id", $userId)
            ->get();
        return response()->json([
            "success" => true,
            "data" => $result
        ]);
    }
    public function getTechnologieData(Request $request)
    {
        $userId = $request->header('userId');
        $result = DB::table('technologies')
            ->where('user_id', $userId)
            ->get();
        return response()->json([
            "success" => true,
            "data" => $result
        ]);
    }
    public function getProjectData(Request $request)
    {
        $userId = $request->header('userId');
        $result = DB::table('projectlinks')
            ->where('user_id', $userId)
            ->get();
        return response()->json([
            "success" => true,
            "data" => $result
        ]);
    }

    public function geteducationalData(Request $request)
    {
        $userId = $request->header('userId');
        $result = DB::table('educationals')
            ->where('user_id', $userId)
            ->get();
        return response()->json([
            "success" => true,
            "data" => $result
        ]);
    }
}
