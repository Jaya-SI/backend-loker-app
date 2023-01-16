<?php

namespace App\Http\Controllers\Api\HRD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class HrdController extends Controller
{
    public function login(Request $request)
    {
        //get email dan password dari input
        $credentials = $request->only('email', 'password');

        //check jika email dan password tidak sesuai
        if (!$token = auth()->guard('api_hrd')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password salah'
            ], 401);
        }

        //response data "user" benar
        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api_hrd')->user(),
            'token'   => $token
        ], 200);    
    }

    public function getUser()
    {
        //response data "user" yang sedang login
        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api_hrd')->user()
        ], 200);
    }

    public function refreshToken(Request $request)
    {
        //refresh token
        $refreshToken = JWTAuth::refresh(JWTAuth::getToken());

        //set user dengan token baru
        $user = JWTAuth::setToken($refreshToken)->toUser();

        //set header "Authorization" dengan type Bearer + "token" baru
        $request->headers->set('Authorization','Bearer '.$refreshToken);

        //response data "user" dengan "token" baru
        return response()->json([
            'success' => true,
            'user'    => $user,
            'token'   => $refreshToken,  
        ], 200);
    }

    public function logout()
    {
        //remove "token" JWT
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        //response "success" logout
        return response()->json([
            'success' => true,
        ], 200);

    }
}
