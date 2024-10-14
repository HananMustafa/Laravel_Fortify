<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

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
        ]);

        Product::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
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
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->only('title', 'description'));

        return redirect()->route('product')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

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
