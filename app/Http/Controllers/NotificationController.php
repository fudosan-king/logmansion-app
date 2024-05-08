<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotiCategory;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $notifications = Notification::where('noti_title', 'like', '%'.$search.'%')
        ->paginate(10);
        return view('notifications.index', compact('notifications', 'search'));
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
        ], [
            'required' => 'この項目は必須です。',
            'date' => '無効な形式です。',
        ]);
        $data['noti_status'] = $request->has('noti_status');
        $notification = Notification::create($data);
        toast('Notification created successfully.','success');
        return redirect()->route('notification');
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
            'noti_date' => 'required|date',
            'noti_status' => 'nullable',
            'noti_url' => 'nullable',
        ], [
            'required' => 'この項目は必須です。',
            'date' => '無効な形式です。',
        ]);
        $data['noti_status'] = $request->has('noti_status');
        $notification->update($data);

        toast('Notification updated successfully.','success');
        return redirect()->route('notification');
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
        toast('Notification deleted successfully.','success');
        return redirect()->route('notification');
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
        toast('Category created successfully.','success');
        return redirect()->route('topic');
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
        toast('Category updated successfully.','success');
        return redirect()->route('topic');
    }

    public function topicDestroy($id)
    {
        $category = NotiCategory::findOrFail($id);
        $category->delete();
        toast('Category deleted successfully.','success');
        return redirect()->route('topic');
    }
}
