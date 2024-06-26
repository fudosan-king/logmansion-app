<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ForgotPasswordMail;
use App\Mail\ForgotClientIDMail;
use App\Models\Client;


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
     *                      property="client_id",
     *                      type="string",
     *                      example="Est0001"
     *                  ),
     *                  @OA\Property(
     *                      property="client_password",
     *                      type="string",
     *                      format="password",
     *                      example="super1234"
     *                  ),
     *                  required={"client_id", "client_password"}
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
        $credentials = $request->only('client_id', 'client_password');
        $isFirstLogin = false;
        try {
            $token = auth('estate_clients')->attempt([
                'client_id' => $credentials['client_id'], 
                'password' => $credentials['client_password']
            ]);
            if (!$token) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
            $client = Client::where('client_id', $credentials['client_id'])->first(); 
            // Tính toán thời gian hết hạn token
            $now = \Carbon\Carbon::now();
            $endOfDay = $now->copy()->endOfDay();
            $minutesUntilEndOfDay = $now->diffInMinutes($endOfDay);

            // Thiết lập thời gian hết hạn token
            $customClaims = ['exp' => \Carbon\Carbon::now()->addMinutes($minutesUntilEndOfDay)->timestamp];
            $token = auth('estate_clients')->claims($customClaims)->login($client);
            // $token = auth('estate_clients')->login($client);
            if($client->client_email == null || $client->client_email == ""){
                $isFirstLogin = true;
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token', 'isFirstLogin'));
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
        }
        catch (JWTException $e) {
            return response()->json(['error' => 'Token is invalid or expired'], 401);
        } 
         catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/client/update",
     *      operationId="Update",
     *      tags={"Client"},
     *      summary="Client update on first login",
     *      description="Client update on first login",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  format="email",
     *                  description="email"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *                  format="password",
     *                  description="New password"
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
    public function Update(Request $request)
    {
        $id = 0;
        $token = $request->bearerToken();
        try {
            $id = JWTAuth::setToken($token)->getPayload()['sub'];
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token is expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Unauthenticate'], 401);
        }

        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                // 'password' => 'required|min:6|confirmed',
                'password' => 'required|min:6',
            ], [
                'password.required' => '新しいパスワードを入力してください。',
                'password.min' => '新しいパスワードは少なくとも6文字でなければなりません。',
                'password.confirmed' => '新しいパスワードが一致しません。',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
    
            // $id = JWTAuth::parseToken()->authenticate()->id;
            if($id == 0){
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $user = Client::where('id', $id)->first();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
    
            $user->client_password = bcrypt($request->password);
            $user->client_email = $request->email;
            $user->save();
    
            // return response()->json(['message' => 'Password changed successfully']);
            return response()->json(['user' => $user], 200);
        }
        catch (JWTException $e) {
            return response()->json(['error' => 'Token is invalid or expired'], 401);
        } 
         catch (\Exception $e) {
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
        $token = $request->bearerToken();
        try {
            $id = JWTAuth::setToken($token)->getPayload()['sub'];
            $client = Client::where('id', $id)->first();
            return response()->json(['user' => $client], 200);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token is expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Unauthenticate'], 401);
        }

        // return auth('estate_clients')->user();

        // JWTAuth::setToken($request->bearerToken());
        // $user = JWTAuth::parseToken()->authenticate();

        // return response()->json($user);

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

    /**
     * @OA\Post(
     *     path="/api/forgot-password",
     *     summary="Forgot Password",
     *     tags={"Client"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"client_email"},
     *             @OA\Property(property="client_email", type="string", format="email", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="New password has been sent to your email.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="New password has been sent to your email.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid email address.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid email address.")
     *         )
     *     )
     * )
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'client_email' => 'required|email|exists:estate_clients,client_email',
        ], []);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $client = Client::where('client_email', $request->client_email)->first();

        $newPassword = Str::random(8);

        $client->client_password = bcrypt($newPassword);
        $client->save();

        Mail::to($client->client_email)->send(new ForgotPasswordMail($newPassword, $client));


        return response()->json(['message' => 'New password has been sent to your email.']);
    }

    /**
     * @OA\Post(
     *     path="/api/forgot-client-id",
     *     summary="Forgot client ID",
     *     tags={"Client"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"client_email"},
     *             @OA\Property(property="client_email", type="string", format="email", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client ID has been sent to your email.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Client ID has been sent to your email.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid email address.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid email address.")
     *         )
     *     )
     * )
     */
    public function forgotClientID(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'client_email' => 'required|email|exists:estate_clients,client_email',
        ], []);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $client = Client::where('client_email', $request->client_email)->first();


        Mail::to($client->client_email)->send(new ForgotClientIDMail($client));


        return response()->json(['message' => 'Client ID has been sent to your email.']);
    }

    function getClientID($token) {
        try {
            $id = JWTAuth::setToken($token)->getPayload()['sub'];
            return $id;
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token đã hết hạn'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Unauthenticate'], 401);
        }
    }

}
