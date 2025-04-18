<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AboutController extends Controller
{
    public function index()
    {
        $abouts = About::all();
        return view('admin.about.index', compact('abouts'));
    }

    public function create()
    {
        return view('admin.about.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tittle' => 'required',
            'deskripsi' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Generate unique file name
                $imageName = time() . '_' . Str::random(10) . '.' . $request->image->extension();
                
                // Store file in storage and get the path
                $request->image->move(public_path('storage/images/abouts'), $imageName);
                
                // Create new about with image path
                About::create($request->except('image') + [
                    'image' => 'images/abouts/' . $imageName,
                    'deskripsi' => $request->deskripsi
                ]);

                return redirect()->route('admin.company.index')->with('success', 'About created successfully');
            }
            
            throw new \Exception('Invalid image file');
            
        } catch (\Exception $e) {
            return back()
                ->withErrors(['image' => $e->getMessage()])
                ->withInput();
        }
    }

    public function edit(About $about)
    {
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request, About $about)
    {
        $request->validate([
            'tittle' => 'required',
            'deskripsi' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Delete old image
                if ($about->image) {
                    $oldPath = public_path('storage/' . $about->image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                // Generate unique file name
                $imageName = time() . '_' . Str::random(10) . '.' . $request->image->extension();
                
                // Store new file
                $request->image->move(public_path('storage/images/abouts'), $imageName);
                
                // Update about with new image path
                $about->update($request->except('image') + [
                    'image' => 'images/abouts/' . $imageName,
                    'deskripsi' => $request->deskripsi
                ]);
            } else {
                $about->update($request->except('image') + [
                    'deskripsi' => $request->deskripsi
                ]);
            }

            return redirect()->route('admin.company.index')->with('success', 'About updated successfully');
            
        } catch (\Exception $e) {
            return back()
                ->withErrors(['image' => $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(About $about)
    {
        try {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            
            $about->delete();
            return redirect()->route('admin.company.index')->with('success', 'About deleted successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete about']);
        }
    }
}
