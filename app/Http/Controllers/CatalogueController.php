<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DataTables; 
use App\Models\Catalogue;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            return $this->getCatalogues();
        }
        return view('catalogue.index');
    }

    public function create()
    {
        return view('catalogue.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cata_title' => 'nullable|max:255',
            'cata_description' => 'nullable|string',
            'cata_image' => [
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
            // 'cata_url' => 'nullable|url|max:255',
            'cata_active' => 'boolean',
        ], [
            'required' => 'この項目は必須です。',
            'date' => '無効な形式です。',
            'image' => '無効な形式です。',  
            'cata_image.max' => '最大アップロードサイズ:' . config('upload.max_image_size') .' KB。',
            'boolean' => '無効な形式です。',
            'url' => '無効な形式です。',
            'max' => '最大255文字まで入力してください。',
        ]);

        // $imagePath = $request->file('cata_image')->store('catalogue', 'public');
        $imagePath = $this->storeUploadedFile($request->file('cata_image'));

        $catalogue = new Catalogue();
        $catalogue->cata_title = $request->input('cata_title');
        $catalogue->cata_description = $request->input('cata_description');
        $catalogue->cata_image = $imagePath;
        // $catalogue->cata_url = $request->input('cata_url');
        $catalogue->cata_active = $request->input('cata_active', false);

        $catalogMaxIndex = Catalogue::orderBy('cata_index', 'desc')->first();
        $catalogue->cata_index = ($catalogMaxIndex->cata_index ?? 0) + 1;
        $catalogue->save();
        toast(__('messages.catalogue').__('messages.created'),'success');
        return redirect()->route('catalogue.index');
    }

    public function edit($id)
    {
        $catalogue = Catalogue::findOrFail($id);
        return view('catalogue.edit', compact('catalogue'));
    }

    public function update(Request $request, $id)
    {
        $catalogue = Catalogue::findOrFail($id);

        $request->validate([
            'cata_title' => 'nullable|string|max:255',
            'cata_description' => 'nullable|string',
            'cata_image' => 'nullable|image|max:' . config('upload.max_image_size'),
            // 'cata_url' => 'nullable|url|max:255',
            'cata_active' => 'boolean',
        ], [
            'required' => 'この項目は必須です。',
            'date' => '無効な形式です。',
            'image' => '無効な形式です。',
            'cata_image.max' => '最大アップロードサイズ: ' . config('upload.max_image_size') .' KB。',
            'boolean' => '無効な形式です。',
            'url' => '無効な形式です。',
            'max' => '最大255文字まで入力してください。',
        ]);

        if ($request->hasFile('cata_image')) {
            $imagePath = $this->storeUploadedFile($request->file('cata_image'));
            if ($imagePath != null) {
                Storage::disk('public')->delete($catalogue->cata_image);
                $catalogue->cata_image = $imagePath;
            }
        }

        $catalogue->cata_title = $request->input('cata_title');
        $catalogue->cata_description = $request->input('cata_description');
        // $catalogue->cata_url = $request->input('cata_url');
        $catalogue->cata_active = $request->input('cata_active', false);
        $catalogue->save();
        toast(__('messages.catalogue').__('messages.edited'),'success');
        return redirect()->route('catalogue.index');
    }

    public function destroy($id)
    {
        try {
            $catalogue = Catalogue::findOrFail($id);
            Storage::disk('public')->delete($catalogue->cata_image);
            $catalogue->delete();
            return response(["message" => "Catalogue Deleted Successfully"], 200);
        } catch(exception $e) {
            return response(["message" => "Data Delete Error! Please Try again"], 201);
        }
    }

    private function getCatalogues()
    {
        $data = Catalogue::orderBy('cata_index', 'asc')->get();
        $maxIndex = $data->max('cata_index');
        $minIndex = $data->min('cata_index');
        return DataTables::of($data)
                ->addColumn('image', function($row){
                    $imageUrl = asset("storage/$row->cata_image");
                    return '<img src="' . $imageUrl . '" alt="' . $row->cata_title . '" style="height: 100px;">';
                })
                ->addColumn('updated_at', function($row){
                    return Carbon::parse($row->updated_at)->format('Y/m/d');
                })
                ->addColumn('active', function($row){
                    return $row->cata_active ? '表示' : '非表示';
                })
                ->addColumn('action', function($row){
                    $action = ""; 
                    if(Auth::user()->can('catalogue.edit'))
                    {
                        $action.="<a class='btn btn-xs btn-warning' id='btnEdit' href='".route('catalogue.edit', $row->cata_id)."'><i class='fas fa-edit'></i></a>"; 
                    }
                    if(Auth::user()->can('catalogue.destroy'))
                    {
                        $action.=" <button class='btn btn-xs btn-outline-danger' id='btnDel' data-id='".$row->cata_id."'><i class='fas fa-trash'></i></button>"; 
                    }
                    return $action;
                })
                ->addColumn('position', function($row) use ($maxIndex, $minIndex) {
                    $action = "";
                    if($row->cata_index != $minIndex){
                        $action .= '<a class="dtMoveUp" data-index="' . $row->cata_index . '" style="margin-right: 10px;"><i class="fas fa-arrow-up"></i></a>';
                    }
                    if($row->cata_index < $maxIndex){
                        $action .= '<a class="dtMoveDown" data-index="' . $row->cata_index . '"><i class="fas fa-arrow-down"></i></a>';
                    }
                    return $action;
                })
                ->rawColumns(['url', 'image','active', 'action','position'])
                ->addColumn('searchable', function ($row) {
                    return [
                        $row->cata_title,
                        $row->cata_url,
                    ];
                })
                ->make('true');
    }

    public function storeUploadedFile($file) {
        $originalName = $file->getClientOriginalName();
        $fileNameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
        $limitedFileName = mb_substr($fileNameWithoutExtension, 0, 50);
        $extension = $file->getClientOriginalExtension();
        $fileName = $limitedFileName . '_' . time() . '.' . $extension;
        $imagePath = $file->storeAs('catalogue', $fileName, 'public');
        try {
            $imagePath = $file->storeAs('catalogue', $fileName, 'public');
            return $imagePath;
        } catch (\Exception $e) {
            return null;
        }
    }

    function swapIndexUp($index)
    {
        $item1 = Catalogue::where("cata_index", $index)->first();
        $item2 = Catalogue::where('cata_index', '<', $index)->orderBy('cata_index', 'desc')->first();
        if ($item2)
        {
            $item1->cata_index = $item2->cata_index;
            $item2->cata_index = $index;
            $item1->save();  
            $item2->save();
        }
        return true;
    }

    function swapIndexDown($index)
    {
        $item1 = Catalogue::where("cata_index", $index)->first();
        $item2 = Catalogue::where('cata_index', '>', $index)->orderBy('cata_index', 'asc')->first();
        if ($item2)
        {
            $item1->cata_index = $item2->cata_index;
            $item2->cata_index = $index;
            $item1->save();
            $item2->save();
        }
        return true;
    }
}
