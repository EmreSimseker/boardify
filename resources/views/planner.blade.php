<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekplanning</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/planner.css') }}">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .week-planner-wrapper {
            flex: 1;
        }
        footer.footer-wrapper {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem;
            position: sticky;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="nav-wrapper">
        @include('parts.nav')
    </div>

    <div class="week-planner-wrapper">
        <div class="week-header">
            <button class="week-nav-button" id="prev-week">Vorige week</button>
            <h2 id="week-label">1 januari - 7 januari</h2>
            <button class="week-nav-button" id="next-week">Volgende week</button>
        </div>

        <div class="week-grid">
            <div class="time-slot"></div>
            <div class="week-day">Maandag</div>
            <div class="week-day">Dinsdag</div>
            <div class="week-day">Woensdag</div>
            <div class="week-day">Donderdag</div>
            <div class="week-day">Vrijdag</div>
            <div class="week-day weekend">Zaterdag</div>
            <div class="week-day weekend">Zondag</div>

            <div class="time-slot">08:00</div>
            <div class="task-tile" data-day="maandag"></div>
            <div class="task-tile" data-day="dinsdag"></div>
            <div class="task-tile" data-day="woensdag"></div>
            <div class="task-tile" data-day="donderdag"></div>
            <div class="task-tile" data-day="vrijdag"></div>
            <div class="task-tile weekend" data-day="zaterdag"></div>
            <div class="task-tile weekend" data-day="zondag"></div>

            <div class="time-slot">09:00</div>
            <div class="task-tile" data-day="maandag"></div>
            <div class="task-tile" data-day="dinsdag"></div>
            <div class="task-tile" data-day="woensdag"></div>
            <div class="task-tile" data-day="donderdag"></div>
            <div class="task-tile" data-day="vrijdag"></div>
            <div class="task-tile weekend" data-day="zaterdag"></div>
            <div class="task-tile weekend" data-day="zondag"></div>

            <div class="time-slot">10:00</div>
            <div class="task-tile" data-day="maandag"></div>
            <div class="task-tile" data-day="dinsdag"></div>
            <div class="task-tile" data-day="woensdag"></div>
            <div class="task-tile" data-day="donderdag"></div>
            <div class="task-tile" data-day="vrijdag"></div>
            <div class="task-tile weekend" data-day="zaterdag"></div>
            <div class="task-tile weekend" data-day="zondag"></div>
        </div>
    </div>

    <footer class="footer-wrapper">
        @include('parts.footer')
    </footer>

    <script src="{{ asset('js/planner.js') }}"></script>
</body>
</html>
