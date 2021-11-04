<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Classroom;

class ClassroomController extends Controller
{
    public function index()
    {
        // Method 1:
        $data = Classroom::archive(false)->whereHas('users', function ($query) {
            return $query->where('users.id', auth()->user()->id);
        })->get();

        return response()->json([
            [
                "Status"        => "OK",
                "Message"       => "Success",
                "User"          => Auth::user(),
                "Classroom"     => $data,
            ]
        ]);
    }
}
