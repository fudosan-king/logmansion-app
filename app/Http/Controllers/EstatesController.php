<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estate;
use App\Models\EstateDoc;
use App\Models\EstateSchedule;
use App\Models\Client;
use Carbon\Carbon;
class EstatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $estates = Estate::orderBy('est_id', 'desc')->get()->toArray();
        $estates = Estate::orderBy('est_id', 'desc')->get()->map(function ($estate) {
            $estateArray = $estate->toArray();
            $estateArray['client'] = $estate->client;
            return $estateArray;
        })->toArray();
        $currentEstates = [];
        foreach ($estates as $estate) {
            $schedules = $this->getEstateSchedules($estate['est_id'])->original;
            $estate['schedules'] = $schedules;
            if ($this->isArchive($estate['est_id'])) {
                continue;
            }else{
                $currentEstates[] = $estate;
            }
        }
        return view('estate/index', [
            'estates' => $currentEstates
        ]);
    }
    public function archive_index(){
        $estates = Estate::orderBy('est_id', 'desc')->get()->map(function ($estate) {
            $estateArray = $estate->toArray();
            $estateArray['client'] = $estate->client;
            return $estateArray;
        })->toArray();
        $archive = [];
        foreach ($estates as $estate) {
            if ($this->isArchive($estate['est_id'])) {
                $archive[] = $estate;
            }
        }
        return view('estate/archive', [
            'estates' => $archive
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
            'est_room_no' => 'required'
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
        $est_id = $estate->est_id;
        $maxId = Client::withTrashed()->max('id');
        $genClientid = 'LSM'. str_pad($est_id,3,'0',STR_PAD_LEFT) . str_pad($maxId + 1, 3, '0', STR_PAD_LEFT);
        //tạo client với estate_id và client_id
        $client = Client::create([
            'client_id' => $genClientid,
            'est_id' => $est_id
        ]);
        toast(config('estate_labels.toast_create'),'success');
        return redirect()->route('estate.index');
    }   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($est_id)
    {
        $estates = Estate::find($est_id);
        $estate_schedule = EstateSchedule::where('est_id', $est_id)->get();
        $estate_document = EstateDoc::where('est_id', $est_id)->orderBy('doc_category','asc')->get();
        $client = Client::where('est_id', $est_id)->first();
        return view('estate/view', [
            'estate' =>$estates,
            'client'=>$client,
            'estate_schedule' => $estate_schedule,
            'estate_document' => $estate_document
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
        $validatedData = $request->validate([
            'est_name' => 'required|max:255|',
            'est_room_no' => 'required'
        ]);
        $estate = Estate::find($id);
        if (!$estate) {
            toast('Data Error','error');
            return redirect()->route('estate.index');
        }
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
        toast(config('estate_labels.toast_update'),'success');
        // return redirect()->route('estate.edit',['id'=>$id]);
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
        // soft delete estate
        $estate = Estate::find($id);
        $estate->delete();
        return redirect()->route('estate.index');
    }
    public function getEstateSchedules($est_id)
    {
        $estateSchedules = EstateSchedule::where('est_id', $est_id)
            ->orderBy('schedule_date','desc') // Order by schedule_date
            ->get()
            ->toArray();
        $result = [];
        foreach ($estateSchedules as $estateSchedule) {
            $scheduleDate = Carbon::parse($estateSchedule['schedule_date']);
            if ($scheduleDate->lte(Carbon::now())) {
                $result['current_schedule'] = $estateSchedule;
                break;
            }
        }
        usort($estateSchedules, function($a, $b) {
            return strtotime($a['schedule_date']) - strtotime($b['schedule_date']);
        });
        foreach ($estateSchedules as $estateSchedule) {
            $scheduleDate = Carbon::parse($estateSchedule['schedule_date']);
            if ($scheduleDate->gt(Carbon::now())) {
                $result['next_schedule'] = $estateSchedule;
                break;
            }
        }
        return response()->json($result);
    }
    public function isArchive($est_id){
        $late_schedule = EstateSchedule::where('est_id', $est_id)
            ->orderBy('schedule_date', 'desc')
            ->first();
        if ($late_schedule) {
            $scheduleDate = strtotime($late_schedule['schedule_date']);
            $oneYearAgo = strtotime('-1 year -1 day');
            if ($scheduleDate <= $oneYearAgo) {
                return true;
            }
        }
        return false;
    }
}
