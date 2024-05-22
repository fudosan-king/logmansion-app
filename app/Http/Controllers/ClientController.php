<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Estate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Your code here
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($est_id)
    {
        $estateName = Estate::find($est_id)->est_name;
        $maxId = Client::withTrashed()->max('id');
        $genClientid = 'LSM'. str_pad($est_id,3,'0',STR_PAD_LEFT) . str_pad($maxId + 1, 3, '0', STR_PAD_LEFT);
        return view('client/create',[
            'est_id' => $est_id,
            'estateName' => $estateName,
            'genClientid' =>$genClientid
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $message = [
            'client_id.required' => 'The client id field is required.',
            'client_id.unique' => 'The client id has already been taken.',
            'telephone.required' => 'The telephone field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
        ];
        $validatedData = $request->validate([
            'client_id' => 'required|unique:estate_clients',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'telephone' => 'required',
            'email' => 'required|email|max:255|unique:estate_clients,client_email',
        ], $message);
        $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 8 );
        $data = [
            'client_id'=>$request->input('client_id'),
            'est_id'=>$request->input('est_id'),
            'client_f_name'=>$request->input('first_name'),
            'client_l_name'=>$request->input('last_name'),
            'client_furigana_firstname'=>$request->input('first_name_furi'),
            'client_furigana_lastname'=>$request->input('last_name_furi'),
            'client_email'=>$request->input('email'),
            //'client_password'=>Hash::make($password),// send password later
            'client_tel'=>$request->input('telephone')
        ];
        $estate = Client::create($data);
        toast(config('client_labels.toast_create'),'success');
        
        // Mail::to($data['client_email'])->send(new SendPasswordEmail($password));
        // toast('Add client success!','success');
        return redirect()->route('estate.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::find($id);
        $client->estateName = Estate::find($client->est_id)->est_name;
        return view('client/view',[
            'client' => $client
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::find($id);
        $client->estateName = Estate::find($client->est_id)->est_name;
        return view('client/edit',[
            'client' => $client
        ]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        $data = [
            'client_id'=>$request->input('client_id'),
            'est_id'=>$request->input('est_id'),
            'client_f_name'=>$request->input('first_name'),
            'client_l_name'=>$request->input('last_name'),
            'client_furigana_firstname'=>$request->input('first_name_furi'),
            'client_furigana_lastname'=>$request->input('last_name_furi'),
            'client_email'=>$request->input('email'),
            'client_tel'=>$request->input('telephone')
        ];
        $client->update($data);
        toast(config('client_labels.toast_update'),'success');
        return redirect()->route('estate.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        $client->delete();
    }
}