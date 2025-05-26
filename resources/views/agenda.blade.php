<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
    <link rel="stylesheet" href="{{ asset('css/agenda.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    @include('parts.nav')

    <div class="content">
        <div class="agenda-container">
            <div class="month-navigation">
                <button id="prev-month">←</button>
                <h2 id="current-month">Januari 2025</h2>
                <button id="next-month">→</button>
            </div>
            <div class="days-header">
                <div>Ma</div>
                <div>Di</div>
                <div>Wo</div>
                <div>Do</div>
                <div>Vr</div>
                <div>Za</div>
                <div>Zo</div>
            </div>
            <div class="days-grid" id="days-grid"></div>
        </div>
    </div>

    <div id="modal" class="modal hidden">
        <div class="modal-content">
            <button type="button" class="modal-close" id="close-modal-x">&times;</button>

            <h3 class="modal-title">Beheer een gebeurtenis</h3>

            <form id="agenda-form" action="{{ route('agenda.save') }}" method="POST">
                @csrf
                <input type="hidden" id="task-id" name="taskId">

                <label for="title">Titel:</label>
                <input type="text" id="title" name="Titel" required>

                <label for="description">Omschrijving:</label>
                <textarea id="description" name="Omschrijving" rows="3"></textarea>

                <label for="date">Datum:</label>
                <input type="date" id="date" name="Datum" required>

                <div class="types">
                    <label><input type="radio" name="Type" value="deadline" required> Deadline</label>
                    <label><input type="radio" name="Type" value="evenement"> Evenement</label>
                    <label><input type="radio" name="Type" value="taak"> Taak</label>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="gradient-btn">Opslaan</button>
                    <button type="button" id="close-modal" class="gradient-btn">Annuleren</button>
                    <button type="button" id="delete-task" class="delete-button hidden">Verwijderen</button>
                </div>
            </form>

            <ul id="task-list"></ul>
        </div>
    </div>

    <script id="tasks-data" type="application/json">
        @json($tasks)
    </script>

    @include('parts.footer')

    <script src="{{ asset('js/agenda.js') }}"></script>
</body>
</html>
