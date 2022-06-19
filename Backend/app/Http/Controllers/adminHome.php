<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class adminHome extends Controller
{
    public function profile(Request $request)
    {
        $formData = $request->all();
        $validator = Validator::make($formData, [
            'designation' => 'required',
            //'toemail' => 'required|email',
            'mobile' => 'required',
            'githublink' => 'required',
            'linkedinlink' => 'required',
            //  'image' => 'required|mimes:jpeg,jpg,png,gif|max:1000'

        ], [
            'designation.required' => 'Designation Name required',
            'mobile.required' => 'Mobile Number Required',
            'githublink.required' => 'Please provide your github link',
            'linkedinlink.required' => 'Please provide your linkedin link',

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

            $result = DB::table('intros')->insert([
                'user_id' => $request->userid,
                'designation' => $request->designation,
                'currentlyWork' => $request->companyname,
                'position' => $request->position,
                'image' => 'Image/uploads/' . $name,
                'mobile' => $request->mobile,
                'github' => $request->githublink,
                'linkedin' => $request->linkedinlink,


            ]);
            return response()->json([
                "success" => true,
                "data" => $result,
            ]);
        }
    }
    public function update_profile($id, Request $request)
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

            $result = DB::table('intros')->where("user_id", $id)->update([

                'image' => 'Image/uploads/' . $name,
                'designation' => $request->designation,
                'currentlyWork' => $request->currentlyWork,
                'position' => $request->position,
                'mobile' => $request->mobile,
                'github' => $request->githublink,
                'linkedin' => $request->linkedinlink,


            ]);
            $result = DB::table('users')->where("id", $id)->update([

                'name' => $request->name,
            ]);
            return response()->json([
                "success" => true,
                "data" => $result,
            ]);
        } else {
            $result = DB::table('intros')->where("user_id", $id)->update([

                'designation' => $request->designation,
                'currentlyWork' => $request->currentlyWork,
                'position' => $request->position,
                'mobile' => $request->mobile,
                'github' => $request->githublink,
                'linkedin' => $request->linkedinlink,


            ]);
            $result = DB::table('users')->where("id", $id)->update([

                'name' => $request->name,
            ]);
            return response()->json([
                "success" => true,
                "message" => "Successfully data updated",
            ]);
        }
    }
    public function delete_profileinfo($id, Request $request)
    {
        unlink($request->header('imageDelete'));
        $delete = DB::table('users')->where('id', $id)->delete();
        $delete = DB::table('intros')->where('user_id', $id)->delete();
        return response()->json([
            'success' => true,
            'msg' => "data deleted"
        ]);
    }
    // }

    public function technologyadd(Request $request)
    {
        $formData = $request->all();
        $validator = Validator::make($formData, [
            'frontendBackend' => 'required',
            //'toemail' => 'required|email',

            'technology' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 401,
                'message' => $validator->getMessageBag()->first(),
                'errors' => $validator->getMessageBag(),

            ]);
        }

        $result = DB::table('technologies')->insert([
            'frontendBackend' => $request->frontendBackend,
            'percentange' => $request->percentange,
            'technology' => $request->technology,
            'user_id' => $request->user_id,

        ]);
        return response()->json([
            'status' => 200,
            'msg' => "data save",
            'result' => $result
        ]);
    }
    public function updateTechnologyData($id, Request $request)
    {
        $result = DB::table('technologies')->where('id', $id)->update([
            'frontendBackend' => $request->frontendBackend,
            'percentange' => $request->percentange,
            'technology' => $request->technology
        ]);
        return response()->json([
            'success' => true,
            'msg' => $result
        ]);
    }
    public function deleteTechnologyData($id)
    {
        $result = DB::table('technologies')->where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'msg' => $result
        ]);
    }
    public function projectadd(Request $request)
    {

        $formData = $request->all();
        $validator = Validator::make($formData, [
            'title' => 'required',
            'frontend' => 'required',
            'backend' => 'required',


        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 401,
                'message' => $validator->getMessageBag()->first(),
                'errors' => $validator->getMessageBag(),

            ]);
        }

        $result = DB::table('projectlinks')->insert([
            'title' => $request->title,
            'github' => $request->github,
            'live' => $request->live,
            'frontend' => $request->frontend,
            'backend' => $request->backend,
            'user_id' => $request->user_id,

        ]);
        return response()->json([
            'status' => 200,
            'msg' => "data save",
            'result' => $result
        ]);
    }
    public function getprojectData(Request $request)
    {
        $id = $request->header('userId');
        $result = DB::table('projectlinks')->where('user_id', $id)->get();
        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }
    public function updateProjectData($id, Request $request)
    {
        $result = DB::table('projectlinks')->where('id', $id)->update([
            'title' => $request->title,
            'github' => $request->github,
            'live' => $request->live,
            'frontend' => $request->frontend,
            'backend' => $request->backend,
        ]);
        return response()->json([
            'success' => true,
            'msg' => $result
        ]);
    }
    public function deleteProjectData($id)
    {
        $result = DB::table('projectlinks')->where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'msg' => $result
        ]);
    }
}
