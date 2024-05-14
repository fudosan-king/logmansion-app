<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DataTables; 
use App\Models\Faq;

class FAQController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            return $this->getFAQs();
        }
        return view('faq.index');
    }

    public function create()
    {
        return view('faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'faq_title' => 'required',
            'faq_content' => 'required',
            'faq_active' => 'boolean',
        ], [
            'required' => 'この項目は必須です。',
        ]);

        $faq = new FAQ();
        $faq->faq_title = $request->input('faq_title');
        $faq->faq_content = $request->input('faq_content');
        $faq->faq_active = $request->input('faq_active', false);
        $faq->save();
        toast('FAQ created successfully.','success');
        return redirect()->route('faq.index');
    }

    public function edit($id)
    {
        $faq = FAQ::findOrFail($id);
        return view('faq.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $faq = FAQ::findOrFail($id);

        $request->validate([
            'faq_title' => 'required',
            'faq_content' => 'required',
            'faq_active' => 'boolean',
        ], [
            'required' => 'この項目は必須です。',
        ]);

        $faq->faq_title = $request->input('faq_title');
        $faq->faq_content = $request->input('faq_content');
        $faq->faq_active = $request->input('faq_active', false);
        $faq->save();
        toast('FAQ updated successfully.','success');
        return redirect()->route('faq.index');
    }

    public function destroy($id)
    {
        try {
            $faq = FAQ::findOrFail($id);
            $faq->delete();
            return response(["message" => "Deleted Successfully"], 200);
        } catch(exception $e) {
            return response(["message" => "Data Delete Error! Please Try again"], 201);
        }
    }

    private function getFAQs()
    {
        $data = FAQ::all();
        return DataTables::of($data)
                ->addColumn('active', function($row){
                    return $row->faq_active ? '表示' : '非表示';
                })
                ->addColumn('action', function($row){
                    $action = ""; 
                    if(Auth::user()->can('faq.edit'))
                    {
                        $action.="<a class='btn btn-xs btn-warning' id='btnEdit' href='".route('faq.edit', $row->faq_id)."'><i class='fas fa-edit'></i></a>"; 
                    }
                    if(Auth::user()->can('faq.destroy'))
                    {
                        $action.=" <button class='btn btn-xs btn-outline-danger' id='btnDel' data-id='".$row->faq_id."'><i class='fas fa-trash'></i></button>"; 
                    }
                    return $action;
                })
                ->rawColumns(['active', 'action'])
                ->addColumn('searchable', function ($row) {
                    return [
                        $row->faq_id,
                        $row->faq_title,
                    ];
                })
                ->make('true');
    }
}
