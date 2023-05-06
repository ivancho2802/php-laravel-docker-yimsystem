<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * login: Logs in a registered user
     * @param LoginRequest $request
     * @return Response
     * @throws ValidationException
     */
    public function login(LoginRequest $request)
    {
        //Search for the user where the customer is
        $user = User::where('email', $request->email)->first();
         
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name.$request->email.$request->password);
        $csrf_token = csrf_token();

        return response()->json([
            'status' => true,
            'data' => $user,
            'token' => $token->plainTextToken,
            'csrf_token' => $csrf_token
        ], 201);

        //If user doesn't exists
        /* $user = User::where({email: $request->email})->firstOr(function() use ($request){
            return new User([
                'phone' => $request->phone,
                'device_identifier' => md5($request->phone),
                'push_token' => md5($request->phone)
            ]);
        });
        if (!$user->save()) {
            return $this->failure(__('appark.user.error.creating'));
        } 
        NotificationCreator::sendUserEventPinCodeNotification($user);
        */

    }

    /**
     * registered user
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        
        //Request validation with several rules
        $validator = Validator::make($request->all(), [
            'email'     => 'required|string|unique:users,email|email',
            'password'  => 'required|string',//unique:tablaUsers
            'name'      => 'required|string|min:3|max:255',
            'nivel'      => 'required|string'
            //'device_name' => 'required|string',
            //'role'      => 'required|string'
            //'identifier' => 'required|string|min:8|max:15|unique:users',

        ]);

        //If some validation rule errors where found
        if ($validator->fails()) {
            return response()->json(["status" => false, "message" => $validator->errors()], 422);
        }
        
        $user = User::where('email', $request->email)->first();

        if ($user) {
            throw ValidationException::withMessages([
                'email' => ['Email already register.'],
            ]);
        }

        $body = [
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'name'          => $request->name,
            'nivel'         => $request->nivel,
        ];

        $user = User::create($body);

        //Session token
        $token = $user->createToken($user->name . $user->email)->plainTextToken;
        $user->token = $token;

        return response()->json(["status" => true, 'data' => $user], 201);
    }

    /**
     * logout: Loggs out a current authenticated user
     * @return Response
     */
    public function logout() {
        auth()->user()->currentAccessToken()->delete();
        return $this->success(__('appark.user.session.logout'));
    }

    /**
     * refreshToken: Refresh the User's token
     * @return Response
     * @throws UnauthorizedException
     */
    public function refreshToken() {

        if(!auth()) {
            throw new UnauthorizedException();
        }

        $user = auth()->user();
        // Revoke a specific token...
        auth()->user()->currentAccessToken()->delete();
        $token = $user->createToken($user->name.$user->email)->plainTextToken;

        return $this->success(['token' => $token]);
    }
 
}
