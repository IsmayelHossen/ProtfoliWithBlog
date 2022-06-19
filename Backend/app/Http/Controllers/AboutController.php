<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AboutController extends Controller
{
    public function aboutData(Request $request)
    {
        $id = $request->header('userId');
        $result = DB::table('abouts')->where('user_id', $id)->get();
        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }


    public function SaveaboutData(Request $request)
    {
        $formData = $request->all();
        $validator = Validator::make($formData, [
            'details' => 'required',
            //  'image' => 'required|mimes:jpeg,jpg,png,gif|max:1000'

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 401,
                'message' => $validator->getMessageBag()->first(),
                'errors' => $validator->getMessageBag(),

            ]);
        }
        if ($request->hasFile('image')) {
            $uniqueid = uniqid();
            $file = $request->file('image');
            //   $original_name = $request->file('image')->getClientOriginalName();
            //  $size = $request->file('image')->getSize();
            $extension = $request->file('image')->getClientOriginalExtension();
            $name = $uniqueid . '.' . $extension;
            // $path = $request->file('image')->storeAs('public/uploads', $name);
            // $path = $request->file('image')->store('Image/uploads');
            $file->move('Image/uploads/', $name);
            //   $data['image'] = $name;
            //  $post = DB::table('posts')->insert($data);

            $result = DB::table('abouts')->insert([
                'user_id' => $request->userid,
                'details' => $request->details,
                'hobby' => $request->hobby,
                'experience' => $request->experience,
                'image' => 'Image/uploads/' . $name,



            ]);
            return response()->json([
                "success" => true,
                "data" => $result,
            ]);
        }
    }
    public function update_about($id, Request $request)
    {

        if ($request->hasFile('image')) {
            $uniqueid = uniqid();
            $file = $request->file('image');
            //   $original_name = $request->file('image')->getClientOriginalName();
            //  $size = $request->file('image')->getSize();
            $extension = $request->file('image')->getClientOriginalExtension();
            $name = $uniqueid . '.' . $extension;
            // $path = $request->file('image')->storeAs('public/uploads', $name);
            // $path = $request->file('image')->store('Image/uploads');
            if (!$request->previousimage) {
                unlink($request->previousimage);
            }

            $file->move('Image/uploads/', $name);

            //   $data['image'] = $name;
            //  $post = DB::table('posts')->insert($data);

            $result = DB::table('abouts')->where("user_id", $id)->update([

                'image' => 'Image/uploads/' . $name,
                'details' => $request->details,
                'hobby' => $request->hobby,
                'experience' => $request->experience,
            ]);
            return response()->json([
                "success" => true,
                "data" => $result,
            ]);
        } else {
            $result = DB::table('abouts')->where("user_id", $id)->update([

                'details' => $request->details,
                'hobby' => $request->hobby,
                'experience' => $request->experience,

            ]);
            return response()->json([
                "success" => true,
                "message" => "Successfully data updated",
            ]);
        }
    }
    public function delete_aboutinfo($id, Request $request)
    {
        unlink($request->header('imageDelete'));
        $delete = DB::table('abouts')->where('user_id', $id)->delete();
        return response()->json([
            'success' => true,
            'msg' => "data deleted"
        ]);
    }
    public function saveeducational(Request $request)
    {
        $formData = $request->all();
        $validator = Validator::make($formData, [
            'degree' => 'required',
            'group' => 'required',
            'institution' => 'required',
            'result' => 'required',
            'passing' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 401,
                'message' => $validator->getMessageBag()->first(),
                'errors' => $validator->getMessageBag(),

            ]);
        }

        $result = DB::table('educationals')->insert([
            'degree' => $request->degree,
            'subject' => $request->group,
            'institution' => $request->institution,
            'result' => $request->result,
            'passing' => $request->passing,
            'user_id' => $request->user_id,

        ]);
        return response()->json([
            'status' => 200,
            'msg' => "data save",
            'result' => $result
        ]);
    }

    public function updateEducationalData($id, Request $request)
    {
        $result = DB::table('educationals')->where('id', $id)->update([
            'degree' => $request->degree,
            'subject' => $request->subject,
            'Institution' => $request->institution,
            'Result' => $request->result,
            'passing' => $request->passing,
        ]);
        return response()->json([
            'success' => true,
            'msg' => $result
        ]);
    }
}
