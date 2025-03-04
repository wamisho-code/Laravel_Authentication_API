<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class AuthManager extends Controller
{
    public function register(Request $request)
    {
        // Validate input
        $validate = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users|max:255",
            "password" => "required|min:6",
        ]);

        // Return validation errors if fails
        if ($validate->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validate->errors()
            ], 400);
        }

        // Get validated data
        $validated = $validate->validated();

        // Create user
        $user = User::create([
            "name" => $validated["name"],
            "email" => $validated["email"],
            "password" => bcrypt($validated["password"]),
        ]);

        // Check if user was saved successfully
        if ($user) {
            return response()->json([
                "status" => "success",
                "message" => "Register Success!"
            ], 201);
        }

        // Handle unexpected errors
        return response()->json([
            "status" => "error",
            "message" => "Unknown Error"
        ], 500);
    }

    function login(Request $request){
        $validate = Validator::make($request->all(), [

        
            "email" => "required",
            "password" => "required",
        ]);
        $validated= $validate->validated();
       if(Auth::attempt(["email"=>$validated["email"],
                "password"=>$validated["password"]])){
            $user=Auth::user();
            $token=$user->createToken("mobile_token")->plainTextToken;
                

            return response()->json(["status"=> "success",
            "data"=>["user"=>$user,"token"=>$token],
            "message"=> "Login success!"],
            150);
       }
       return response()->json(["status"=> "error","message"=>"Login error"] ,100);
    }
}
