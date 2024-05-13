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
     *                      example="client1@gmail.com"
     *                  ),
     *                  @OA\Property(
     *                      property="client_password",
     *                      type="string",
     *                      format="password",
     *                      example="super1234"
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
        try {
            $token = auth('clients')->attempt([
                'client_email' => $credentials['client_email'], 
                'password' => $credentials['client_password']
            ]);
            $token = auth('clients')->login(Client::where('client_email', $credentials['client_email'])->first());
            if (!$token) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
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
     *              required={"old_password", "password", "password_confirmation"},
     *              @OA\Property(
     *                  property="old_password",
     *                  type="string",
     *                  format="old_password",
     *                  description="Password"
     *              ),
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
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'password' => 'required|min:6|confirmed',
            ], [
                'old_password.required' => 'パスワードを入力してください。',
                'password.required' => '新しいパスワードを入力してください。',
                'password.min' => '新しいパスワードは少なくとも6文字でなければなりません。',
                'password.confirmed' => '新しいパスワードが一致しません。',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
    
            $id = JWTAuth::parseToken()->authenticate()->id;
            $user = Client::where('client_id', $id)->first();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            if (!Hash::check($request->old_password, $user->client_password)) {
                return response()->json(['error' => "Wrong password"], 401);
            }
    
            $user->client_password = bcrypt($request->password);
            $user->save();
    
            return response()->json(['message' => 'Password changed successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/client/profile",
     *      operationId="client",
     *      tags={"Client"},
     *      summary="Get user profile",
     *      description="Get the authenticated user's profile",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="user",
     *                  type="object",
     *                  @OA\Property(
     *                      property="client_id",
     *                      type="integer",
     *                      example="2"
     *                  ),
     *                  @OA\Property(
     *                      property="est_id",
     *                      type="integer",
     *                      example="2"
     *                  ),
     *                  @OA\Property(
     *                      property="client_name",
     *                      type="string",
     *                      example="Nguyen Van B"
     *                  ),
     *                  @OA\Property(
     *                      property="client_f_name",
     *                      type="string",
     *                      example=null
     *                  ),
     *                  @OA\Property(
     *                      property="client_l_name",
     *                      type="string",
     *                      example=null
     *                  ),
     *                  @OA\Property(
     *                      property="client_furigana",
     *                      type="string",
     *                      example=null
     *                  ),
     *                  @OA\Property(
     *                      property="client_email",
     *                      type="string",
     *                      example="client2@gmail.com"
     *                  ),
     *                  @OA\Property(
     *                      property="client_tel",
     *                      type="string",
     *                      example=null
     *                  ),
     *                  @OA\Property(
     *                      property="created_at",
     *                      type="string",
     *                      example=null
     *                  ),
     *                  @OA\Property(
     *                      property="updated_at",
     *                      type="string",
     *                      example=null
     *                  ),
     *                  @OA\Property(
     *                      property="deleted_at",
     *                      type="string",
     *                      example=null
     *                  )
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
    public function profile(Request $request)
    {
        try {
            $id = JWTAuth::parseToken()->authenticate()->id;
            $client = Client::where('client_id', $id)->first();
            return response()->json(['user' => $client], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
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
