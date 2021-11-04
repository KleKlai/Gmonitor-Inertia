<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Classroom;
use Illuminate\Support\Facades\Validator;

class JoinController extends Controller
{
    public function joinClassroom(Request $request)
    {
        // return response(Auth()->user()->getRoleNames());

        // Validate Incoming Data
        $validator = Validator::make($request->all(), array(
            'code'     => 'required|string',
        ));

        //Throw error if validation above doesn't satisfy
        if($validator->fails()) {
            return response()->json(['Message' => $validator->errors()]);
        }

        //Validate current user role
        if(!Auth()->user()->hasRole('student'))
        {
            return response()->json([
                "Status"    => "Ok",
                "Message"   => "Unauthorized"
            ]);
        }

        // Find the classroom using $request->code
        $classroom = Classroom::where('code', $request->code)->first();

        // Make restriction here process if the classroom is not found!
        if($classroom == null){
            return response()->json([
                "Status"    => "Ok",
                "Message"   => "Classroom doesn't exist"
            ]);
        }

        // Validate if the student is already enrolled
        if($classroom->users->contains(Auth()->user()))
        {
            return response()->json([
                "Status"    => "OK",
                "Message"   => "You are already enroll on classroom " . $classroom->name,
            ], 201);
        }

        //Attach the user to the classroom
        //"syncWithoutDetaching" enable the pivot table to prevent duplicate entry if send the request twice
        $classroom->users()->syncWithoutDetaching(Auth()->user(), ['is_teacher' => false]);

        return response()->json([
            "Status"    => "OK",
            "Message"   => "User " . Auth()->user()->email . " joined classroom " . $classroom->name,
            "Classroom" => $classroom,
        ], 201);
    }
}
