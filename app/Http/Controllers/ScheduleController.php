<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EstateSchedule;
use App\Models\Estate;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jsonData = $request->input('schedules');
        $estateId = $request->input('estateId');
        $schedules = json_decode($jsonData, true);
        foreach ($schedules as $schedule) {
            if (!empty($schedule)) {
                $newSchedule = new EstateSchedule();
                $newSchedule->est_id =  $estateId;
                $newSchedule->schedule_name = isset($schedule['schedule-name']) ? $schedule['schedule-name'] : null;
                $newSchedule->schedule_description = isset($schedule['schedule-description']) ? $schedule['schedule-description'] : null;
                $newSchedule->schedule_date = isset($schedule['schedule-date']) ? $schedule['schedule-date'] : null;
                $newSchedule->position = isset($schedule['index']) ? $schedule['index'] : null;
                $newSchedule->save();
            }
        }

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Estate::findOrFail($id);
        $estateId = $id;
        $findSchedule = $data = EstateSchedule::where('est_id', $id)->get();
        if (count($findSchedule->toArray()) == 0) {
            return view('schedule.schedule', compact('estateId'));
        } else {
            $getAllSchedule = EstateSchedule::where('est_id', $id)->orderBy('position')->get();
            return view('schedule.edit', compact('estateId', 'getAllSchedule'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $jsonData = $request->input('schedules');
        $estateId = $request->input('estateId');
        $schedules = json_decode($jsonData, true);
        foreach ($schedules as $schedule) {
            if (!empty($schedule)) {
                if (isset($schedule['schedule-id']) && $schedule['schedule-id'] != '') {
                    $updateSchedule = EstateSchedule::findOrFail($schedule['schedule-id']);
                    $updateSchedule->update([
                        'schedule_name' =>  isset($schedule['schedule-name']) ? $schedule['schedule-name'] : null,
                        'schedule_description' => isset($schedule['schedule-description']) ? $schedule['schedule-description'] : null,
                        'schedule_date' => isset($schedule['schedule-date']) ? $schedule['schedule-date'] : null,
                        'position' => isset($schedule['index']) ? $schedule['index'] : null
                    ]);
                } else {
                    $newSchedule = new EstateSchedule();
                    $newSchedule->est_id =  $estateId;
                    $newSchedule->schedule_name = isset($schedule['schedule-name']) ? $schedule['schedule-name'] : null;
                    $newSchedule->schedule_description = isset($schedule['schedule-description']) ? $schedule['schedule-description'] : null;
                    $newSchedule->schedule_date = isset($schedule['schedule-date']) ? $schedule['schedule-date'] : null;
                    $newSchedule->position = isset($schedule['index']) ? $schedule['index'] : null;
                    $newSchedule->save();
                }
            }
        }

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
        $schedule = EstateSchedule::findOrFail($id);
        $schedule->delete();
        return true;
    }
}
