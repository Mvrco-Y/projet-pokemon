<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Pokémon') }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Police Pokémon -->
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">

    <style>
    body {
        background-color: #0a0a1a;
        color: #fff;
        font-family: 'Rajdhani', sans-serif;
        overflow-x: hidden;
    }
    nav {
        background: linear-gradient(90deg, #cc0000, #ff4444);
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 10;
    }
    nav .logo {
        font-family: 'Press Start 2P', cursive;
        font-size: 1rem;
        color: #FFD700;
        text-shadow: 2px 2px #000;
    }
    nav a {
        color: #fff;
        text-decoration: none;
        margin-left: 1rem;
        font-weight: 700;
        font-size: 1.1rem;
        transition: color 0.2s;
    }
    nav a:hover { color: #FFD700; }

    /* Fond étoiles */
    #stars-canvas {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        z-index: 0;
        pointer-events: none;
    }
    main {
        position: relative;
        z-index: 1;
    }
</style>
</head>
<body>
    <canvas id="stars-canvas"></canvas>
    <header>
        <nav>
            <span class="logo">Pokémon</span>
            @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ url('/home') }}">Accueil</a>
                    @else
                        <a href="{{ route('login') }}">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Inscription</a>
                        @endif
                    @endauth
                </div>
            @endif
        </nav>
    </header>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const canvas = document.getElementById('stars-canvas');
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const stars = Array.from({length: 120}, () => ({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        r: Math.random() * 1.5 + 0.5,
        alpha: Math.random(),
        speed: Math.random() * 0.01 + 0.003
    }));

    function drawStars() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        stars.forEach(s => {
            s.alpha += s.speed;
            if (s.alpha > 1 || s.alpha < 0) s.speed *= -1;
            ctx.beginPath();
            ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(255, 215, 0, ${s.alpha})`;
            ctx.fill();
        });
        requestAnimationFrame(drawStars);
    }
    drawStars();
</script>
</body>
</html>