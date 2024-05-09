<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FAQ;

class FAQController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/faq",
     *     tags={"FAQ"},
     *     summary="Get list of FAQ",
     *     description="Returns list of FAQ",
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
     *              @OA\Property(
     *                      property="data",
     *                      type="array",
     *                      @OA\Items(
     *                      @OA\Property(property="faq_id", type="integer"),
     *                      @OA\Property(property="faq_title", type="string"),
     *                      @OA\Property(property="faq_content", type="string"),
     *                      @OA\Property(property="faq_active", type="integer", description="0:deactive | 1:active"),
     *                      @OA\Property(property="created_at", type="string", format="date-time"),
     *                      @OA\Property(property="updated_at", type="string", format="date-time"),
    *                  ),
     *             ),
     *         ),
     *     ),
     * )
     */

    public function index()
    {
        $faq = FAQ::where('faq_active', 1)->get();
        return response()->json($faq);
    }
}
