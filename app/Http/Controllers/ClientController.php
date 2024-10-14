<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        return view('client.index');
    }

    public function create()
    {
        return view('client.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        Client::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('client')->with('success', 'Client added successfully.');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        
        // return view('client.update', compact('client'));
        return response()->json(['client' => $client]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $client = Client::findOrFail($id);
        $client->update($request->only('name', 'email'));

        return redirect()->route('client')->with('success', 'Client updated successfully.');
    }

    public function destroy($id)
    {
        Client::findOrFail($id)->delete();

        return response()->json(['success' => 'Client deleted successfully']);
    }

    public function getData()
    {
        $clients = Client::where('user_id', Auth::id())->get();
        return DataTables::of($clients)
            ->addColumn('action', function ($client) {
                return '
                    <a href="'.route('client.edit', $client->id).'" class="btn btn-sm btn-primary">Update</a>
                    <button type="button" class="btn btn-sm btn-danger delete-client" data-id="'.$client->id.'">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);

    }
}
