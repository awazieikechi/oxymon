<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserValidationRequest;
use App\Http\Requests\LoginValidationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginValidationRequest $request)
    {

        $user = $this->getUser($request);

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'User not found'], 404);
        } else {
            return response()->json(['token' => $this->generateUserAccessToken($user)], 200);
        }
    }

    public function register(CreateUserValidationRequest $request)
    {
        try {

            // Create User
            $input = $request->validated();
            $input['password'] = bcrypt($input['password']);
            User::create($input);
            $user = $this->getUser($request);
            return response()->json(['token' => $this->generateUserAccessToken($user)], 200);
        } catch (\Exception$exception) {

            return response([

                'message' => $exception->getMessage(),
            ], 400);
        }

    }
    protected function getUser(Request $request)
    {
        // dd($request->file('photo'));

        return User::where('email', $request->email)->first();
    }

    private function generateUserAccessToken($user)
    {

        return $user->createToken('MyApp')->accessToken;
    }

}
