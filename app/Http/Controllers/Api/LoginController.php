<?php

namespace App\Http\Controllers\Api;

use App\api\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function login(Request $request) {

        
 
        $credentials = $request->only('email', 'password');
        $secret_key = $request->only('client_id', 'client_secret');
        
        try {
            if (env("CLIENT_ID") == $secret_key['client_id'] && env("CLIENT_SECRET") == $secret_key['client_secret']) {
              
                if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']]) ){
                    // Authentication passed...
                    $user = Auth::user();

                    $token = $user->createToken($user->name)->accessToken;
                    $user->access_token = $token;

                    $response = $user;
                   
                    $serverResponse = new JsonResponse('Success', 1, 'User Information', 1, $response);
                    return response()->json($serverResponse, 200);
                } else {
                    $serverResponse = new JsonResponse('Error', 2, 'Invalid Email or Password !', 0);
                    return response()->json($serverResponse, 200);
                }
            } else {
                $serverResponse = new JsonResponse('Error', 2, 'Authorization Failed', 0);
                return response()->json($serverResponse, 200);
            }
        } catch (\Exception $exception) {
            $serverResponse = new JsonResponse('Error', 2, 'Internal Server Error! . Something Went Wrong', 0);
            return response()->json($serverResponse, 200);
        }


    }
}
