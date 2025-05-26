<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>{{ $board->Titel }}</title>
    <link rel="stylesheet" href="{{ asset('css/boards.css') }}">
</head>
<body>
    @include('parts.nav')

    <section class="board">
        <div class="board-header">
            <h1>{{ $board->Titel }}</h1>
        </div>
        <div class="board-lists">
            @foreach ($board->lists as $list)
                <div class="list" id="list-{{ $list->Id }}">
                    <div class="list-header">
                        <h3>{{ $list->Titel }}</h3>
                        <form action="{{ route('boards.deleteList', [$board->Slug, $list->Id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-list-btn">×</button>
                        </form>
                    </div>

                    <div class="tasks">
                        @foreach ($list->tasks as $task)
                            <div class="task" data-id="{{ $task->Id }}">
                                {{ $task->Titel }}
                                <button class="delete-task-btn" onclick="deleteTask({{ $task->Id }})">×</button>
                            </div>                     
                        @endforeach
                    </div>

                    <button class="add-task-btn" onclick="addTask({{ $list->Id }})">+ Voeg taak toe</button>
                </div>
            @endforeach
        </div>

        <form action="{{ route('boards.addList', $board->Slug) }}" method="POST">
            @csrf
            <div class="add-list-btn-container">
                <input type="text" name="Titel" placeholder="Voer de lijstnaam in" required>
                <button type="submit" class="add-list-btn">Voeg lijst toe</button>
            </div>
        </form>
    </section>

    <div class="task-modal" id="taskModal">
        <div class="task-modal-content">
            <span class="close-modal" onclick="closeTaskModal()">×</span>
            <h3 id="taskTitle">Taak Titel</h3>
            <textarea id="taskDescription" placeholder="Beschrijving toevoegen..."></textarea>
            <button class="save-description-btn" onclick="saveTaskDescription()">Opslaan</button>
        </div>
    </div>
    
    @include('parts.footer')

    <script>
        var boardSlug = "{{ $board->Slug }}";
    </script>
    
    <script src="{{ asset('js/boards.js') }}"></script>
</body>
</html>
