<?php

namespace App\Http\Controllers;

use App\Models\Special;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class SpecialController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
    }

    /**
     * @OA\Get(
     *      path="/api/specials",
     *      tags={"special"},
     *      security={{ "apiAuth": {} }} ,
     *      summary="special information",
     *      description="Returns special data",
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
        // $specials = Special::all();
        $specials = Special::where('trash', 1)->get();
        return response()->json($specials->toArray());
    }

    /**
    * @OA\Post(
    * path="/api/specials",
    * tags={"special"},
    * security={{ "apiAuth": {} }} ,
    * summary="add special",
    * description="",
    * @OA\RequestBody(
     *    required=true,
     *    description="",
     *    @OA\JsonContent(
     *       required={"name","address","other_details"},
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

        $special  = new Special();
        $special->people_id     = $request->people_id;
        $special->name     = $request->name;
        $special->other_details     = $request->other_details;

        if ($special->save()) {
            return response()->json(
                [
                    'status' => true,
                    'special'   => $special,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the special could not be saved.',
                ]
            );
        }
    }

    /**
     * @OA\Get(
     *      path="/api/specials/{id}",
     *      tags={"special"},
     *      security={{ "apiAuth": {} }} ,
     *      summary="special information",
     *      description="Returns special data",
     *      @OA\Parameter(
     *          name="id",
     *          description="special id",
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
    public function show(Special $special)
    {
        if ($specials = Special::find($special->id)) {

            return response()->json($specials->toArray());

        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the special could not be show id ' . $special . ' .' ,
                ]
            );
        }
    }


    /**
    * @OA\Put(
    * path="/api/specials/{id}",
    * tags={"special"},
    * security={{ "apiAuth": {} }} ,
    * summary="update special",
    * description="",
    *      @OA\Parameter(
     *          name="id",
     *          description="special id",
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
     *       required={"name","address","other_details"},
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
    public function update(Request $request, Special $special)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'people_id'       => 'required|integer',
                'name'       => 'required|string',
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

        $special->people_id     = $request->people_id;
        $special->name     = $request->name;
        $special->other_details     = $request->other_details;

        if ($special->save()) {
            return response()->json(
                [
                    'status' => true,
                    'special'   => $special,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the special could not be updated.',
                ]
            );
        }
    }


     /**
     * @OA\Delete(
     *      path="/api/specials/{id}",
     *      tags={"special"},
     *      security={{ "apiAuth": {} }} ,
     *      summary="delete special",
     *      description="delete data",
     *      @OA\Parameter(
     *          name="id",
     *          description="special id",
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
    public function destroy(Special $special)
    {
        if ($special->delete()) {
            return response()->json(
                [
                    'status' => true,
                    'special'   => $special,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the special could not be deleted.',
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
                    'other_details'         => 'required|string',

                ]
            );

            if ($validator->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Oops, the special could not be saved data name ' . $value['name'] . ' .' ,
                        'errors' => $validator->errors(),
                    ],
                    400
                );
            }

            $special  = new Special();
            $special->people_id     = $value['people_id'];
            $special->name     = $value['name'];
            $special->other_details     = $value['other_details'];

            if ($special->save()) {

                if(count($request->all()) == $key+1){
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Ok, the special could be saved.',
                        ]
                    );
                }

            } else {
                return response()->json(
                    [
                        'status'  => false,
                        'message' => 'Oops, the special could not be saved data name ' . $value['name'] . ' .' ,
                    ]
                );
            }

        }

    }


     /**
    * @OA\Put(
    * path="/api/specials/del/{id}",
    * tags={"special"},
    * security={{ "apiAuth": {} }} ,
    * summary="disable status special",
    * description="",
     *      @OA\Parameter(
     *          name="id",
     *          description="special id",
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
    public function del($special)
    {

        $special = Special::find($special);

        $special->trash  = 0;

        $special->save();

        if ($special->save()) {
            return response()->json(
                [
                    'status' => true,
                    'special'   => $special,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the special could not be deleted.',
                ]
            );
        }

    }

    protected function guard()
    {
        return Auth::guard();
    }

}
