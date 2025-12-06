<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Night Runners Club</title>
    <link rel="icon" type="image/png" sizes="256x256" href="{{ asset('images/night-runner-logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes glowPulse {
            0% { filter: drop-shadow(0 0 8px rgba(168, 85, 247, 0.8)); }
            50% { filter: drop-shadow(0 0 20px rgba(168, 85, 247, 1)); }
            100% { filter: drop-shadow(0 0 8px rgba(168, 85, 247, 0.8)); }
        }
        @keyframes moonGlow {
            0% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
            100% { opacity: 0.5; transform: scale(1); }
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        @keyframes scanline {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(100%); }
        }
        @keyframes textGlow {
            0%, 100% { text-shadow: 0 0 10px rgba(168, 85, 247, 0.8), 0 0 20px rgba(168, 85, 247, 0.6); }
            50% { text-shadow: 0 0 20px rgba(168, 85, 247, 1), 0 0 30px rgba(168, 85, 247, 0.8), 0 0 40px rgba(168, 85, 247, 0.6); }
        }
        @keyframes neonBorder {
            0%, 100% { box-shadow: 0 0 5px rgba(168, 85, 247, 0.5), 0 0 10px rgba(168, 85, 247, 0.4), inset 0 0 10px rgba(168, 85, 247, 0.2); }
            50% { box-shadow: 0 0 10px rgba(168, 85, 247, 0.8), 0 0 20px rgba(168, 85, 247, 0.6), 0 0 30px rgba(168, 85, 247, 0.4), inset 0 0 15px rgba(168, 85, 247, 0.3); }
        }
        .shimmer-effect {
            background: linear-gradient(90deg, transparent, rgba(168, 85, 247, 0.3), transparent);
            background-size: 1000px 100%;
            animation: shimmer 3s infinite;
        }
        .scanline {
            position: absolute;
            width: 100%;
            height: 2px;
            background: linear-gradient(transparent, rgba(168, 85, 247, 0.5), transparent);
            animation: scanline 4s linear infinite;
            pointer-events: none;
        }
        .grid-bg {
            background-image: 
                linear-gradient(rgba(168, 85, 247, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(168, 85, 247, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
        }
    </style>
</head>
<body class="bg-gradient-to-b from-[#0a0f1c] via-[#0d1128] to-[#03050a] min-h-screen flex items-center justify-center relative overflow-hidden">

    <!-- Grid Background -->
    <div class="absolute inset-0 grid-bg opacity-40"></div>

    <!-- Stars Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <canvas id="starsCanvas" class="w-full h-full"></canvas>
    </div>

    <!-- Scanline Effect -->
    <div class="scanline"></div>

    <!-- Ambient Glow -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-purple-600/10 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- Moon with Enhanced Glow -->
    <div class="absolute top-10 right-10 md:top-16 md:right-20 animate-[moonGlow_8s_ease-in-out_infinite]">
        <div class="relative">
            <div class="absolute inset-0 w-32 h-32 md:w-40 md:h-40 rounded-full bg-purple-500/20 blur-xl"></div>
            <div class="relative w-32 h-32 md:w-40 md:h-40 rounded-full bg-gradient-to-br from-purple-200 via-purple-300 to-purple-400 shadow-2xl shadow-purple-500/60">
                <!-- Moon craters -->
                <div class="absolute top-8 right-6 w-6 h-6 rounded-full bg-purple-400/40"></div>
                <div class="absolute bottom-10 left-8 w-4 h-4 rounded-full bg-purple-400/30"></div>
                <div class="absolute top-14 left-12 w-3 h-3 rounded-full bg-purple-400/50"></div>
            </div>
        </div>
    </div>

    <!-- Floating Particles -->
    <div id="particles" class="absolute inset-0 pointer-events-none"></div>

    <!-- Main Content -->
    <div class="text-center z-10 px-6 animate-[fadeInUp_1.2s_ease-out]">
        <!-- Logo Container with Glow Ring -->
        <div class="relative inline-block mb-8 animate-[float_4s_ease-in-out_infinite]">
            <!-- Outer Glow Ring -->
            <div class="absolute inset-0 -m-8 rounded-full border-2 border-purple-500/30 animate-[neonBorder_3s_ease-in-out_infinite]"></div>
            <div class="absolute inset-0 -m-6 rounded-full border border-purple-400/20"></div>
            
            <!-- Logo -->
            <div class="relative w-48 h-48 md:w-56 md:h-56 rounded-full bg-gradient-to-br from-purple-900/40 to-purple-950/40 backdrop-blur-sm flex items-center justify-center border border-purple-500/30 animate-[glowPulse_3s_ease-in-out_infinite]">
                <!-- Placeholder for actual logo - replace img src with your logo path -->
                <img src="/images/night-runner-logo.png" alt="Night Runner Logo" class="w-32 h-32 md:w-40 md:h-40 object-contain drop-shadow-2xl">
                
                <!-- If logo doesn't exist, this will show -->
                {{-- <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-6xl animate-[textGlow_2s_ease-in-out_infinite]">🏃</div>
                </div> --}}
            </div>
            
            <!-- Shimmer overlay -->
            <div class="absolute inset-0 rounded-full shimmer-effect pointer-events-none"></div>
        </div>

        <!-- Title with Neon Effect -->
        <h1 class="mt-8 text-5xl md:text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-300 via-purple-400 to-purple-500 tracking-wider drop-shadow-2xl animate-[textGlow_3s_ease-in-out_infinite]">
            NIGHT RUNNERS
        </h1>
        
        <!-- Subtitle Line -->
        <div class="flex items-center justify-center gap-3 mt-2 mb-6">
            <div class="h-[1px] w-16 bg-gradient-to-r from-transparent to-purple-500"></div>
            <span class="text-purple-400/80 text-sm md:text-base tracking-[0.3em] font-light uppercase">Club</span>
            <div class="h-[1px] w-16 bg-gradient-to-l from-transparent to-purple-500"></div>
        </div>

        <!-- Tagline -->
        <p class="mt-6 text-xl md:text-2xl text-purple-200/90 max-w-2xl mx-auto font-light leading-relaxed">
            A <span class="text-purple-400 font-semibold">lifestyle community</span> for those who run the night.
        </p>
        <p class="mt-2 text-lg md:text-xl text-purple-300/70 font-light">
            Stay <span class="text-purple-400">glowing</span>, stay <span class="text-purple-400">moving</span>.
        </p>

        <!-- Status Indicators -->
        <div class="flex items-center justify-center gap-6 mt-8 text-sm text-purple-300/60">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                <span>Online</span>
            </div>
            <div class="w-[1px] h-4 bg-purple-500/30"></div>
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-purple-400 animate-pulse"></div>
                <span>Active Community</span>
            </div>
        </div>

        <!-- Enter Button with Enhanced Effects -->
        <div class="mt-10">
            <a href="/login" class="group relative inline-block">
                <!-- Button Glow -->
                <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-purple-800 rounded-2xl blur opacity-60 group-hover:opacity-100 transition duration-500"></div>
                
                <!-- Button -->
                <div class="relative px-12 py-4 bg-gradient-to-r from-purple-600 to-purple-700 rounded-2xl border border-purple-400/50 shadow-lg shadow-purple-500/50 transition-all duration-300 group-hover:scale-105 group-hover:shadow-2xl group-hover:shadow-purple-500/70">
                    <span class="text-white font-semibold text-lg tracking-wide flex items-center gap-3">
                        Enter Portal
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                </div>
            </a>
        </div>

        <!-- Bottom Text -->
        <p class="mt-12 text-xs md:text-sm text-purple-400/40 font-light tracking-widest">
            EST. 2019 - Embrace the Night 
        </p>
    </div>

    <script>
        // Enhanced stars canvas with twinkling effect
        const canvas = document.getElementById('starsCanvas');
        const ctx = canvas.getContext('2d');

        function resize() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }

        window.addEventListener('resize', resize);
        resize();

        const stars = [];
        for (let i = 0; i < 200; i++) {
            stars.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                r: Math.random() * 2,
                d: Math.random() * 0.3,
                opacity: Math.random(),
                twinkleSpeed: Math.random() * 0.05 + 0.01,
            });
        }

        function drawStars() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            stars.forEach((s) => {
                ctx.fillStyle = `rgba(255, 255, 255, ${s.opacity})`;
                ctx.beginPath();
                ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
                ctx.fill();
                
                // Add purple glow to some stars
                if (s.r > 1.5) {
                    ctx.fillStyle = `rgba(168, 85, 247, ${s.opacity * 0.3})`;
                    ctx.beginPath();
                    ctx.arc(s.x, s.y, s.r * 1.5, 0, Math.PI * 2);
                    ctx.fill();
                }
            });
            updateStars();
        }

        function updateStars() {
            stars.forEach((s) => {
                s.y += s.d;
                if (s.y > canvas.height) {
                    s.y = 0;
                    s.x = Math.random() * canvas.width;
                }
                // Twinkling effect
                s.opacity += s.twinkleSpeed;
                if (s.opacity > 1 || s.opacity < 0.2) {
                    s.twinkleSpeed *= -1;
                }
            });
        }

        function animate() {
            drawStars();
            requestAnimationFrame(animate);
        }

        animate();

        // Floating particles
        const particlesContainer = document.getElementById('particles');
        for (let i = 0; i < 20; i++) {
            const particle = document.createElement('div');
            particle.className = 'absolute w-1 h-1 bg-purple-400/30 rounded-full';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.animation = `float ${3 + Math.random() * 4}s ease-in-out infinite`;
            particle.style.animationDelay = Math.random() * 2 + 's';
            particlesContainer.appendChild(particle);
        }
    </script>
</body>
</html>