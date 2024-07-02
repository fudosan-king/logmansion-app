<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class FAQController extends Controller
{
    public $active = 1;
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
        $faq = FAQ::where('faq_active', $this->active)->get();
        $f = [];

        if ($faq->count() > 0) {
            foreach ($faq as $k => $v) {
                if ($v->faq_type == 1) {
                    $f[__("messages.faq_app")][]  = $v;
                } else {
                    $f[__("messages.faq_home")][] = $v;
                }
            }  
        }
      
        return response()->json($f);
    }
}
