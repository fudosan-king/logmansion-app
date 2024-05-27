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
            $contact_status = config('const.contact_status')[0];
            $contact_message = $request->input('contact_message');
            $listImage = $request->file('contact_images');

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
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

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
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

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

    public function createContactDetail(Request $request, $id)
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
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
