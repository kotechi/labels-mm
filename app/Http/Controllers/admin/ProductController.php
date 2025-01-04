<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;  
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index() {
        $product = Product::all();
        return view('admin.product.product', [
            'products' => $product,
        ]);
    }

    public function create() {
        return view('admin.product.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required',
            'link' => 'required',
            'deskripsi' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Generate nama file yang unik
                $imageName = time() . '_' . Str::random(10) . '.' . $request->image->extension();
                
                // Simpan file ke storage dan dapatkan pathnya
                $request->image->move(public_path('storage/images/products'), $imageName);
                
                // Buat product baru dengan path gambar
                Product::create($request->except('image') + [
                    'image' => 'images/products/' . $imageName
                ]);
    
                return redirect()->route('products')->with('success', 'Product created successfully');
            }
            
            throw new \Exception('Invalid image file');
            
        } catch (\Exception $e) {
            return back()
                ->withErrors(['image' => $e->getMessage()])
                ->withInput();
        }
    }

    public function edit(Product $product) {
        return view('admin.product.edit', compact('product'));
    }
    
    public function update(Request $request, Product $product) {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required',
            'link' => 'required',
            'deskripsi' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Hapus gambar lama
                if ($product->image) {
                    $oldPath = public_path('storage/' . $product->image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
    
                // Generate nama file yang unik
                $imageName = time() . '_' . Str::random(10) . '.' . $request->image->extension();
                
                // Simpan file baru
                $request->image->move(public_path('storage/images/products'), $imageName);
                
                // Update product dengan path gambar baru
                $product->update($request->except('image') + [
                    'image' => 'images/products/' . $imageName
                ]);
            } else {
                $product->update($request->except('image'));
            }
    
            return redirect()->route('products')->with('success', 'Product updated successfully');
            
        } catch (\Exception $e) {
            return back()
                ->withErrors(['image' => $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(Product $product) {
        try {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $product->delete();
            return redirect()->route('products')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete product']);
        }
    }
}