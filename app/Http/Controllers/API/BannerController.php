<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/banners",
     *     tags={"Banners"},
     *     summary="Get list of banners",
     *     description="Returns list of banners",
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
     *                 @OA\Property(property="banner_id", type="integer"),
     *                 @OA\Property(property="banner_title", type="string"),
     *                 @OA\Property(property="banner_description", type="string"),
     *                 @OA\Property(property="banner_image", type="string"),
     *                 @OA\Property(property="banner_url", type="string"),
     *                 @OA\Property(property="banner_active", type="integer", description="0:deactive | 1:active"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *             ),
     *             ),
     *         ),
     *     ),
     * )
     */

    public function index()
    {
        $banners = Banner::where('banner_active', 1)->get();
        return response()->json([
            'success' => true,
            'data' => $banners,
        ]);
    }
}
