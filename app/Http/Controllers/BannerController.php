<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use DataTables; 
use App\Models\Banner;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        // $banners = Banner::all();
        // return view('banner.index', compact('banners'));
        if($request->ajax())
        {
            return $this->getBanners();
        }
        return view('banner.index');
    }

    public function create()
    {
        return view('banner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'banner_title' => 'nullable|string',
            'banner_description' => 'nullable|string',
            'banner_image' => [
                'required',
                'image',
                // 'dimensions:max_width=1200,max_height=600',
                // function ($attribute, $value, $fail) {
                //     [$width, $height] = getimagesize($value);
        
                //     if ($width / $height < 4/3 || $width / $height  > 3/2) {
                //         $fail('Kích thước hình ảnh không hợp lệ. Chiều rộng phải nhỏ hơn chiều cao và tỷ lệ phải tương đương 3:2.');
                //     }
                // },
                'max:' . config('upload.max_image_size'),
            ],
            'banner_url' => 'nullable|url',
            'banner_active' => 'boolean',
        ], [
            'required' => 'この項目は必須です。',
            'date' => '無効な形式です。',
            'image' => '無効な形式です。',  
            'max' => '最大アップロードサイズ:' . config('upload.max_image_size') .' KB。',
            'boolean' => '無効な形式です。',
            'url' => '無効な形式です。',
        ]);

        $imagePath = $request->file('banner_image')->store('banner', 'public');

        $banner = new Banner();
        $banner->banner_title = $request->input('banner_title');
        $banner->banner_description = $request->input('banner_description');
        $banner->banner_image = $imagePath;
        $banner->banner_url = $request->input('banner_url');
        $banner->banner_active = $request->input('banner_active', false);
        $banner->save();
        toast('Banner created successfully.','success');
        return redirect()->route('banner.index');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'banner_title' => 'nullable|string',
            'banner_description' => 'nullable|string',
            'banner_image' => 'nullable|image|max:' . config('upload.max_image_size'),
            'banner_url' => 'nullable|url',
            'banner_active' => 'boolean',
        ], [
            'required' => 'この項目は必須です。',
            'date' => '無効な形式です。',
            'image' => '無効な形式です。',
            'max' => '最大アップロードサイズ: ' . config('upload.max_image_size') .' KB。',
            'boolean' => '無効な形式です。',
            'url' => '無効な形式です。',
        ]);

        if ($request->hasFile('banner_image')) {
            $imagePath = $request->file('banner_image')->store('banner', 'public');
            Storage::disk('public')->delete($banner->banner_image);
            $banner->banner_image = $imagePath;
        }

        $banner->banner_title = $request->input('banner_title');
        $banner->banner_description = $request->input('banner_description');
        $banner->banner_url = $request->input('banner_url');
        $banner->banner_active = $request->input('banner_active', false);
        $banner->save();
        toast('Banner updated successfully.','success');
        return redirect()->route('banner.index');
    }

    public function destroy($id)
    {
        try {
            $banner = Banner::findOrFail($id);
            $banner->delete();
            return response(["message" => "Banner Deleted Successfully"], 200);
        } catch(exception $e) {
            return response(["message" => "Data Delete Error! Please Try again"], 201);
        }
    }

    private function getBanners()
    {
        $data = Banner::all();
        return DataTables::of($data)
                ->addColumn('url', function($row){
                    return "<a href=" . $row->banner_url . ">" . $row->banner_url . "</a>";
                })
                ->addColumn('image', function($row){
                    $imageUrl = asset("storage/$row->banner_image");
                    return '<img src="' . $imageUrl . '" alt="123" style="height: 100px;">';
                })
                ->addColumn('active', function($row){
                    return $row->banner_active ? '表示' : '非表示';
                })
                ->addColumn('action', function($row){
                    $action = ""; 
                    if(Auth::user()->can('banner.edit'))
                    {
                        $action.="<a class='btn btn-xs btn-warning' id='btnEdit' href='".route('banner.edit', $row->banner_id)."'><i class='fas fa-edit'></i></a>"; 
                    }
                    if(Auth::user()->can('banner.destroy'))
                    {
                        $action.=" <button class='btn btn-xs btn-outline-danger' id='btnDel' data-id='".$row->banner_id."'><i class='fas fa-trash'></i></button>"; 
                    }
                    return $action;
                })
                ->rawColumns(['url', 'image','active', 'action'])->make('true');
    }
}
