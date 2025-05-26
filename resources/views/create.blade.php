<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuw Bord Aanmaken</title>
    <link rel="stylesheet" href="{{ asset('css/boards.css') }}">
</head>
<body>
    @include('parts.nav')

    <section class="create-board">
        <h1>Nieuw Board Aanmaken</h1>

        <form action="{{ route('boards.store') }}" method="POST">
            @csrf
            <label for="Titel">Titel:</label>
            <input type="text" id="Titel" name="Titel" placeholder="Bord Titel" required>

            <button type="submit" class="create-board-btn">Opslaan</button>
        </form>

        <a href="{{ route('boards.index') }}">
            <button class="back-to-boards-btn">Terug naar mijn borden</button>
        </a>
    </section>

    @include('parts.footer')
</body>
</html>
