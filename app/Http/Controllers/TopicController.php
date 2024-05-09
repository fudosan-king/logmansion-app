<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DataTables; 
use App\Models\NotiCategory;
use App\Models\Notification;

class TopicController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            return $this->getTopics();
        }
        return view('notifications.topic.index');
    }

    public function create()
    {
        return view('notifications.topic.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cat_name' => 'required',
        ]);
        $notification = NotiCategory::create($data);
        toast('Category created successfully.','success');
        return redirect()->route('topic.index');
    }

    public function edit($id)
    {
        $category = NotiCategory::findOrFail($id);
        return view('notifications.topic.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = NotiCategory::findOrFail($id);
        $data = $request->validate([
            'cat_name' => 'required',
        ]);
        $category->update($data);
        toast('Category updated successfully.','success');
        return redirect()->route('topic.index');
    }

    public function destroy($id)
    {
        try {
            $category = NotiCategory::findOrFail($id);
            $count = Notification::where('cat_id', $id)->count();
            if($count > 0)
            {
                return response(["message" => "This category cannot currently be deleted!"], 403);
            }
            $category->delete();    
            return response(["message" => "Category Deleted Successfully"], 200);
        } catch(exception $e) {
            return response(["error" => "Data Delete Error! Please Try again"], 201);
        }
    }

    private function getTopics()
    {
        $data = NotiCategory::all();
        return DataTables::of($data)
                ->addColumn('updated_at', function($row){
                    return Carbon::parse($row->updated_at)->format('Y/m/d');
                })
                ->addColumn('action', function($row){
                    $action = ""; 
                    if(Auth::user()->can('topic.edit'))
                    {
                        $action.="<a class='btn btn-xs btn-warning' id='btnEdit' href='".route('topic.edit', $row->cat_id)."'><i class='fas fa-edit'></i></a>"; 
                    }
                    if(Auth::user()->can('topic.destroy'))
                    {
                        $action.=" <button class='btn btn-xs btn-outline-danger' id='btnDel' data-id='".$row->cat_id."'><i class='fas fa-trash'></i></button>"; 
                    }
                    return $action;
                })
                ->rawColumns(['url', 'image','active', 'action'])->make('true');
    }
}
