<div class="navbar">
    <div class="logo">
        <a href="/" class="logo-link">
            <h1>Boardify</h1>
        </a>
    </div>
    <nav>
        @if(Session::has('gebruiker'))
            <a href="/boards" class="nav-link">Borden</a>
            <a href="boards/agenda" class="nav-link">Agenda</a>
            <a href="/logout" class="nav-link logout">Uitloggen</a>  
        @else
            <a href="/login" class="nav-link">Inloggen</a>
            <a href="/register" class="nav-link register">Registreren</a>
        @endif
    </nav>
</div>

<style>
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #004953;
        color: white;
        padding: 15px 5%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .navbar .logo h1 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: bold;
    }

    .navbar .logo-link {
        text-decoration: none; 
        color: white; 
    }

    .navbar nav {
        display: flex;
        gap: 20px;
    }

    .navbar .nav-link {
        text-decoration: none;
        color: rgb(119, 97, 97);
        font-weight: 600;
        font-size: 1rem;
        padding: 8px 15px;
        border-radius: 5px;
        background-color: transparent; 
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .navbar .nav-link.register, 
    .navbar .nav-link.logout {
        background-color: #007b76;
        color: white;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .navbar .nav-link.logout {
        background-color: #007b76;
    }

    .navbar .nav-link.logout:hover,
    .navbar .nav-link.register:hover {
        background-color: #005f5a;
        transform: scale(1.05);
    }

    .navbar .nav-link:hover {
        background-color: #005f5a;
    }

        .navbar .Links, 
    .navbar .nav-link {
        text-decoration: none;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        padding: 8px 15px;
        border-radius: 5px;
        background-color: transparent; 
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .navbar .nav-link.register, 
    .navbar .nav-link.logout {
        background-color: #007b76;
        color: white;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .navbar .nav-link.logout {
        background-color: #007b76;
    }

    .navbar .nav-link.logout:hover,
    .navbar .nav-link.register:hover,
    .navbar .Links:hover {
        background-color: #005f5a;
        transform: scale(1.05);
    }

    .navbar .nav-link:hover {
        background-color: #005f5a;
    }


</style>
