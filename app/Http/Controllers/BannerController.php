<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('banner.index', compact('banners'));
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
            'banner_image' => 'required|image|max:2048',
            'banner_url' => 'nullable|url',
            'banner_active' => 'boolean',
        ], [
            'required' => 'この項目は必須です。',
            'date' => '無効な形式です。',
            'image' => '無効な形式です。',
            'max' => '無効な形式です。',
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

        return redirect()->route('banner')->with('success', 'Banner created successfully');
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
            'banner_image' => 'nullable|image|max:2048',
            'banner_url' => 'nullable|url',
            'banner_active' => 'boolean',
        ], [
            'required' => 'この項目は必須です。',
            'date' => '無効な形式です。',
            'image' => '無効な形式です。',
            'max' => '無効な形式です。',
            'boolean' => '無効な形式です。',
            'url' => '無効な形式です。',
        ]);

        if ($request->hasFile('banner_image')) {
            $imagePath = $request->file('banner_image')->store('banner', 'public');
            $banner->banner_image = $imagePath;
        }

        $banner->banner_title = $request->input('banner_title');
        $banner->banner_description = $request->input('banner_description');
        $banner->banner_url = $request->input('banner_url');
        $banner->banner_active = $request->input('banner_active', false);
        $banner->save();

        return redirect()->route('banner')->with('success', 'Banner updated successfully');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return redirect()->route('banner')->with('success', 'Banner deleted successfully');
    }
}
