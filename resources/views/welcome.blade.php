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
            <p>Beheer borden, plan agenda's, en organiseer je dag moeiteloos – alles in één overzichtelijke tool.</p>
            <div class="cta-buttons">
                <a href="/register" class="cta-primary">Aan de slag</a>
                <a href="/login" class="cta-secondary">Inloggen</a>
            </div>
        </div>
        <div class="hero-image">
            <div class="clipboard">
                <div class="task">
                    <div class="checkbox checked"></div>
                    <span>Bedenk 💡</span>
                </div>
                <div class="task">
                    <div class="checkbox checked"></div>
                    <span>Ontwikkel ⚙️</span>
                </div>
                <div class="task">
                    <div class="checkbox"></div>
                    <span>Launch! 🚀</span>
                </div>
            </div>
            <div class="shadow"></div>
        </div>
    </section>
    
    <section class="features">
        <h2>Waarom kiezen voor Boardify?</h2>
        <div class="feature-list">
            <div class="feature">
                <div class="emoji">📋</div>
                <h3>Borden aanmaken</h3>
                <p>Creëer borden om jouw projecten perfect te organiseren.</p>
            </div>
            <div class="feature">
                <div class="emoji">📆</div>
                <h3>Agenda's plannen</h3>
                <p>Blijf op schema met duidelijke taken, deadlines en prioriteiten.</p>
            </div>
            <div class="feature">
                <div class="emoji">📝</div>
                <h3>dag plannen</h3>
                <p>Plan je dag efficiënt en houd je taken overzichtelijk.</p>
            </div>
        </div>
    </section>

    <section class="cta">
        <h2>Ben je klaar om je taken te organiseren?</h2>
        <p>Sluit je aan bij ons platform om je werk overzichtelijker te organiseren</p>
        <a href="/register" class="cta-primary">Start Nu</a>
    </section>

    @include('parts.footer')
    <script src="{{ asset('js/welcome.js') }}"></script>
</body>
</html>
