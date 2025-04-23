<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KaryawanGalleryController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('karyawan.gallery.index', compact('products'));
    }

    public function create()
    {
        return view('karyawan.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'description' => 'nullable|string',
            'harga_jual' => 'required|numeric',
            'stock_product' => 'required|integer',
        ]);

        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $imageName = time() . '_' . Str::random(10) . '.' . $request->image->extension();
                $request->image->move(public_path('storage/images/products'), $imageName);
                
                Product::create($request->except('image') + [
                    'image' => 'images/products/' . $imageName
                ]);
    
                return redirect()->route('karyawan.gallery.index')->with('success', 'Gallery item created successfully.');
            }
            throw new \Exception('Invalid image file');
            
        } catch (\Exception $e) {
            return back()
                ->withErrors(['image' => $e->getMessage()])
                ->withInput();
        }

        
    }

    public function edit(Product $product)
    {
        return view('karyawan.gallery.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'description' => 'nullable|string',
            'harga_jual' => 'required|numeric',
            'stock_product' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                if ($product->image) {
                    $oldPath = public_path('storage/' . $product->image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
    
                $imageName = time() . '_' . Str::random(10) . '.' . $request->image->extension();
                
                $request->image->move(public_path('storage/images/products'), $imageName);
                
                $product->update($request->except('image') + [
                    'image' => 'images/products/' . $imageName
                ]);
            } else {
                $product->update($request->except('image'));
            }
    
            return redirect()->route('karyawan.gallery.index')->with('success', 'Gallery item updated successfully.');
            
        } catch (\Exception $e) {
            return back()
                ->withErrors(['image' => $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('karyawan.gallery.index')->with('success', 'Gallery item deleted successfully.');
    }
}
