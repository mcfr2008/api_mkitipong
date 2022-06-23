<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;



class AuthController extends Controller
{
   /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
    */

    /**
     * @OA\Post(
     * path="/api/auth/login",
     * summary="login",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Unprocessable Entity",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unprocessable Entity")
     *        )
     *     ),
     *  @OA\Response(
     *    response=401,
     *    description="Unauthorized",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthorized")
     *        )
     *     ),
     *  @OA\Response(
     *    response=200,
     *    description="OK",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="OK")
     *        )
     *     )
     * )

    */

    public function login(Request $request){

    	$validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = $this->guard()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @OA\Post(
     * path="/api/auth/register",
     * summary="register",
     * description="Login by email, password",
     * operationId="authRegister",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="",
     *    @OA\JsonContent(
     *       required={"name","email","password"},
     *       @OA\Property(property="name", type="string", format="name", example="user1"),
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *    ),
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Created",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="User successfully registered")
     *        )
     *     ),
     *  @OA\Response(
     *    response=400,
     *    description="Bad Request",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Bad Request")
     *        )
     *     )
     * )

    */

    public function register(Request $request) {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|between:2,100',
                'email' => 'required|string|email|max:100|unique:users',
                'password' => 'required|string|confirmed|min:6',
            ]
        );

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @OA\Post(
     * path="/api/auth/logout",
     * summary="logout",
     * description="Logout user and invalidate token",
     * operationId="authLogout",
     * tags={"auth"},
     * security={{ "apiAuth": {} }} ,
    *  @OA\Response(
     *    response=200,
     *    description="OK",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="OK")
     *        )
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthorized",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthorized"),
     *    )
     * )
     * )
    */
    public function logout() {

        $this->guard()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
        * @OA\Post(
        * path="/api/auth/refresh",
        * summary="refresh",
        * description="refresh invalidate token",
        * operationId="authreFresh",
        * tags={"auth"},
        * security={{ "apiAuth": {} }} ,
        *  @OA\Response(
        *    response=200,
        *    description="OK",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="OK")
        *        )
        *     )
        * )
    */
    public function refresh() {
        return $this->createNewToken($this->guard()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
        * @OA\Get(
        * path="/api/auth/user-profile",
        * summary="userProfile",
        * description="",
        * operationId="authUserProfile",
        * tags={"auth"},
        * security={{ "apiAuth": {} }} ,
        *  @OA\Response(
        *    response=200,
        *    description="OK",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="OK")
        *        )
        *     )
        * )
    */

    public function userProfile() {
        return response()->json($this->guard()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60,
            'user' => $this->guard()->user()
        ]);
    }

    protected function guard()
    {
        return Auth::guard();

    }

}
