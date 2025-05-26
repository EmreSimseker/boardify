<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    @include('parts.nav')

    <div class="form-container">
        @if(session('succes'))
            <div class="alert alert-success">{{ session('succes') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if($step == 'register')
            <form class="form" method="POST" action="{{ url('/register') }}">
                @csrf
                <h1>Registreren</h1>

                <div class="input-group name-group">
                    <div class="name-input">
                        <label for="voornaam">Voornaam</label>
                        <input type="text" id="voornaam" name="voornaam" value="{{ old('voornaam') }}" required>
                    </div>

                    <div class="name-input">
                        <label for="achternaam">Achternaam</label>
                        <input type="text" id="achternaam" name="achternaam" value="{{ old('achternaam') }}" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="email">E-mailadres</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="input-group">
                    <label for="wachtwoord">Wachtwoord</label>
                    <input type="password" id="wachtwoord" name="wachtwoord" required>
                </div>

                <div class="input-group">
                    <label for="wachtwoord_confirmation">Herhaal Wachtwoord</label>
                    <input type="password" id="wachtwoord_confirmation" name="wachtwoord_confirmation" required>
                </div>
                <p class="form-link">Heb je al een account? <a href="{{ route('login') }}">Log hier in</a></p>
                <button type="submit" class="form-button">Registreren</button>
            </form>
        @elseif($step == 'verify')
            <h3 class="text-center mt-5">Verificatiecode</h3>
            <form action="{{ url('/register/verify') }}" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" id="verificationCode" name="verificationCode" class="form-control rounded-0" placeholder="Verificatiecode" required maxlength="6">
                    <label for="verificationCode">Verificatiecode</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Verstuur</button>
            </form>

            <form action="{{ url('/register/reset') }}" method="POST" style="margin-top: 10px;">
                @csrf
                <button type="submit" class="btn btn-secondary w-100">Begin opnieuw</button>
            </form>
        @endif
    </div>



    <footer>
        &copy; 2024 Boardify. Alle rechten voorbehouden.
    </footer>

    <script>
        // Modal functionaliteit
        const modal = document.getElementById("modal");
        const openModal = () => modal.style.display = "block";
        const closeModal = () => modal.style.display = "none";

        // Controleer of de modal zichtbaar moet zijn
        window.onload = () => {
            if (window.location.href.indexOf("register") !== -1) {
                openModal();
            }
        };
    </script>
</body>
</html>
