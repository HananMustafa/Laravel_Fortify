<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index');
    }

    public function create()
    {
        return view('product.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp',
            'video' => 'nullable|mimes:mp4,avi,mov|max:102400', //max 100MB
            'link' => 'nullable',
        ]);

        $imagePath = null;
        $videoPath = null;
        $imageFilename = null;
        $videoFilename = null;

        if ($request->has('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $imageFilename = time() . '.' . $extension;
            $imagePath = 'uploads/products/';
            $file->move($imagePath, $imageFilename);
        }

        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $extension = $file->getClientOriginalExtension();
            $videoFilename = time() . '.' . $extension;
            $videoPath = 'uploads/products/videos/';
            $file->move($videoPath, $videoFilename);
        }

        Product::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath . $imageFilename,
            'video' => $videoPath . $videoFilename,
            'link' => $request->link
        ]);

        return redirect()->route('product')->with('success', 'Product added successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        // return view('product.update', compact('product'));
        return response()->json(['product' => $product]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp',
            'video' => 'nullable|mimes:mp4,avi,mov|max:102400' //max 100MB
        ]);

        $product = Product::findOrFail($id);

        $imagePath = null;
        $videoPath = null;
        $imageFilename = null;
        $videoFilename = null;

        if ($request->has('image')) {

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $imageFilename = time() . '.' . $extension;
            $imagePath = 'uploads/products/';
            $file->move($imagePath, $imageFilename);

            if (File::exists($product->image)) {
                File::delete($product->image);
            }
        }



        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $extension = $file->getClientOriginalExtension();
            $videoFilename = time() . '.' . $extension;
            $videoPath = 'uploads/products/videos/';
            $file->move($videoPath, $videoFilename);

            if (File::exists($product->video)) {
                File::delete($product->video);
            }
        }



        $product->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $imagePath . $imageFilename,
            'video' => $videoPath . $videoFilename
        ]);


        return redirect()->route('product')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (File::exists($product->image)) {
            File::delete($product->image);
        }

        $product->delete();

        return response()->json(['success' => 'Product deleted successfully']);
    }

    public function getData()
    {
        $products = Product::where('user_id', Auth::id())->get();
        return DataTables::of($products)
            ->addColumn('action', function ($product) {
                return '
                    <a href="' . route('product.edit', $product->id) . '" class="btn btn-sm btn-primary">Update</a>
                    <button type="button" class="btn btn-sm btn-danger delete-product" data-id="' . $product->id . '">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
