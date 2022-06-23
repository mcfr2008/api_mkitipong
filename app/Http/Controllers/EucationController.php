<?php

namespace App\Http\Controllers;

use App\Models\Eucation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class EucationController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api');
    }


    /**
     * @OA\Get(
     *      path="/api/eucations",
     *      tags={"eucation"},
     *      security={{ "apiAuth": {} }} ,
     *      summary="eucation information",
     *      description="Returns eucation data",
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
        // $eucations = Eucation::all();
        $eucations = Eucation::where('trash', 1)->get();
        return response()->json($eucations->toArray());
    }


    /**
        * @OA\Post(
        * path="/api/eucations",
        * tags={"eucation"},
        * security={{ "apiAuth": {} }} ,
        * summary="add eucation",
        * description="",
        * @OA\RequestBody(
        *    required=true,
        *    description="",
        *    @OA\JsonContent(
        *       required={
        *    "people_id",
        *    "level",
        *    "degree",
        *    "branch",
        *    "faculty",
        *    "academy",
        *    "gpa",
        *    "graduation_date",
        *    "other_details"
        *              },
        *       @OA\Property(property="people_id", type="integer", format="people_id", example="1"),
        *       @OA\Property(property="level", type="string", format="level", example="level"),
        *       @OA\Property(property="degree", type="string", format="degree", example="degree"),
        *       @OA\Property(property="branch", type="string", format="branch", example="branch"),
        *       @OA\Property(property="faculty", type="string", format="faculty", example="faculty"),
        *       @OA\Property(property="academy", type="string", format="academy", example="academy"),
        *       @OA\Property(property="gpa", type="string", format="gpa", example="gpa"),
        *       @OA\Property(property="graduation_date", type="date", format="graduation_date", example="2021-01-01"),
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
                'level'       => 'required|string',
                'degree'       => 'required|string',
                'branch'       => 'required|string',
                'faculty'       => 'required|string',
                'academy'       => 'required|string',
                'gpa'       => 'required|string',
                'graduation_date'       => 'required|date',
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

        $eucation  = new Eucation();
        $eucation->people_id     = $request->people_id;
        $eucation->level     = $request->level;
        $eucation->degree     = $request->degree;
        $eucation->branch     = $request->branch;
        $eucation->faculty     = $request->faculty;
        $eucation->academy     = $request->academy;
        $eucation->gpa     = $request->gpa;
        $eucation->graduation_date     = $request->graduation_date;
        $eucation->other_details     = $request->other_details;

        if ($eucation->save()) {
            return response()->json(
                [
                    'status' => true,
                    'eucation'   => $eucation,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the eucation could not be saved.',
                ]
            );
        }
    }


    /**
     * @OA\Get(
     *      path="/api/eucations/{id}",
     *      tags={"eucation"},
     *      security={{ "apiAuth": {} }} ,
     *      summary="eucation information",
     *      description="Returns eucation data",
     *      @OA\Parameter(
     *          name="id",
     *          description="eucation id",
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
    public function show(Eucation $eucation)
    {
        if ($eucations = Eucation::find($eucation)) {

            return response()->json($eucations->toArray());

        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the eucation could not be show id ' . $eucation . ' .' ,
                ]
            );
        }
    }


    /**
        * @OA\Put(
        * path="/api/eucations/{id}",
        * tags={"eucation"},
        * security={{ "apiAuth": {} }} ,
        * summary="update eucation",
        * description="",
        *      @OA\Parameter(
        *          name="id",
        *          description="eucation id",
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
         *       required={
        *    "people_id",
        *    "level",
        *    "degree",
        *    "branch",
        *    "faculty",
        *    "academy",
        *    "gpa",
        *    "graduation_date",
        *    "other_details"
        *              },
        *       @OA\Property(property="people_id", type="integer", format="people_id", example="1"),
        *       @OA\Property(property="level", type="string", format="level", example="level"),
        *       @OA\Property(property="degree", type="string", format="degree", example="degree"),
        *       @OA\Property(property="branch", type="string", format="branch", example="branch"),
        *       @OA\Property(property="faculty", type="string", format="faculty", example="faculty"),
        *       @OA\Property(property="academy", type="string", format="academy", example="academy"),
        *       @OA\Property(property="gpa", type="string", format="gpa", example="gpa"),
        *       @OA\Property(property="graduation_date", type="date", format="graduation_date", example="2021-01-01"),
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
    public function update(Request $request, Eucation $eucation)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'people_id'       => 'required|integer',
                'level'       => 'required|string',
                'degree'       => 'required|string',
                'branch'       => 'required|string',
                'faculty'       => 'required|string',
                'academy'       => 'required|string',
                'gpa'       => 'required|string',
                'graduation_date'       => 'required|date',
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

        $eucation->people_id     = $request->people_id;
        $eucation->level     = $request->level;
        $eucation->degree     = $request->degree;
        $eucation->branch     = $request->branch;
        $eucation->faculty     = $request->faculty;
        $eucation->academy     = $request->academy;
        $eucation->gpa     = $request->gpa;
        $eucation->graduation_date     = $request->graduation_date;
        $eucation->other_details     = $request->other_details;

        if ($eucation->save()) {
            return response()->json(
                [
                    'status' => true,
                    'eucation'   => $eucation,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the eucation could not be updated.',
                ]
            );
        }
    }


     /**
     * @OA\Delete(
     *      path="/api/eucations/{id}",
     *      tags={"eucation"},
     *      security={{ "apiAuth": {} }} ,
     *      summary="delete eucation",
     *      description="delete data",
     *      @OA\Parameter(
     *          name="id",
     *          description="eucation id",
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
    public function destroy(Eucation $eucation)
    {
        if ($eucation->delete()) {
            return response()->json(
                [
                    'status' => true,
                    'eucation'   => $eucation,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the eucation could not be deleted.',
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
                    'level'       => 'required|string',
                    'degree'       => 'required|string',
                    'branch'       => 'required|string',
                    'faculty'       => 'required|string',
                    'academy'       => 'required|string',
                    'gpa'       => 'required|string',
                    'graduation_date'       => 'required|date',
                    'other_details'         => 'required|string',
                ]
            );

            if ($validator->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Oops, the eucation could not be saved data level ' . $value['level'] . ' .' ,
                        'errors' => $validator->errors(),
                    ],
                    400
                );
            }

            $eucation  = new Eucation();
            $eucation->people_id     = $value['people_id'];
            $eucation->level     = $value['level'];
            $eucation->degree     = $value['degree'];
            $eucation->branch     = $value['branch'];
            $eucation->faculty     = $value['faculty'];
            $eucation->academy     = $value['academy'];
            $eucation->gpa     = $value['gpa'];
            $eucation->graduation_date     = $value['graduation_date'];
            $eucation->other_details     = $value['other_details'];

            if ($eucation->save()) {

                if(count($request->all()) == $key+1){
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Ok, the eucation could be saved.',
                        ]
                    );
                }

            } else {
                return response()->json(
                    [
                        'status'  => false,
                        'message' => 'Oops, the eucation could not be saved data name ' . $value['name'] . ' .' ,
                    ]
                );
            }

        }

    }


    /**
    * @OA\Put(
    * path="/api/eucations/del/{id}",
    * tags={"eucation"},
    * security={{ "apiAuth": {} }} ,
    * summary="disable status eucation",
    * description="",
     *      @OA\Parameter(
     *          name="id",
     *          description="eucation id",
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
    public function del($eucation)
    {

        $eucation = Eucation::find($eucation);

        $eucation->trash  = 0;

        $eucation->save();

        if ($eucation->save()) {
            return response()->json(
                [
                    'status' => true,
                    'eucation'   => $eucation,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the eucation could not be deleted.',
                ]
            );
        }

    }

    protected function guard()
    {
        return Auth::guard();
    }

}
