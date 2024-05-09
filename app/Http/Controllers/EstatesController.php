<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estate;

class EstatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $per_page = request('per_page');
        $estates = Estate::orderBy('est_id', 'desc')
            ->when($search, function ($query, $search) {
                return $query->where('est_name', 'like', '%' . $search . '%');
            })
            ->paginate($per_page?$per_page:config('conts.paging'));
            
        return view('estate/index', [
            'estates' => $estates
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('estate/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'est_name' => 'required|max:255',
            'est_room_no' => 'required|integer'
            // 'zip22' => 'required|regex:/\b\d{3}[-]\d{4}\b/',
            // 'pref21' => 'required|max:255',
            // 'addr21' => 'required|max:255',
            // 'strt21' => 'required|max:255',
            // 'street' => 'required|max:255',
            // 'selected_pref_url' => 'required|url',
            // 'showLinkstatus1' => 'required|in:on,off',
            // 'selected_city_url' => 'required|url',
            // 'showLinkstatus2' => 'required|in:on,off',
            // 'selected_ward_url' => 'required|url',
            // 'showLinkstatus3' => 'required|in:on,off',
        ]);
        $estate = new Estate();
        // Step 1
        $estate->est_name = $request->input('est_name');
        $estate->est_room_no = $request->input('est_room_no');
        $estate->est_zip = $request->input('zip22');
        $estate->est_pref = $request->input('pref21');
        $estate->est_city = $request->input('addr21');
        $estate->est_ward = $request->input('strt21');
        $estate->est_address = $request->input('street');
        // Step 2
        $estate->est_usefulinfo_pref_url = $request->input('selected_pref_url');
        $estate->est_usefulinfo_pref_show = $request->input('showLinkstatus1') === 'on' ? 1 : 0;
        $estate->est_usefulinfo_city_url = $request->input('selected_city_url');
        $estate->est_usefulinfo_city_show = $request->input('showLinkstatus2') === 'on' ? 1 : 0;
        $estate->est_usefulinfo_ward_url = $request->input('selected_ward_url');
        $estate->est_usefulinfo_ward_show = $request->input('showLinkstatus3') === 'on' ? 1 : 0;
        $estate->save();
        return redirect()->route('estates.index');
    }   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estate = Estate::find($id);
        return view('estate/edit', [
            'estate' => $estate
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
        //
        $estate = Estate::find($id);
        //update estate
        $estate->est_name = $request->input('est_name');
        $estate->est_room_no = $request->input('est_room_no');
        $estate->est_zip = $request->input('zip22');
        $estate->est_pref = $request->input('pref21');
        $estate->est_city = $request->input('addr21');
        $estate->est_ward = $request->input('strt21');
        $estate->est_address = $request->input('street');
        // Step 2
        $estate->est_usefulinfo_pref_url = $request->input('selected_pref_url');
        $estate->est_usefulinfo_pref_show = $request->input('showLinkstatus1') === 'on' ? 1 : 0;
        $estate->est_usefulinfo_city_url = $request->input('selected_city_url');
        $estate->est_usefulinfo_city_show = $request->input('showLinkstatus2') === 'on' ? 1 : 0;
        $estate->est_usefulinfo_ward_url = $request->input('selected_ward_url');
        $estate->est_usefulinfo_ward_show = $request->input('showLinkstatus3') === 'on' ? 1 : 0;
        $estate->save();
        return redirect()->route('estates.edit',['id'=>$id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // soft delete estate
        $estate = Estate::find($id);
        $estate->delete();
        return redirect()->route('estates.index');
    }
}
