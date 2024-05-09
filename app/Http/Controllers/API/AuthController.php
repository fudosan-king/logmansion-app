<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/login",
     *      operationId="login",
     *      tags={"Client"},
     *      summary="Login",
     *      description="Login to get access token",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="client_email",
     *                      type="string",
     *                      example="example@example.com"
     *                  ),
     *                  @OA\Property(
     *                      property="client_password",
     *                      type="string",
     *                      format="password",
     *                      example="password"
     *                  ),
     *                  required={"client_email", "client_password"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="token",
     *                  type="string",
     *                  example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjEzZDNiMmUxMTI3NTIzY2U5YTIwNzNkOTY3MTMyZDQxNzllZmRhMjRlNzA0YjBkNzZiOTMxMzM0M2QwNzllMTE3ZmE5ZGIxNjk0ZjIwNTc4In0.eyJhdWQiOiIxIiwianRpIjoiMTNkM2IyZTExMjc1MjNjZTlhMjA3M2Q5NjcxMzJkNDE3OWVmZGEyNGU3MDRiMGQ3NmI5MzEzMzQzZDA3OWUxMTdmYTlkYjE2OTRmMjA1NzgiLCJpYXQiOjE2MTkxMTg1NjgsIm5iZiI6MTYxOTExODU2OCwiZXhwIjoxNjQwNjU0NTY3LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.c3Q4aXfPpZztlNrU4SdbSPk8Hx8epx3lR8IooPM_6z7m6dLd4qRgjO2cyuSs06rsfDy2IBujpYgXrMzufTXAd2Ijtn-9x2RtGoEwD4ByEECef7rS4TYw3D8w3wXrDlXJFcCkI_YvqXbDzI4e5Yf2t9wL9igTwF0_lOM49Fpxi0"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="error",
     *                  type="string",
     *                  example="Unauthorized"
     *              )
     *          )
     *      )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('client_email', 'client_password');
        if (Client::where('client_email', $credentials['client_email'])->exists()) {
            try {
                $token = auth('clients')->attempt([
                    'client_email' => $credentials['client_email'], 
                    'password' => $credentials['client_password']
                ]);
                if (!$token) {
                    return response()->json(['error' => 'invalid_credentials'], 401);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            return response()->json(compact('token'));
        } else {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }
    }

/**
 * @OA\Post(
 *      path="/api/client/change-password",
 *      operationId="changePassword",
 *      tags={"Client"},
 *      summary="Change client's password",
 *      description="Change client's password",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"password", "password_confirmation"},
 *              @OA\Property(
 *                  property="password",
 *                  type="string",
 *                  format="password",
 *                  description="New password"
 *              ),
 *              @OA\Property(
 *                  property="password_confirmation",
 *                  type="string",
 *                  format="password",
 *                  description="Password confirmation"
 *              ),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Password changed successfully",
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="token",
 *                  type="string",
 *                  description="JWT token"
 *              ),
 *              @OA\Property(
 *                  property="message",
 *                  type="string",
 *                  example="Password changed successfully"
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="Unauthorized"
 *              ),
 *          )
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Bad request",
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="The given data was invalid."
 *              ),
 *          )
 *      ),
 *      security={
 *          {"bearerAuth": {}}
 *      }
 * )
 */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = Auth::guard('clients')->user();return Auth::guard('clients');
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user->client_password = bcrypt($request->password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully']);
    }
    
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}
