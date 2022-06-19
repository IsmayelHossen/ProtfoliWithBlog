<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Mailtable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    public function Mail(Request $request)
    {

        $formData = $request->all();
        $toemail = $request->header('toemail');
        $validator = Validator::make($formData, [
            'name' => 'required',
            //'toemail' => 'required|email',
            'message' => 'required',
            'email' => 'required|email',

        ], [
            'name.required' => 'Please provide your name',
            'message.required' => 'Please Write Something',
            'email.required' => 'Please Write your valid email',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 401,
                'message' => $validator->getMessageBag()->first(),
                'errors' => $validator->getMessageBag(),
                'alldata' => $request->header('toemail'),
            ]);
        }
        $mail = new Mailtable();
        $mail->name = $request->name;
        $mail->toemail = $toemail;
        $mail->subject = $request->subject;
        $mail->message = $request->message;
        $mail->fromemail = $request->email;
        $mail->save();
        if ($mail) {
            $mail1 = Mail::to($toemail)->send(new ContactMail($request->name, $request->subject, $request->message, $request->email));
            return response()->json([
                'status' => 200,
                'message' => "Mail sent successfully",

            ]);
        }
    }
}
