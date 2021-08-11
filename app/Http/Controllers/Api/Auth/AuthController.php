<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Rules\RuleEmployeeFound;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){

        $fields = $request->validate([
            'adminID' => 'required|numeric',
            'adminEmpID' => ['required','numeric',new RuleEmployeeFound],
            'adminEmpFirst' => 'required|string',
            'adminEmpLast' => 'required|string',
            'adminUsername' => 'required|string|unique:users,adminUsername',
            'adminPass' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'adminID' => $fields['adminID'],
            'adminEmpID' => $fields['adminEmpID'],
            'adminEmpFirst' => $fields['adminEmpFirst'],
            'adminEmpLast' => $fields['adminEmpLast'],
            'adminUsername' => $fields['adminUsername'],
            'adminPass' => bcrypt($fields['adminPass'])
        ]);

        $token = $user->createToken('myAppToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    
    
    public function login(Request $request){

        $fields = $request->validate([
            'adminUsername' => 'required|string',
            'adminPass' => 'required|string'
        ]);   

        //Check Username
        $user = User::where('adminUsername', $fields['adminUsername'])->first();

        //Check Password
        if(!$user || !Hash::check($fields['adminPass'], $user->adminPass)){
        return response()->json(
            [
                'message' => 'Bad Credentials'
            ]
        , 401);
        }

        $token = $user->createToken('myAppToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);

    }

    public function logout(){
        Auth::logout();
        
        return [
            'message' => 'Your Logging-Out'
        ];
    }

}
