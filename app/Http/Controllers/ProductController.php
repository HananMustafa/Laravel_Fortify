<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(){
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
            'image' => 'nullable|mimes:png,jpg,jpeg,webp'
        ]);

        $path=null;
        $filename=null;
        if($request->has('image')){

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/products/';
            $file->move($path,$filename);
        }

        Product::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path.$filename
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
            'image' => 'nullable|mimes:png,jpg,jpeg,webp'
        ]);

        $product = Product::findOrFail($id);

        if($request->has('image')){

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/products/';
            $file->move($path,$filename);

            if(File::exists($product->image)){
                File::delete($product->image);
            }
        }

        $product->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $path . $filename
        ]);


        return redirect()->route('product')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if(File::exists($product->image)){
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
                    <a href="'.route('product.edit', $product->id).'" class="btn btn-sm btn-primary">Update</a>
                    <button type="button" class="btn btn-sm btn-danger delete-product" data-id="'.$product->id.'">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
