<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;
use App\Models\ContactDetail;
use App\Models\ContactFile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Config;

use Illuminate\Http\Request;

class EstContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderByDesc('updated_at')->get();
        return view('contact.index', compact('contacts'));
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        $contactFiles = ContactFile::where('contact_id', $id)->get();
        $contactMessages = ContactDetail::where('contact_id', $id)->orderBy('created_at', 'asc')->get();
        return view('contact.edit', compact('contactFiles', 'contactMessages', 'contact'));
    }

    public function getDocSearch(Request $request)
    {
        $valueType = $request->input('value_type');
        $fieldSearchContact = config('const.field_search_contact');
        $fieldSearchValue = $fieldSearchContact[$valueType];
        $dataSearch = Contact::select($fieldSearchValue)->distinct()->get();

        $results = [];

        switch ($valueType) {
            case 0:
                $dataPluck = $dataSearch->pluck('client_id');
                $results = Client::whereIn('client_id', $dataPluck)->get('client_name');
                break;
            case 1:
                $dataPluck = $dataSearch->pluck('user_id');
                $results = User::whereIn('id', $dataPluck)->get('name');
                break;
            case 2:
                $results = config('const.contact_type');
                break;
            default:
                $results = config('const.contact_type');
                break;
        }

        if (empty($results)) {
            return response()->json(false);
        }

        return response()->json($results);
    }

    public function update($id, Request $request)
    {
        $status = $request->input('options-status');
        $responseType = $request->input('options-response');
        $contactMessage = $request->input('contact-message');

        $contactDetail = new ContactDetail();
        $contactDetail->contact_id = $id;
        $contactDetail->contact_message = $contactMessage;
        $contactDetail->author = Auth::user()->id;
        $contactDetail->author_type = config('const.author_type_staff');
        $contactDetail->response_type = $responseType;
        if ($contactDetail->save()) {
            $contact = Contact::findOrFail($id);
            $contact->update([
                'contact_status' => $status,
                'user_id' => Auth::user()->id
            ]);

            return redirect()->route('estcontact.edit', ['id' => $id]);
        } else {
            return redirect()->back()->withErrors(['msg' => 'Failed to save contact detail.']);
        }
    }
}
