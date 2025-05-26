<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgendaModel;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon; 

class AgendaController extends Controller
{
    public function index()
    {
        $gebruiker = Session::get('gebruiker'); //gebruiker uit sessie halen
        $tasks = AgendaModel::where('GebruikerId', $gebruiker->Id)
            ->orderBy('Datum', 'asc')
            ->get()
            ->groupBy('Datum'); // Groepeer taken op datum

        return view('agenda', ['tasks' => $tasks]);
    }

    public function save(Request $request)
    {
        
        $gebruiker = Session::get('gebruiker');

        //validatie
        $validatedData = $request->validate([
            'Titel' => 'required|string|max:255',
            'Omschrijving' => 'nullable|string',
            'Datum' => 'required|date', 
            'Type' => 'required|in:deadline,evenement,taak',
        ]);

        //check of datum juiste formaat is
        $datum = $validatedData['Datum'];

        //sla gegevens op
        AgendaModel::create([
            'GebruikerId' => $gebruiker->Id,
            'Titel' => $validatedData['Titel'],
            'Omschrijving' => $validatedData['Omschrijving'],
            'Datum' => $datum, 
            'Type' => $validatedData['Type'],
        ]);

        return redirect()->back()->with('success', 'Agenda-item succesvol opgeslagen!');
    }

        public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'Titel' => 'required|string|max:255',
            'Omschrijving' => 'nullable|string',
            'Datum' => 'required|date',
            'Type' => 'required|in:deadline,evenement,taak',
        ]);

        $task = AgendaModel::findOrFail($id);
        $task->update($validatedData);

        return redirect()->back()->with('success', 'Agenda-item succesvol bijgewerkt!');
    }

    public function delete($id)
    {
        $task = AgendaModel::findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'Agenda-item succesvol verwijderd!');
    }

}
