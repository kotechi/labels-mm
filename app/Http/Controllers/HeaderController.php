<?php

namespace App\Http\Controllers;

use App\Models\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HeaderController extends Controller
{
    public function index()
    {
        $headers = Header::all();
        return view('admin.header.header', compact('headers'));
    }

    public function create()
    {
        return view('admin.header.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tittle' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $imageName = time() . '_' . Str::random(10) . '.' . $request->image->extension();
                $request->image->move(public_path('storage/images/headers'), $imageName);

                Header::create($request->except('image') + [
                    'image' => 'images/headers/' . $imageName
                ]);

                return redirect()->route('headers.header')->with('success', 'Header created successfully');
            }

            throw new \Exception('Invalid image file');

        } catch (\Exception $e) {
            return back()
                ->withErrors(['image' => $e->getMessage()])
                ->withInput();
        }
    }

    public function edit(Header $header)
    {
        return view('admin.header.edit', compact('header'));
    }

    public function update(Request $request, Header $header)
    {
        $request->validate([
            'tittle' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                if ($header->image) {
                    $oldPath = public_path('storage/' . $header->image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $imageName = time() . '_' . Str::random(10) . '.' . $request->image->extension();
                $request->image->move(public_path('storage/images/headers'), $imageName);

                $header->update($request->except('image') + [
                    'image' => 'images/headers/' . $imageName
                ]);
            } else {
                $header->update($request->except('image'));
            }

            return redirect()->route('headers.header')->with('success', 'Header updated successfully');

        } catch (\Exception $e) {
            return back()
                ->withErrors(['image' => $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(Header $header)
    {
        try {
            if ($header->image) {
                Storage::disk('public')->delete($header->image);
            }

            $header->delete();
            return redirect()->route('headers.header')->with('success', 'Header deleted successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete header']);
        }
    }
}
