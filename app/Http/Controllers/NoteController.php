<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    // Display notes for a client
    public function index($clientId)
    {
        $client = Client::findOrFail($clientId);
        $notes = $client->notes;

        return view('note.index', compact('client', 'notes'));
    }

    // Store a new note
    public function store(Request $request, $clientId)
    {
        $request->validate([
            'content' => 'required',
        ]);

        Note::create([
            'client_id' => $clientId,
            'content' => $request['content'],
        ]);

        return redirect()->route('notes.index', $clientId)->with('success', 'Note added successfully.');
    }

    // Edit a note
    public function edit($clientId, $id)
    {
        $note = Note::where('client_id', $clientId)->findOrFail($id);
        return view('note.edit', compact('note'));
    }

    // Update a note
    public function update(Request $request, $clientId, $id)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $note = Note::where('client_id', $clientId)->findOrFail($id);
        $note->update(['content' => $request['content'],]);

        return redirect()->route('notes.index', $clientId)->with('success', 'Note updated successfully.');
    }

    // Delete a note
    public function destroy($clientId, $id)
    {
        $note = Note::where('client_id', $clientId)->findOrFail($id);
        $note->delete();

        return redirect()->route('notes.index', $clientId)->with('success', 'Note deleted successfully.');
    }
}
