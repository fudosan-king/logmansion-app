<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
   
    
    /**
     * @license Apache 2.0
     */

    /**
     * @OA\Info(
     *     description="",
     *     version="1.0.0",
     *     title="Log Mansion",
     * )
     *  @OA\Server(
     *      url="http://localhost/api/",
     *      description="Local Environment"
     * )
     *  @OA\Server(
     *      url="http://3.115.241.4/api/",
     *      description="Staging  Environment"
     * )
    * @OA\Get(
    *     path="/",
    *     description="Home page",
    *     @OA\Response(response="default", description="Welcome page")
    * )
     */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
