<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class OrganizationController extends Controller
{

    protected $user;

    public function __construct() {
        $this->middleware('auth:api');
        // $this->user = $this->guard()->user();
    }

    /**
     * @OA\Get(
     *      path="/api/organizations",
     *      tags={"organization"},
     *      security={{ "apiAuth": {} }} ,
     *      summary="organization information",
     *      description="Returns organization data",
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
        // $organizations = Organization::all();
        $organizations = Organization::where('trash', 1)->get();
        return response()->json($organizations->toArray());
    }

    /**
    * @OA\Post(
    * path="/api/organizations",
    * tags={"organization"},
    * security={{ "apiAuth": {} }} ,
    * summary="add organization",
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
                'name'       => 'required|string',
                'address'        => 'required|string',
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

        $organization  = new Organization();
        $organization->name     = $request->name;
        $organization->address     = $request->address;
        $organization->other_details     = $request->other_details;

        if ($organization->save()) {
            return response()->json(
                [
                    'status' => true,
                    'organization'   => $organization,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the organization could not be saved.',
                ]
            );
        }
    }


    /**
     * @OA\Get(
     *      path="/api/organizations/{id}",
     *      tags={"organization"},
     *      security={{ "apiAuth": {} }} ,
     *      summary="organization information",
     *      description="Returns organization data",
     *      @OA\Parameter(
     *          name="id",
     *          description="organization id",
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
    public function show($organization)
    {
        if ($organizations = Organization::find($organization)) {

            return response()->json($organizations->toArray());

        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the organizations could not be show id ' . $organization . ' .' ,
                ]
            );
        }
    }

    /**
    * @OA\Put(
    * path="/api/organizations/{id}",
    * tags={"organization"},
    * security={{ "apiAuth": {} }} ,
    * summary="update organization",
    * description="",
    *      @OA\Parameter(
     *          name="id",
     *          description="organization id",
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
    public function update(Request $request, Organization $organization)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'       => 'required|string',
                'address'        => 'required|string',
                'other_details'         => 'required|string',
                // 'trash'     => 'required|integer',

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

        $organization->name     = $request->name;
        $organization->address     = $request->address;
        $organization->other_details     = $request->other_details;

        if ($organization->save()) {
            return response()->json(
                [
                    'status' => true,
                    'organization'   => $organization,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the organization could not be updated.',
                ]
            );
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/organizations/{id}",
     *      tags={"organization"},
     *      security={{ "apiAuth": {} }} ,
     *      summary="delete organization",
     *      description="delete data",
     *      @OA\Parameter(
     *          name="id",
     *          description="organization id",
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
    public function destroy(Organization $organization)
    {
        if ($organization->delete()) {
            return response()->json(
                [
                    'status' => true,
                    'organization'   => $organization,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the organization could not be deleted.',
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
                        'message' => 'Oops, the organization could not be saved data name ' . $value['name'] . ' .' ,
                        'errors' => $validator->errors(),
                    ],
                    400
                );
            }

            $organization  = new Organization();
            $organization->people_id     = $value['people_id'];
            $organization->name     = $value['name'];
            $organization->other_details     = $value['other_details'];

            if ($organization->save()) {

                if(count($request->all()) == $key+1){
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Ok, the organization could be saved.',
                        ]
                    );
                }

            } else {
                return response()->json(
                    [
                        'status'  => false,
                        'message' => 'Oops, the organization could not be saved data name ' . $value['name'] . ' .' ,
                    ]
                );
            }

        }

    }

    /**
    * @OA\Put(
    * path="/api/organizations/del/{id}",
    * tags={"organization"},
    * security={{ "apiAuth": {} }} ,
    * summary="disable status organization",
    * description="",
     *      @OA\Parameter(
     *          name="id",
     *          description="organization id",
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
    public function del($organization)
    {

        $organization = Organization::find($organization);

        $organization->trash  = 0;

        $organization->save();

        if ($organization->save()) {
            return response()->json(
                [
                    'status' => true,
                    'organization'   => $organization,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the organization could not be deleted.',
                ]
            );
        }

    }

    protected function guard()
    {
        return Auth::guard();
    }
}
