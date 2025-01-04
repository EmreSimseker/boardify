<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boardify</title>
    <link rel="stylesheet" href="{{ asset('css/boards.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    
    @include('parts.nav')

    <section class="board">
        <div class="list" id="todo">
            <div class="list-header">
                <h3>To Do</h3>
                <button class="delete-list-btn" onclick="deleteList('todo')">×</button>
            </div>
            <div class="task" draggable="true" onclick="openTaskModal(this)">Taak 1</div>
            <button class="add-task-btn" onclick="addTask('todo')">+ Voeg taak toe</button>
        </div>

        <button class="add-list-btn" onclick="addList()">+ Voeg lijst toe</button>
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

    <script src="{{ asset('js/boards.js') }}"></script>
</body>
</html>
