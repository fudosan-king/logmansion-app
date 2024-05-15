<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
   
    
   

    /**
     * @OA\Info(
     *     description="This is a sample Userstore server.  You can find out more about Swagger at [http://swagger.io](http://swagger.io) or on [irc.freenode.net, #swagger](http://swagger.io/irc/).",
     *     version="1.0.0",
     *     title="Logmansion",
     *     termsOfService="http://swagger.io/terms/",
     *     @OA\Contact(
     *         email="apiteam@swagger.io"
     *     ),
     *     @OA\License(
     *         name="Apache 2.0",
     *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * )
     *  @OA\Server(
     *      url="http://localhost/",
     *      description="Development Environment"
     *  )
     *
     *  @OA\Server(
     *      url="http://127.0.0.1:9000/api/",
     *      description="Staging  Environment"
     * )
     * @OA\Tag(
     *     name="auth",
     *     description="Operations about auth user",
     *     @OA\ExternalDocumentation(
     *         description="Find out more about store",
     *         url="http://swagger.io"
     *     )
     * )
     * @OA\Tag(
     *     name="user",
     *     description="Operations about user",
     *     @OA\ExternalDocumentation(
     *         description="Find out more about store",
     *         url="http://swagger.io"
     *     )
     * )
     * @OA\Tag(
     *     name="upload",
     *     description="Operations about file",
     *     @OA\ExternalDocumentation(
     *         description="Find out more about store",
     *         url="http://swagger.io"
     *     )
     * )
     * @OA\ExternalDocumentation(
     *     description="Find out more about Swagger",
     *     url="http://swagger.io"
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
