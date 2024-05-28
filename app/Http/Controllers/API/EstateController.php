<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estate;
use App\Models\Client;
use App\Models\EstateSchedule;
use App\Models\EstateDoc;
use Carbon\Carbon;
class EstateController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/estate/view_estate/{id_client}",
     *     tags={"Estate"},
     *     summary="Get estate of client",
     *     description="Return array of client",
    *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="id_client",
     *                      type="int",
     *                      example="66"
     *                  )
     *              )
     *          )
     *      ),
     *        @OA\Parameter(
    *         name="id_client",
    *         in="path",
    *         description="ID of the client to return the estate for",
    *         required=true,
    *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *              type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
        *             @OA\Items(
        *                 @OA\Property(property="est_id", type="integer"),
        *                 @OA\Property(property="est_room_no", type="string"),
        *                 @OA\Property(property="est_name", type="string"),
        *                 @OA\Property(property="est_zip", type="string"),
        *                 @OA\Property(property="est_pref", type="string"),
        *                 @OA\Property(property="est_city", type="string"),
        *                 @OA\Property(property="est_ward", type="string", nullable=true),
        *                 @OA\Property(property="est_address", type="string", nullable=true),
        *                 @OA\Property(property="est_archive", type="integer"),
        *                 @OA\Property(property="est_usefulinfo_pref_url", type="string", nullable=true),
        *                 @OA\Property(property="est_usefulinfo_pref_show", type="integer"),
        *                 @OA\Property(property="est_usefulinfo_city_url", type="string", nullable=true),
        *                 @OA\Property(property="est_usefulinfo_city_show", type="integer"),
        *                 @OA\Property(property="est_usefulinfo_ward_url", type="string", nullable=true),
        *                 @OA\Property(property="est_usefulinfo_ward_show", type="integer"),
        *                 @OA\Property(property="created_at", type="string", format="date-time"),
        *                 @OA\Property(property="updated_at", type="string", format="date-time"),
        *                 @OA\Property(property="deleted_at", type="string", nullable=true),
        *                 @OA\Property(property="is_archive", type="boolean"),
        *             ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function get_estate($client_id)
    {
        $estate = Estate::whereHas('client', function ($query) use ($client_id) {
            $query->where('id', $client_id);
        })->first();
        $late_schedule = EstateSchedule::where('est_id', $estate->est_id)
        ->orderBy('schedule_date', 'desc')
        ->first();
        if ($late_schedule) {
            $scheduleDate = strtotime($late_schedule['schedule_date']);
            $oneYearAgo = strtotime('-1 year -1 day');
            if ($scheduleDate <= $oneYearAgo) {
                $estate['is_archive'] = true;
            }else{
                $estate['is_archive'] = false;
            }
        }
        return response()->json([
            'success' => $estate ? true : false,
            'message' => $estate ? null : 'Estate not found',
            'data' => $estate ? $estate : null,
        ]);
    }
    /**
     * @OA\Get(
     *     path="/api/estate/view_schedule/{id_client}",
     *     tags={"Estate"},
     *     summary="Get schedule of client",
     *     description="Return array of schedule",
    *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="id_client",
     *                      type="int",
     *                      example="66"
     *                  )
     *              )
     *          )
     *      ),
     *        @OA\Parameter(
    *         name="id_client",
    *         in="path",
    *         description="ID of the client to return the estate for",
    *         required=true,
    *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *              type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
        *             @OA\Items(
        *                 @OA\Property(property="schedule_id", type="integer"),
        *                 @OA\Property(property="est_id", type="integer"),
        *                 @OA\Property(property="schedule_name", type="string"),
        *                 @OA\Property(property="schedule_description", type="string"),
        *                 @OA\Property(property="schedule_date", type="string", format="date-time"),
        *                 @OA\Property(property="schedule_active", type="boolean"),
        *                 @OA\Property(property="position", type="integer"),
        *                 @OA\Property(property="created_at", type="string", format="date-time"),
        *                 @OA\Property(property="updated_at", type="string", format="date-time"),
        *                 @OA\Property(property="deleted_at", type="string", nullable=true),
        *                 @OA\Property(property="current_schedule", type="boolean", nullable=true, description="If true, it is the current schedule"),
        *                 @OA\Property(property="next_schedule", type="boolean", nullable=true, description="If true, it is the next schedule"),
        *             ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function get_schedule($client_id)
    {
        $estate = Estate::whereHas('client', function ($query) use ($client_id) {
            $query->where('id', $client_id);
        })->first();
        if($estate == null){
            return response()->json([
                'success' => false,
                'message' => 'Estate not found',
                'data' => null,
            ]);
        }
        $estateSchedules = EstateSchedule::where('est_id', $estate->est_id)->orderBy('schedule_date','desc')->get();
        foreach ($estateSchedules as $estateSchedule) {
            $scheduleDate = Carbon::parse($estateSchedule['schedule_date']);
            if ($scheduleDate->lte(Carbon::now())) {
                $estateSchedule['current_schedule'] = true;
                break;
            }
        }
        $estateSchedules = $estateSchedules->sortBy('schedule_date')->values();

        foreach ($estateSchedules as $estateSchedule) {
            $scheduleDate = Carbon::parse($estateSchedule['schedule_date']);
            if ($scheduleDate->gt(Carbon::now())) {
                $estateSchedule['next_schedule'] = true;
                break;
            }
        }
        $estateSchedules = $estateSchedules->sortByDesc('schedule_date')->values();
        return response()->json([
            'success' => $estateSchedules ? true : false,
            'message' => $estateSchedules ? null : 'Schedule not found',
            'data' => $estateSchedules ? $estateSchedules : null,
        ]);
    }
    /**
     * @OA\Get(
     *     path="/api/estate/view_docs/{id_client}",
     *     tags={"Estate"},
     *     summary="Get document of client",
     *     description="Return array of document",
    *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="id_client",
     *                      type="int",
     *                      example="66"
     *                  )
     *              )
     *          )
     *      ),
     *        @OA\Parameter(
    *         name="id_client",
    *         in="path",
    *         description="ID of the client to return the estate for",
    *         required=true,
    *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *              type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
    *                 type="array",
       *             @OA\Items(
       *                 @OA\Property(property="doc_id", type="integer"),
       *                 @OA\Property(property="est_id", type="integer"),
       *                 @OA\Property(property="doc_category", type="integer"),
       *                 @OA\Property(property="doc_name", type="string", nullable=true),
       *                 @OA\Property(property="doc_file", type="string"),
       *                 @OA\Property(property="doc_description", type="string", nullable=true),
       *                 @OA\Property(property="created_at", type="string", format="date-time"),
       *                 @OA\Property(property="updated_at", type="string", format="date-time"),
       *                 @OA\Property(property="deleted_at", type="string", nullable=true),
       *             ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function get_document($client_id)
    {
        $estate = Estate::whereHas('client', function ($query) use ($client_id) {
            $query->where('id', $client_id);
        })->first();
        if($estate == null){
            return response()->json([
                'success' => false,
                'message' => 'Estate not found',
                'data' => null,
            ]);
        }
        $estateDocuments = EstateDoc::where('est_id', $estate->est_id)->get();
        return response()->json([
            'success' => $estateDocuments ? true : false,
            'message' => $estateDocuments ? null : 'Document not found',
            'data' => $estateDocuments ? $estateDocuments : null,
        ]);
    }
}
