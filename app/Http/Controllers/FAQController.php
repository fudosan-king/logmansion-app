<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FAQ;

class FAQController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $faqs = Faq::where('faq_title', 'like', '%'.$search.'%')
                    ->paginate(10);
        return view('faq.index', compact('faqs', 'search'));
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
        return redirect()->route('faq');
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
        return redirect()->route('faq');
    }

    public function destroy($id)
    {
        $faq = FAQ::findOrFail($id);
        $faq->delete();
        toast('FAQ deleted successfully.','success');
        return redirect()->route('faq');
    }
}
