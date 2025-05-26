<?php

namespace App\Http\Controllers;

use App\Models\BoardModel;
use App\Models\TaskModel;
use App\Models\ListModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class BoardController extends Controller
{
    public function index()
    {
        $gebruiker = Session::get('gebruiker');

        //controleer of gebruiker is ingelogc
        if (!$gebruiker) {
            return redirect()->route('login'); //als je niet ingelogd bent, wordt je gestuurd naar login.
        }

        //haalt de borden op van gebruiker
        $boards = BoardModel::where('GebruikerId', $gebruiker->Id)
            ->orderBy('AangemaaktOp', 'desc')
            ->get();

        
        return view('boards', ['boards' => $boards]);
    }
    

        public function create()
    {
        //toon formulier om een bord aan te maken
        return view('create');
    }

        public function store(Request $request)
    {
        $gebruiker = Session::get('gebruiker');

        $validatedData = $request->validate([
            'Titel' => 'required|string|max:255',
        ]);

        //maakt een slug
        $slug = Str::slug($validatedData['Titel']);
        $slugCount = BoardModel::where('Slug', 'like', "$slug%")->count();
        if ($slugCount > 0) {
            $slug .= '-' . ($slugCount + 1);
        }

        //Maak een nieuw board aan 
        BoardModel::create([
            'Titel' => $validatedData['Titel'],
            'Slug' => $slug,
            'GebruikerId' => $gebruiker->Id,
        ]);

        return redirect()->route('boards.index')->with('success', 'Board succesvol aangemaakt!');
    }


        public function show($slug)
    {
        $gebruiker = Session::get('gebruiker');

        //Haal het board op basis van Slug
        $board = BoardModel::where('Slug', $slug)
            ->where('GebruikerId', $gebruiker->Id)
            ->firstOrFail();

        return view('board-details', ['board' => $board]);
    }

        public function addList(Request $request, $slug)
    {
        $gebruiker = Session::get('gebruiker');
        $board = BoardModel::where('Slug', $slug)
            ->where('GebruikerId', $gebruiker->Id)
            ->firstOrFail(); // Haal het board op

        $validatedData = $request->validate([
            'Titel' => 'required|string|max:255',
        ]);

        // Maak een nieuwe lijst aan binnen het board
        $board->lists()->create([
            'Titel' => $validatedData['Titel'],
        ]);

        return redirect()->route('boards.show', $slug)->with('success', 'Lijst succesvol toegevoegd!');
    }

        public function deleteList($slug, $listId)
    {
        $gebruiker = Session::get('gebruiker');
        $board = BoardModel::where('Slug', $slug)
            ->where('GebruikerId', $gebruiker->Id)
            ->firstOrFail();

        $list = $board->lists()->findOrFail($listId);
        $list->delete();

        return redirect()->route('boards.show', $slug)->with('success', 'Lijst succesvol verwijderd!');
    }

    public function addTask(Request $request, $slug, $listId)
    {
        // Haal het board op basis van slug
        $board = BoardModel::where('Slug', $slug)->firstOrFail();
    
        // Zoek de lijst op basis van listId
        $list = $board->lists()->findOrFail($listId);
    
        // Valideer de gegevens van de taak
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
        ]);
    
        // Maak de taak aan en koppel deze aan de lijst
        $task = new TaskModel();
        $task->LijstId = $listId;
        $task->Titel = $validatedData['title'];
        $task->Omschrijving = '';  // Initialiseer de omschrijving als een lege string
        $task->Status = 'open';
        $task->AangemaaktOp = now();
        $task->save();  // Sla de taak op in de database
    
        return response()->json([
            'message' => 'Taak succesvol toegevoegd!',
            'task' => $task
        ]);
    }
    

    public function deleteTask($slug, $taskId)
    {
        $gebruiker = Session::get('gebruiker');
    
        // Haal het board op basis van de slug en gebruiker
        $board = BoardModel::where('Slug', $slug)
            ->where('GebruikerId', $gebruiker->Id)
            ->firstOrFail();
    
        // Zoek de taak op en verwijder deze
        $task = TaskModel::findOrFail($taskId);
        $task->delete();
    
        return redirect()->route('boards.show', $slug)->with('success', 'Taak succesvol verwijderd!');
    }
    
        public function updateTaskDescription(Request $request, $slug, $taskId)
        {
            $gebruiker = Session::get('gebruiker');
            
            // Haal het board op basis van de slug en gebruiker
            $board = BoardModel::where('Slug', $slug)
                ->where('GebruikerId', $gebruiker->Id)
                ->firstOrFail();
            
            // Zoek de taak op en werk de beschrijving bij
            $task = TaskModel::findOrFail($taskId);
            $task->Omschrijving = $request->input('description');
            
            if (!$task->save()) {
                return response()->json(['error' => 'Er is een fout opgetreden bij het opslaan van de omschrijving.'], 500);
            }
        
            return response()->json(['message' => 'Taakbeschrijving succesvol bijgewerkt!']);
        }

            public function getTaskDetails($slug, $taskId)
    {
        $gebruiker = Session::get('gebruiker');

        // Haal het board op basis van de slug
        $board = BoardModel::where('Slug', $slug)
            ->where('GebruikerId', $gebruiker->Id)
            ->firstOrFail();

        // Zoek de taak op en geef de details terug
        $task = TaskModel::findOrFail($taskId);

        return response()->json([
            'task' => $task
        ]);
    }

    
    public function delete($slug)
{
    $gebruiker = Session::get('gebruiker');

    // Zoek het board op basis van slug en gebruiker
    $board = BoardModel::where('Slug', $slug)
        ->where('GebruikerId', $gebruiker->Id)
        ->firstOrFail();

    // Verwijder het board
    $board->delete();

    return redirect()->route('boards.index')->with('success', 'Board succesvol verwijderd!');
}

  
}
