<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotiCategory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DataTables; 
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            return $this->getNotifications();
        }
        return view('notifications.index');
    }

    public function create()
    {
        $categories = NotiCategory::all();
        return view('notifications.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cat_id' => 'required',
            'noti_title' => 'required',
            'noti_content' => 'nullable',
            'noti_date' => 'required|date',
            'noti_status' => 'nullable',
            'noti_url' => 'nullable|url',
        ], [
            'required' => 'この項目は必須です。',
            'date' => '無効な形式です。',
            'url' => '無効な形式です。',
        ]);
        $data['noti_status'] = $request->has('noti_status');
        $notification = Notification::create($data);
        toast('Notification created successfully.','success');
        return redirect()->route('notification.index');
    }

    public function edit($id)
    {
        $notification = Notification::findOrFail($id);
        $categories = NotiCategory::all();
        return view('notifications.edit', compact('notification', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $data = $request->validate([
            'cat_id' => 'required',
            'noti_title' => 'required',
            'noti_content' => 'nullable',
            // 'noti_date' => 'required|date',
            'noti_status' => 'nullable',
            'noti_url' => 'nullable|url',
        ], [
            'required' => 'この項目は必須です。',
            'date' => '無効な形式です。',
            'url' => '無効な形式です。',
        ]);
        $data['noti_status'] = $request->has('noti_status');
        $notification->update($data);

        toast('Notification updated successfully.','success');
        return redirect()->route('notification.index');
    }

    public function destroy($id)
    {
        try {
            $notification = Notification::findOrFail($id);
            $notification->delete();
            // toast('Notification deleted successfully.','success');
            // return redirect()->route('notification.index');
            return response(["message" => "Notification Deleted Successfully"], 200);
        } catch(exception $e) {
            return response(["message" => "Data Delete Error! Please Try again"], 201);
        }
    }

    private function getNotifications()
    {
        $data = Notification::all();
        return DataTables::of($data)
                ->addColumn('noti_date', function($row){
                    return Carbon::parse($row->noti_date)->format('Y/m/d');
                })
                ->addColumn('cat_name', function($row){
                    return $row->category->cat_name ?? '';
                })
                ->addColumn('updated_at', function($row){
                    return Carbon::parse($row->updated_at)->format('Y/m/d');
                })
                ->addColumn('active', function($row){
                    return $row->noti_status ? '表示' : '非表示';
                })
                ->addColumn('action', function($row){
                    $action = ""; 
                    $action.="<a class='btn btn-xs btn-warning' id='btnEdit' href='".route('notification.edit', $row->noti_id)."'><i class='fas fa-edit'></i></a>"; 
                    $action.=" <button class='btn btn-xs btn-outline-danger' id='btnDel' data-id='".$row->noti_id."'><i class='fas fa-trash'></i></button>"; 
                    return $action;
                })
                ->rawColumns(['noti_date', 'cat_name', 'updated_at','active', 'action'])
                ->addColumn('searchable', function ($row) {
                    return [
                        $row->noti_id,
                        $row->noti_date,
                        $row->noti_title,
                        $row->category->cat_name ?? '',
                        $row->updated_at,
                        Carbon::parse($row->updated_at)->format('Y-m-d')
                    ];
                })
                ->make('true');
    }
}
