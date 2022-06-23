<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class EmailController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
    }


    /**
     * @OA\Get(
     *      path="/api/emails",
     *      tags={"email"},
     *      security={{ "apiAuth": {} }} ,
     *      summary="email information",
     *      description="Returns email data",
     *      @OA\Response(
     *          response=200,
     *          description="OK"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function index()
    {
        // $emails = Email::all();
        $emails = Email::where('trash', 1)->get();
        return response()->json($emails->toArray());
    }

    /**
    * @OA\Post(
    * path="/api/emails",
    * tags={"email"},
    * security={{ "apiAuth": {} }} ,
    * summary="add email",
    * description="",
    * @OA\RequestBody(
     *    required=true,
     *    description="",
     *    @OA\JsonContent(
     *       required={"people_id","name","address","other_details"},
     *       @OA\Property(property="people_id", type="integer", format="people_id", example="1"),
     *       @OA\Property(property="name", type="string", format="name", example="user1"),
     *       @OA\Property(property="address", type="string", format="address", example="user1@mail.com"),
     *       @OA\Property(property="other_details", type="string", format="other_details", example="detail"),
     *    ),
     * ),
    *  @OA\Response(
    *    response=200,
    *    description="OK",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="OK")
    *        )
    *     ),
    * @OA\Response(
    *    response=400,
    *    description="Bad Request",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="Bad Request"),
    *    )
    * )
    * )
    */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'people_id'       => 'required|integer',
                'name'       => 'required|string',
                'address'       => 'required|string',
                'other_details'         => 'required|string',

            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validator->errors(),
                ],
                400
            );
        }

        $email  = new Email();
        $email->people_id     = $request->people_id;
        $email->name     = $request->name;
        $email->address     = $request->address;
        $email->other_details     = $request->other_details;

        if ($email->save()) {
            return response()->json(
                [
                    'status' => true,
                    'email'   => $email,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the email could not be saved.',
                ]
            );
        }
    }

    /**
     * @OA\Get(
     *      path="/api/emails/{id}",
     *      tags={"email"},
     *      security={{ "apiAuth": {} }} ,
     *      summary="email information",
     *      description="Returns email data",
     *      @OA\Parameter(
     *          name="id",
     *          description="email id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function show($email)
    {
        if ($emails = Email::find($email)) {

            return response()->json($emails->toArray());

        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the email could not be show id ' . $email . ' .' ,
                ]
            );
        }
    }

    /**
    * @OA\Put(
    * path="/api/emails/{id}",
    * tags={"email"},
    * security={{ "apiAuth": {} }} ,
    * summary="update email",
    * description="",
    *      @OA\Parameter(
     *          name="id",
     *          description="email id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
    * @OA\RequestBody(
     *    required=true,
     *    description="",
     *    @OA\JsonContent(
     *       required={"people_id","name","address","other_details"},
     *       @OA\Property(property="people_id", type="integer", format="people_id", example="1"),
     *       @OA\Property(property="name", type="string", format="name", example="user1"),
     *       @OA\Property(property="address", type="string", format="address", example="user1@mail.com"),
     *       @OA\Property(property="other_details", type="string", format="other_details", example="detail"),
     *    ),
     * ),
    *  @OA\Response(
    *    response=200,
    *    description="OK",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="OK")
    *        )
    *     ),
    * @OA\Response(
    *    response=400,
    *    description="Bad Request",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="Bad Request"),
    *    )
    * )
    * )
    */
    public function update(Request $request, Email $email)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'people_id'       => 'required|integer',
                'name'       => 'required|string',
                'address'       => 'required|string',
                'other_details'         => 'required|string',

            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validator->errors(),
                ],
                400
            );
        }

        $email->people_id     = $request->people_id;
        $email->name     = $request->name;
        $email->address     = $request->address;
        $email->other_details     = $request->other_details;

        if ($email->save()) {
            return response()->json(
                [
                    'status' => true,
                    'email'   => $email,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the email could not be updated.',
                ]
            );
        }
    }


    /**
     * @OA\Delete(
     *      path="/api/emails/{id}",
     *      tags={"email"},
     *      security={{ "apiAuth": {} }} ,
     *      summary="delete email",
     *      description="delete data",
     *      @OA\Parameter(
     *          name="id",
     *          description="email id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function destroy(Email $email)
    {
        if ($email->delete()) {
            return response()->json(
                [
                    'status' => true,
                    'email'   => $email,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the email could not be deleted.',
                ]
            );
        }
    }

    // ------------------------------

    public function adds(Request $request)
    {

        foreach ($request->all() as $key => $value)
        {

            $validator = Validator::make(
                $value,
                [
                    'people_id'       => 'required|integer',
                    'name'       => 'required|string',
                    'address'       => 'required|string',
                    'other_details'         => 'required|string',
                ]
            );

            if ($validator->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Oops, the email could not be saved data name ' . $value['name'] . ' .' ,
                        'errors' => $validator->errors(),
                    ],
                    400
                );
            }

            $email  = new Email();
            $email->people_id     = $value['people_id'];
            $email->name     = $value['name'];
            $email->address     = $value['address'];
            $email->other_details     = $value['other_details'];

            if ($email->save()) {

                if(count($request->all()) == $key+1){
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Ok, the email could be saved.',
                        ]
                    );
                }

            } else {
                return response()->json(
                    [
                        'status'  => false,
                        'message' => 'Oops, the email could not be saved data name ' . $value['name'] . ' .' ,
                    ]
                );
            }

        }

    }

    /**
    * @OA\Put(
    * path="/api/emails/del/{id}",
    * tags={"email"},
    * security={{ "apiAuth": {} }} ,
    * summary="disable status email",
    * description="",
     *      @OA\Parameter(
     *          name="id",
     *          description="email id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
    *  @OA\Response(
    *    response=200,
    *    description="OK",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="OK")
    *        )
    *     ),
    * @OA\Response(
    *    response=400,
    *    description="Bad Request",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="Bad Request"),
    *    )
    * )
    * )
    */
    public function del($email)
    {

        $email = Email::find($email);

        $email->trash  = 0;

        $email->save();

        if ($email->save()) {
            return response()->json(
                [
                    'status' => true,
                    'email'   => $email,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the email could not be deleted.',
                ]
            );
        }

    }

    protected function guard()
    {
        return Auth::guard();
    }
}
