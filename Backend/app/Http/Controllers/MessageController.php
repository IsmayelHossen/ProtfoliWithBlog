<?php

namespace App\Http\Controllers;

use App\Events\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function message(Request $request)
    {

        // return response()->json([
        //     'status' => 200,
        //     'msg' => 'message data'
        // ]);
        // $msg = new Message;
        // $msg->from = 1;
        // $msg->to = 2;
        // $msg->read = 1;
        // $msg->msg = 1;
        // $msg->save;
        $created_at = date('Y-m-d');
        $updated_at = date('Y-m-d');
        $data = [];
        $data['from'] = 1;
        $data['to'] = 2;
        $data['read'] = 1;
        $data['msg'] = $request->msg;
        $data['created_at'] = $created_at;
        $data['updated_at'] = $updated_at;
        DB::table('messages')->insert($data);
        event(new Message($request->msg, $request->from, $request->to, $request->read, $created_at, $updated_at));
        return response()->json([
            'status' => 200,
            'msg' => 'message data',
            'data' => $data
        ]);
    }
    public function getAllMsg()
    {
        $result = DB::table('messages')->get();
        return response()->json([
            'status' => 200,
            'data' => $result
        ]);
    }
}
