<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welkom bij Boardify</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
    @include('parts.nav') 

    <section class="hero">
        <div class="hero-content">
            <h1>Beheer je taken visueel met Boardify</h1>
            <p>Creëer borden, organiseer lijsten en taken, en werk samen met je team – allemaal op één plek.</p>
            <div class="cta-buttons">
                <a href="/register" class="cta-primary">Aan de slag</a>
                <a href="/login" class="cta-secondary">Inloggen</a>
            </div>
        </div>
        <div class="hero-image">
            <img src="{{ asset('images/hero-image.png') }}" alt="Visualisatie van Boardify">
        </div>
    </section>

    <section class="features">
        <h2>Waarom kiezen voor Boardify?</h2>
        <div class="feature-list">
            <div class="feature">
                <img src="{{ asset('images/board-feature.png') }}" alt="Borden aanmaken">
                <h3>Borden aanmaken</h3>
                <p>Creëer  borden om jouw projecten perfect te organiseren.</p>
            </div>
            <div class="feature">
                <img src="{{ asset('images/task-feature.png') }}" alt="Taken beheren">
                <h3>Taken beheren</h3>
                <p>Blijf op schema met duidelijke taken, deadlines en prioriteiten.</p>
            </div>
            <div class="feature">
                <img src="{{ asset('images/team-feature.png') }}" alt="Samenwerken">
                <h3>Samenwerken</h3>
                <p>Werk samen met je team en deel je voortgang in realtime.</p>
            </div>
        </div>
    </section>

    <section class="cta">
        <h2>Ben je klaar om je taken te organiseren?</h2>
        <p>Word vandaag nog lid en begin met het stroomlijnen van je workflow.</p>
        <a href="/register" class="cta-primary">Start Nu</a>
    </section>

    @include('parts.footer')
</body>
</html>
