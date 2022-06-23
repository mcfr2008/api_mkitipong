<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
// use Spatie\Activitylog\Models\Activity;

class PeopleController extends Controller
{

    protected $user;

    public function __construct() {
        $this->middleware('auth:api');
        // $this->user = $this->guard()->user();
    }


    // public function get_peoples()
    // {

    //     // $peoples = DB::table('peoples')->get();
    //     // return response()->json($peoples->toArray());

    //     $peoples = People::all();
    //     return response()->json($peoples->toArray());

    //     // return response()->json(
    //     //     [
    //     //         'item_a ' => $peoples,
    //     //         'item_b' => $peoples
    //     //     ]
    //     // );

    // }

    // public function get_peoples_id(Request $request)
    // {

    //     $peoples = People::where('id', $request->id)->get();
    //     return response()->json($peoples->toArray());

    // }


    /**
     * @OA\Get(
     *      path="/api/peoples",
     *      tags={"people"},
     *      security={{ "apiAuth": {} }} ,
     *      summary="people information",
     *      description="Returns people data",
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

        // Activity::all();

        // activity()->log('Look mum, I logged something');




        $peoples = People::all();



        return response()->json($peoples->toArray());


    }


  /**
        * @OA\Post(
        * path="/api/peoples",
        * tags={"people"},
        * security={{ "apiAuth": {} }} ,
        * summary="add people",
        * description="",
        * @OA\RequestBody(
        *    required=true,
        *    description="",
        *    @OA\JsonContent(
        *       required={
        *    "organization_id",
        *    "military_status_id",
        *    "registered_peoples_YN",
        *    "prefix_name",
        *    "first_name",
        *    "last_name",
        *    "nickname",
        *    "gender",
        *    "blood_type",
        *    "birth_date",
        *    "citizenid",
        *    "nationality_name",
        *    "religion_name",
        *    "country_address_detail_1",
        *    "country_address_detail_2",
        *    "country_address_district",
        *    "country_address_province",
        *    "country_address_postcode",
        *    "current_address_detail_1",
        *    "current_address_detail_2",
        *    "current_address_district",
        *    "current_address_province",
        *    "current_address_postcode",
        *    "current_height",
        *    "current_weight"
        *              },
        *       @OA\Property(property="organization_id", type="integer", format="organization_id", example="organization_id"),
        *       @OA\Property(property="military_status_id", type="integer", format="military_status_id", example="military_status_id"),
        *       @OA\Property(property="registered_peoples_YN", type="boolean", format="registered_peoples_YN", example="registered_peoples_YN"),
        *       @OA\Property(property="prefix_name", type="string", format="prefix_name", example="prefix_name"),
        *       @OA\Property(property="first_name", type="string", format="first_name", example="first_name"),
        *       @OA\Property(property="last_name", type="string", format="last_name", example="last_name"),
        *       @OA\Property(property="nickname", type="string", format="nickname", example="nickname"),
        *       @OA\Property(property="gender", type="string", format="gender", example="gender"),
        *       @OA\Property(property="blood_type", type="string", format="blood_type", example="blood_type"),
        *       @OA\Property(property="birth_date", type="date", format="birth_date", example="birth_date"),
        *       @OA\Property(property="citizenid", type="string", format="citizenid", example="citizenid"),
        *       @OA\Property(property="nationality_name", type="string", format="nationality_name", example="nationality_name"),
        *       @OA\Property(property="religion_name", type="string", format="religion_name", example="religion_name"),
        *       @OA\Property(property="country_address_detail_1", type="string", format="country_address_detail_1", example="country_address_detail_1"),
        *       @OA\Property(property="country_address_detail_2", type="string", format="country_address_detail_2", example="country_address_detail_2"),
        *       @OA\Property(property="country_address_district", type="string", format="country_address_district", example="country_address_district"),
        *       @OA\Property(property="country_address_province", type="string", format="country_address_province", example="country_address_province"),
        *       @OA\Property(property="country_address_postcode", type="string", format="country_address_postcode", example="country_address_postcode"),
        *       @OA\Property(property="current_address_detail_1", type="string", format="current_address_detail_1", example="current_address_detail_1"),
        *       @OA\Property(property="current_address_detail_2", type="string", format="current_address_detail_2", example="current_address_detail_2"),
        *       @OA\Property(property="current_address_district", type="string", format="current_address_district", example="current_address_district"),
        *       @OA\Property(property="current_address_province", type="string", format="current_address_province", example="current_address_province"),
        *       @OA\Property(property="current_address_postcode", type="string", format="current_address_postcode", example="current_address_postcode"),
        *       @OA\Property(property="current_height", type="string", format="current_height", example="current_height"),
        *       @OA\Property(property="current_weight", type="string", format="current_weight", example="current_weight"),
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
                'organization_id'       => 'required|integer',
                'military_status_id'    => 'required|integer',
                'registered_peoples_YN' => 'required|boolean',
                'prefix_name'       => 'required|string',
                'first_name'        => 'required|string',
                'last_name'         => 'required|string',
                'nickname'          => 'required|string',
                'gender'            => 'required|string',
                'blood_type'        => 'required|string',
                'birth_date'        => 'required|date',
                'citizenid'         => 'required|string',
                'nationality_name'  => 'required|string',
                'religion_name'     => 'required|string',
                'country_address_detail_1'     => 'required|string',
                'country_address_detail_2'     => 'required|string',
                'country_address_district'     => 'required|string',
                'country_address_province'     => 'required|string',
                'country_address_postcode'     => 'required|string',
                'current_address_detail_1'     => 'required|string',
                'current_address_detail_2'     => 'required|string',
                'current_address_district'     => 'required|string',
                'current_address_province'     => 'required|string',
                'current_address_postcode'     => 'required|string',
                'current_height'     => 'required|string',
                'current_weight'     => 'required|string',
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

        $people = new People();
        $people->organization_id     = $request->organization_id;
        $people->military_status_id     = $request->military_status_id;
        $people->registered_peoples_YN     = $request->registered_peoples_YN;
        $people->prefix_name     = $request->prefix_name;
        $people->first_name     = $request->first_name;
        $people->last_name     = $request->last_name;
        $people->nickname     = $request->nickname;
        $people->gender     = $request->gender;
        $people->blood_type     = $request->blood_type;
        $people->birth_date     = $request->birth_date;
        $people->citizenid     = $request->citizenid;
        $people->nationality_name     = $request->nationality_name;
        $people->religion_name     = $request->religion_name;
        $people->country_address_detail_1     = $request->country_address_detail_1;
        $people->country_address_detail_2     = $request->country_address_detail_2;
        $people->country_address_district     = $request->country_address_district;
        $people->country_address_province     = $request->country_address_province;
        $people->country_address_postcode     = $request->country_address_postcode;
        $people->current_address_detail_1     = $request->current_address_detail_1;
        $people->current_address_detail_2     = $request->current_address_detail_2;
        $people->current_address_district     = $request->current_address_district;
        $people->current_address_province     = $request->current_address_province;
        $people->current_address_postcode     = $request->current_address_postcode;
        $people->current_height     = $request->current_height;
        $people->current_weight     = $request->current_weight;

        if ($people->save()) {
            return response()->json(
                [
                    'status' => true,
                    'people'   => $people,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the people could not be saved.',
                ]
            );
        }
    }


    /**
     * @OA\Get(
     *      path="/api/peoples/{id}",
     *      tags={"people"},
     *      security={{ "apiAuth": {} }} ,
     *      summary="people information",
     *      description="Returns people data",
     *      @OA\Parameter(
     *          name="id",
     *          description="people id",
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
    public function show($people)
    {

        if ($peoples = People::find($people)) {

            // $this->people_updates($people);

            return response()->json($peoples->toArray());


        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the people could not be show id ' . $people . ' .' ,
                ]
            );
        }
    }


        /**
    * @OA\Put(
    * path="/api/peoples/{id}",
    * tags={"people"},
    * security={{ "apiAuth": {} }} ,
    * summary="update people",
    * description="",
    *      @OA\Parameter(
     *          name="id",
     *          description="people id",
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
        *    "organization_id",
        *    "military_status_id",
        *    "registered_peoples_YN",
        *    "prefix_name",
        *    "first_name",
        *    "last_name",
        *    "nickname",
        *    "gender",
        *    "blood_type",
        *    "birth_date",
        *    "citizenid",
        *    "nationality_name",
        *    "religion_name",
        *    "country_address_detail_1",
        *    "country_address_detail_2",
        *    "country_address_district",
        *    "country_address_province",
        *    "country_address_postcode",
        *    "current_address_detail_1",
        *    "current_address_detail_2",
        *    "current_address_district",
        *    "current_address_province",
        *    "current_address_postcode",
        *    "current_height",
        *    "current_weight"
        *              },
        *       @OA\Property(property="organization_id", type="integer", format="organization_id", example="organization_id"),
        *       @OA\Property(property="military_status_id", type="integer", format="military_status_id", example="military_status_id"),
        *       @OA\Property(property="registered_peoples_YN", type="boolean", format="registered_peoples_YN", example="registered_peoples_YN"),
        *       @OA\Property(property="prefix_name", type="string", format="prefix_name", example="prefix_name"),
        *       @OA\Property(property="first_name", type="string", format="first_name", example="first_name"),
        *       @OA\Property(property="last_name", type="string", format="last_name", example="last_name"),
        *       @OA\Property(property="nickname", type="string", format="nickname", example="nickname"),
        *       @OA\Property(property="gender", type="string", format="gender", example="gender"),
        *       @OA\Property(property="blood_type", type="string", format="blood_type", example="blood_type"),
        *       @OA\Property(property="birth_date", type="date", format="birth_date", example="birth_date"),
        *       @OA\Property(property="citizenid", type="string", format="citizenid", example="citizenid"),
        *       @OA\Property(property="nationality_name", type="string", format="nationality_name", example="nationality_name"),
        *       @OA\Property(property="religion_name", type="string", format="religion_name", example="religion_name"),
        *       @OA\Property(property="country_address_detail_1", type="string", format="country_address_detail_1", example="country_address_detail_1"),
        *       @OA\Property(property="country_address_detail_2", type="string", format="country_address_detail_2", example="country_address_detail_2"),
        *       @OA\Property(property="country_address_district", type="string", format="country_address_district", example="country_address_district"),
        *       @OA\Property(property="country_address_province", type="string", format="country_address_province", example="country_address_province"),
        *       @OA\Property(property="country_address_postcode", type="string", format="country_address_postcode", example="country_address_postcode"),
        *       @OA\Property(property="current_address_detail_1", type="string", format="current_address_detail_1", example="current_address_detail_1"),
        *       @OA\Property(property="current_address_detail_2", type="string", format="current_address_detail_2", example="current_address_detail_2"),
        *       @OA\Property(property="current_address_district", type="string", format="current_address_district", example="current_address_district"),
        *       @OA\Property(property="current_address_province", type="string", format="current_address_province", example="current_address_province"),
        *       @OA\Property(property="current_address_postcode", type="string", format="current_address_postcode", example="current_address_postcode"),
        *       @OA\Property(property="current_height", type="string", format="current_height", example="current_height"),
        *       @OA\Property(property="current_weight", type="string", format="current_weight", example="current_weight"),
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
    public function update(Request $request, people $people)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'organization_id'       => 'required|integer',
                'military_status_id'    => 'required|integer',
                'registered_peoples_YN' => 'required|boolean',
                'prefix_name'       => 'required|string',
                'first_name'        => 'required|string',
                'last_name'         => 'required|string',
                'nickname'          => 'required|string',
                'gender'            => 'required|string',
                'blood_type'        => 'required|string',
                'birth_date'        => 'required|date',
                'citizenid'         => 'required|string',
                'nationality_name'  => 'required|string',
                'religion_name'     => 'required|string',
                'country_address_detail_1'     => 'required|string',
                'country_address_detail_2'     => 'required|string',
                'country_address_district'     => 'required|string',
                'country_address_province'     => 'required|string',
                'country_address_postcode'     => 'required|string',
                'current_address_detail_1'     => 'required|string',
                'current_address_detail_2'     => 'required|string',
                'current_address_district'     => 'required|string',
                'current_address_province'     => 'required|string',
                'current_address_postcode'     => 'required|string',
                'current_height'     => 'required|string',
                'current_weight'     => 'required|string',
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

        $people->organization_id     = $request->organization_id;
        $people->military_status_id     = $request->military_status_id;
        $people->registered_peoples_YN     = $request->registered_peoples_YN;
        $people->prefix_name     = $request->prefix_name;
        $people->first_name     = $request->first_name;
        $people->last_name     = $request->last_name;
        $people->nickname     = $request->nickname;
        $people->gender     = $request->gender;
        $people->blood_type     = $request->blood_type;
        $people->birth_date     = $request->birth_date;
        $people->citizenid     = $request->citizenid;
        $people->nationality_name     = $request->nationality_name;
        $people->religion_name     = $request->religion_name;
        $people->country_address_detail_1     = $request->country_address_detail_1;
        $people->country_address_detail_2     = $request->country_address_detail_2;
        $people->country_address_district     = $request->country_address_district;
        $people->country_address_province     = $request->country_address_province;
        $people->country_address_postcode     = $request->country_address_postcode;
        $people->current_address_detail_1     = $request->current_address_detail_1;
        $people->current_address_detail_2     = $request->current_address_detail_2;
        $people->current_address_district     = $request->current_address_district;
        $people->current_address_province     = $request->current_address_province;
        $people->current_address_postcode     = $request->current_address_postcode;
        $people->current_height     = $request->current_height;
        $people->current_weight     = $request->current_weight;

        if ($people->save()) {
            return response()->json(
                [
                    'status' => true,
                    'people'   => $people,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the people could not be updated.',
                ]
            );
        }
    }


    /**
     * @OA\Delete(
     *      path="/api/peoples/{id}",
     *      tags={"people"},
     *      security={{ "apiAuth": {} }} ,
     *      summary="delete people",
     *      description="delete data",
     *      @OA\Parameter(
     *          name="id",
     *          description="people id",
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
    public function destroy(people $people)
    {

        if ($people->delete()) {
            return response()->json(
                [
                    'status' => true,
                    'people'   => $people,
                ]
            );
        } else {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Oops, the people could not be deleted.',
                ]
            );
        }

    }

    protected function people_updates($request)
    {

        DB::table('people_updates')->insert([
            'people_id' => $request,
            'date_received' => date('Y-m-d'),
            'subject' => 'test',
            'message' => 'test',
            'other_details' => 'test',
            'created_at' => date('Y-m-d H:i:s')
        ]);

    }

    protected function guard()
    {
        return Auth::guard();
    }
}
