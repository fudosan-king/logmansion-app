<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Contact;
use App\Models\ContactDetail;
use App\Models\ContactFile;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Config;


class ContactController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/client/new-contact",
     *     tags={"Contact"},
     *     summary="Get data for new contact",
     *     description="Retrieve contact types and spots for creating a new contact",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="contact_type",
     *                 type="object",
     *                 @OA\AdditionalProperties(type="string")
     *             ),
     *             @OA\Property(
     *                 property="contact_spot",
     *                 type="object",
     *                 @OA\AdditionalProperties(type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public function newContact()
    {
        try {
            //get two data in select box new contact
            $contact_type = config('const.contact_type');
            $contact_spot = config('const.contact_spot');
            return response()->json(['contact_type' => $contact_type, 'contact_spot' => $contact_spot], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/client/create-contact",
     *     tags={"Contact"},
     *     summary="Create a new contact",
     *     description="Create a new contact with the provided details",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"contact_title", "contact_message"},
     *             @OA\Property(property="contact_type", type="string", example="1"),
     *             @OA\Property(property="contact_spot", type="string", example="2"),
     *             @OA\Property(property="contact_title", type="string", example="New Contact Title"),
     *             @OA\Property(property="contact_message", type="string", example="This is the contact message"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Create contact success")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="object", example={"contact_title": "contact title is required"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public function createContact(Request $request)
    {
        try {
            //validate two field when create contact
            $validator = Validator::make($request->all(), [
                'contact_title' => 'required',
                'contact_message' => 'required',
            ], [
                'contact_title.required' => 'contact title is required',
                'contact_message.required' => 'contact message is required',
            ]);

            //check fails validate
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
            
            //get client id by JWT
            $clientId = JWTAuth::parseToken()->authenticate()->id;
            $client = Client::where('id', $clientId)->first();

            //check exists client
            if (!$client) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            //get all data in client
            $contact_type = $request->input('contact_type');
            $contact_spot = $request->input('contact_spot', null);
            $contact_title = $request->input('contact_title');
            $contact_status = 1;
            $contact_message = $request->input('contact_message');
            $listImage = $request->file('contact_images');
            return is_array($listImage) ? count($listImage) : 0;
            //create new contact
            $contact = new Contact();
            $contact->client_id = $client->client_id;
            $contact->contact_type = $contact_type;
            $contact->contact_spot = $contact_spot;
            $contact->contact_status = $contact_status;
            $contact->contact_title = $contact_title;
            $contact->save();

            //get contact id after create contact and create contact detail
            $contactId = $contact->contact_id;
            $contactDetail = new ContactDetail();
            $contactDetail->contact_id = $contactId;
            $contactDetail->contact_message = $contact_message;
            $contactDetail->author = $client->client_id;
            $contactDetail->author_type = config('const.author_type_client');
            $contactDetail->save();
            //save image if exists data send to contact
            if ($listImage) {
                $contactDetailId = $contactDetail->id;
                $formFolder = 'public/contact/' . $contactId;
                Storage::makeDirectory($formFolder);
                foreach ($listImage as $image) {
                    $currentDateTime = date('YmdHsi');
                    $uniqueFileName = $currentDateTime . '_' . $image->getClientOriginalName();

                    $path = $image->storeAs($formFolder, $uniqueFileName);
                    $contactFile = new ContactFile();
                    $contactFile->contact_detail_id = $contactDetailId;
                    $contactFile->path_file = $path;
                    $contactFile->save();
                }
            }

            return response()->json(['message' => 'Create contact success'], 200);
        }
        catch (JWTException $e) {
            return response()->json(['error' => 'Token is invalid or expired'], 401);
        } 
        catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/client/list-contact",
     *     tags={"Contact"},
     *     summary="List all contacts for a client",
     *     description="Retrieve a list of all contacts for the authenticated client",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="listContact",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="contact_id", type="integer", example=2),
     *                     @OA\Property(property="client_id", type="string", example="Est000002"),
     *                     @OA\Property(property="contact_type", type="integer", example=2),
     *                     @OA\Property(property="contact_spot", type="integer", example=7),
     *                     @OA\Property(property="contact_status", type="integer", example=0),
     *                     @OA\Property(property="contact_title", type="string", example="Et ut debitis deserunt aut odio labore eum."),
     *                     @OA\Property(property="user_id", type="integer", example=2),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-05-20T08:21:02.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-05-20T08:21:02.000000Z"),
     *                     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true, example=null)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public function listContact(Request $request)
    {
        try {
            //get client id by JWT
            $clientId = JWTAuth::parseToken()->authenticate()->id;
            $client = Client::where('id', $clientId)->first();

            //check exists client
            if (!$client) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            //get all contact by client
            $listContact = Contact::where('client_id', $client->client_id)->orderBy('created_at', 'asc')->get();
            return response()->json(['listContact' => $listContact], 200);
        }
        catch (JWTException $e) {
            return response()->json(['error' => 'Token is invalid or expired'], 401);
        } 
        catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/client/list-contact-detail/{id}",
     *     tags={"Contact"},
     *     summary="List all contact details for a specific contact",
     *     description="Retrieve a list of all contact details for the specified contact ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Contact ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="listContactDetail",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=14),
     *                     @OA\Property(property="contact_id", type="integer", example=1),
     *                     @OA\Property(property="contact_message", type="string", example="Esse similique nesciunt hic rerum."),
     *                     @OA\Property(property="author", type="string", example="2"),
     *                     @OA\Property(property="author_type", type="integer", example=1),
     *                     @OA\Property(property="contact_note", type="string", nullable=true, example=null),
     *                     @OA\Property(property="created_at", type="string", format="date-time", nullable=true, example=null),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", nullable=true, example=null),
     *                     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true, example=null)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contact not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Contact not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public function listContactDetail(Request $request, $id)
    {
        try {
            //get client id by JWT
            $clientId = JWTAuth::parseToken()->authenticate()->id;
            $client = Client::where('id', $clientId)->first();

            //check exists client
            if (!$client) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            //get list contact detail by contac id
            Contact::findOrFail($id);
            $listContactDetail = ContactDetail::where('contact_id', $id)->orderBy('created_at', 'asc')->get();
            return response()->json(['listContactDetail' => $listContactDetail], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/client/create-contact-detail",
     *     tags={"Contact"},
     *     summary="Create a new contact detail",
     *     description="Create a new contact detail for the specified contact ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"contact_id", "contact_message"},
     *             @OA\Property(property="contact_id", type="integer", example=1),
     *             @OA\Property(property="contact_message", type="string", example="This is the contact message"),
     *             @OA\Property(
     *                 property="contact_images",
     *                 type="array",
     *                 @OA\Items(type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact detail created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Create contact detail success")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public function createContactDetail(Request $request)
    {
        try {
            //get client id by JWT
            $clientId = JWTAuth::parseToken()->authenticate()->id;
            $client = Client::where('id', $clientId)->first();

            //check exists client
            if (!$client) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            //get data and create contact detail
            $contactId = $request->input('contact_id');
            $contact_message = $request->input('contact_message');
            $listImage = $request->file('contact_images');

            //save contact detail
            $contactDetail = new ContactDetail();
            $contactDetail->contact_id = $contactId;
            $contactDetail->contact_message = $contact_message;
            $contactDetail->author = $client->client_id;
            $contactDetail->author_type = config('const.author_type_client');
            $contactDetail->save();

            //save image if exists data send to contact
            if ($listImage) {
                $contactDetailId = $contactDetail->id;
                $formFolder = 'public/contact/' . $contactId;
                Storage::makeDirectory($formFolder);
                foreach ($listImage as $image) {
                    $currentDateTime = date('YmdHsi');
                    $uniqueFileName = $currentDateTime . '_' . $image->getClientOriginalName();

                    $path = $image->storeAs($formFolder, $uniqueFileName);
                    $contactFile = new ContactFile();
                    $contactFile->contact_detail_id = $contactDetailId;
                    $contactFile->path_file = $path;
                    $contactFile->save();
                }
            }
            return response()->json(['message' => 'Create contact detail success'], 200);
        }
        catch (JWTException $e) {
            return response()->json(['error' => 'Token is invalid or expired'], 401);
        } 
        catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
