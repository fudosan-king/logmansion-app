<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotiCategory;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();
        return view('notifications.index')->with('notifications', $notifications);
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
            'noti_url' => 'nullable',
        ]);
        $data['noti_status'] = $request->has('noti_status');
        // $d=strtotime($data['noti_date']. "00:00:00");
        // $data['noti_date'] =  date("Y-m-d h:i:s", $d);
        // $data['noti_date'] = str_replace('/','-',$data['noti_date']);
        $notification = Notification::create($data);
        return redirect()->route('notification')->with('success', 'Notification created successfully');
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

        // $data = $request->validate([
        //     'cat_id' => 'required',
        //     'noti_title' => 'required',
        //     'noti_content' => 'required',
        //     'noti_date' => 'required|date',
        //     'noti_status' => 'required|boolean',
        //     'noti_url' => 'nullable|url',
        // ]);
        $data = $request->validate([
            'cat_id' => 'required',
            'noti_title' => 'required',
            'noti_content' => 'nullable',
            'noti_date' => 'required|date',
            'noti_status' => 'nullable',
            'noti_url' => 'nullable',
        ]);
        $data['noti_status'] = $request->has('noti_status');
        $notification->update($data);

        return redirect()->route('notification')->with('success', 'Notification updated successfully');
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
        return redirect()->route('notification')->with('success', 'Notification deleted successfully');
    }

    public function topicIndex()
    {
        $categories = NotiCategory::all();
        return view('notifications.topic.index', compact('categories'));
    }

    public function topicCreate()
    {
        return view('notifications.topic.create');
    }

    public function topicStore(Request $request)
    {
        $data = $request->validate([
            'cat_name' => 'required',
        ]);
        $notification = NotiCategory::create($data);
        return redirect()->route('topic')->with('success', 'Category created successfully');
    }

    public function topicEdit($id)
    {
        $category = NotiCategory::findOrFail($id);
        return view('notifications.topic.edit', compact('category'));
    }

    public function topicUpdate(Request $request, $id)
    {
        $category = NotiCategory::findOrFail($id);
        $data = $request->validate([
            'cat_name' => 'required',
        ]);
        $category->update($data);

        return redirect()->route('topic')->with('success', 'Category updated successfully');
    }

    public function topicDestroy($id)
    {
        $category = NotiCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('topic')->with('success', 'Category deleted successfully');
    }
}
