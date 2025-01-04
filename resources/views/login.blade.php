<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    @include('parts.nav')

    <div class="form-container">
        <form class="form" method="POST" action="{{ url('/login') }}">
            @csrf
            <h1>Inloggen</h1>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="input-group">
                <label for="email">E-mailadres</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="input-group">
                <label for="password">Wachtwoord</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="form-button">Inloggen</button>

            <p class="form-link">Heb je geen account? <a href="{{ route('register') }}">Registreer hier</a></p>
        </form>
    </div>

    <footer>
        &copy; 2024 Boardify. Alle rechten voorbehouden.
    </footer>
</body>
</html>
