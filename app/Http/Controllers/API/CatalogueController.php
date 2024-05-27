<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Catalogue;

class CatalogueController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/catalogues",
     *     tags={"Catalogues"},
     *     summary="Get list of catalogues",
     *     description="Returns list of catalogues",
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
     *                 @OA\Property(property="cata_id", type="integer"),
     *                 @OA\Property(property="cata_title", type="string"),
     *                 @OA\Property(property="cata_description", type="string"),
     *                 @OA\Property(property="cata_image", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="cata_image_url", type="string"),
     *             ),
     *             ),
     *         ),
     *     ),
     * )
     */

    public function index()
    {
        $catalogues = Catalogue::where('cata_active', 1)->get();
        $catalogues->map(function ($catalogue) {
            $catalogue->cata_image_url = url(Storage::url($catalogue->cata_image));
            return $catalogue;
        });
        return response()->json([
            'success' => true,
            'data' => $catalogues,
        ]);
    }
}
