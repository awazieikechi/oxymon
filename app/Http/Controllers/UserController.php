<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function getLoan()
    {
        return response()->json(['message' => "Congratulations, you are eligible for a loan"], 200);
    }
}
