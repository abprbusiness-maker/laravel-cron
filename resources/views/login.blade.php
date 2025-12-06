<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Night Runners Club</title>
    <link rel="icon" type="image/png" sizes="256x256" href="{{ asset('images/night-runner-logo.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        @keyframes slideInLeft {
            0% { opacity: 0; transform: translateX(-50px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideInRight {
            0% { opacity: 0; transform: translateX(50px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        @keyframes neonGlow {
            0%, 100% { box-shadow: 0 0 5px rgba(168, 85, 247, 0.5), 0 0 10px rgba(168, 85, 247, 0.3); }
            50% { box-shadow: 0 0 10px rgba(168, 85, 247, 0.8), 0 0 20px rgba(168, 85, 247, 0.5), 0 0 30px rgba(168, 85, 247, 0.3); }
        }
        .grid-bg {
            background-image: 
                linear-gradient(rgba(168, 85, 247, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(168, 85, 247, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        .shimmer-effect {
            background: linear-gradient(90deg, transparent, rgba(168, 85, 247, 0.2), transparent);
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }
        input:focus {
            outline: none;
        }
        .input-glow:focus {
            box-shadow: 0 0 0 2px rgba(168, 85, 247, 0.5), 0 0 20px rgba(168, 85, 247, 0.3);
        }
        .error-message {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#0a0f1c] via-[#0d1128] to-[#03050a] min-h-screen flex items-center justify-center relative overflow-hidden">

    <!-- Grid Background -->
    <div class="absolute inset-0 grid-bg opacity-30"></div>

    <!-- Stars Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <canvas id="starsCanvas" class="w-full h-full"></canvas>
    </div>

    <!-- Ambient Glow Left -->
    <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-purple-600/10 rounded-full blur-[120px] pointer-events-none"></div>
    
    <!-- Ambient Glow Right -->
    <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-purple-800/10 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- Main Container -->
    <div class="w-full max-w-6xl mx-auto px-6 py-12 z-10">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            
            <!-- Left Side - Branding -->
            <div class="hidden md:block text-center md:text-left animate-[slideInLeft_1s_ease-out]">
                <!-- Logo -->
                <div class="inline-block animate-[float_4s_ease-in-out_infinite]">
                    <div class="relative">
                        <div class="absolute inset-0 -m-4 rounded-full border border-purple-500/20 animate-[neonGlow_3s_ease-in-out_infinite]"></div>
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-purple-900/40 to-purple-950/40 backdrop-blur-sm flex items-center justify-center border border-purple-500/30">
                            <img src="{{ asset('images/night-runner-logo.png') }}" alt="Night Runner Logo" class="w-20 h-20 object-contain drop-shadow-2xl">
                        </div>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="mt-8 text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-300 via-purple-400 to-purple-500 tracking-wider">
                    NIGHT RUNNERS
                </h1>
                <p class="mt-2 text-purple-400/80 text-xl tracking-[0.2em] font-light uppercase">Club</p>

                <!-- Description -->
                <p class="mt-6 text-purple-200/70 text-lg leading-relaxed max-w-md">
                    Join our community of night enthusiasts. Stay connected, stay informed, stay glowing.
                </p>

                <!-- Features -->
                <div class="mt-8 space-y-3">
                    <div class="flex items-center gap-3 text-purple-300/60">
                        <div class="w-2 h-2 rounded-full bg-purple-400 animate-pulse"></div>
                        <span>Active community chat</span>
                    </div>
                    <div class="flex items-center gap-3 text-purple-300/60">
                        <div class="w-2 h-2 rounded-full bg-purple-400 animate-pulse"></div>
                        <span>Exclusive member benefits</span>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="animate-[slideInRight_1s_ease-out]">
                <div class="relative">
                    <!-- Card Glow -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-purple-600/20 to-purple-800/20 rounded-3xl blur-xl"></div>
                    
                    <!-- Card -->
                    <div class="relative bg-gradient-to-br from-purple-950/40 to-purple-900/20 backdrop-blur-xl rounded-3xl border border-purple-500/30 p-8 md:p-12 shadow-2xl">
                        
                        <!-- Mobile Logo -->
                        <div class="md:hidden text-center mb-8">
                            <div class="inline-block w-20 h-20 rounded-full bg-gradient-to-br from-purple-900/40 to-purple-950/40 flex items-center justify-center border border-purple-500/30 mb-4">
                                <img src="{{ asset('images/night-runner-logo.png') }}" alt="Night Runner Logo" class="w-12 h-12 object-contain">
                            </div>
                            <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-300 to-purple-500">
                                NIGHT RUNNERS
                            </h2>
                        </div>

                        <!-- Header -->
                        <div class="text-center md:text-left mb-8">
                            <h2 class="text-3xl md:text-4xl font-bold text-white">Welcome Back</h2>
                            <p class="mt-2 text-purple-300/70">Enter your credentials to continue</p>
                        </div>

                        <!-- Error Messages -->
                        @if(session('error'))
                        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl error-message">
                            <div class="flex items-center gap-2 text-red-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                        @endif

                        @if(session('success'))
                        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-xl error-message">
                            <div class="flex items-center gap-2 text-green-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Form -->
                        <form method="POST" action="{{ url('/login') }}" class="space-y-6">
                            @csrf
                            
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-purple-300 mb-2">
                                    Email Address
                                </label>
                                <div class="relative">
                                    <input 
                                        type="email" 
                                        id="email" 
                                        name="email" 
                                        required
                                        value="{{ old('email') }}"
                                        class="input-glow w-full px-4 py-3 bg-purple-950/30 border border-purple-500/30 rounded-xl text-white placeholder-purple-400/40 transition-all duration-300 focus:border-purple-500"
                                        placeholder="runner@nightclub.id"
                                    >
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-purple-400/40">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('email')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-purple-300 mb-2">
                                    Password
                                </label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="password" 
                                        name="password" 
                                        required
                                        class="input-glow w-full px-4 py-3 bg-purple-950/30 border border-purple-500/30 rounded-xl text-white placeholder-purple-400/40 transition-all duration-300 focus:border-purple-500"
                                        placeholder="••••••••"
                                    >
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-purple-400/40">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('password')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="group relative w-full">
                                <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-purple-800 rounded-xl blur opacity-60 group-hover:opacity-100 transition duration-500"></div>
                                <div class="relative w-full px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 rounded-xl border border-purple-400/50 shadow-lg shadow-purple-500/50 transition-all duration-300 group-hover:scale-[1.02] group-hover:shadow-2xl group-hover:shadow-purple-500/70">
                                    <span class="text-white font-semibold text-lg tracking-wide flex items-center justify-center gap-3">
                                        Sign In
                                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </span>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Home -->
    <a href="/" class="absolute top-6 left-6 z-20 flex items-center gap-2 text-purple-300/70 hover:text-purple-300 transition group">
        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span class="text-sm font-medium">Back to Home</span>
    </a>

    <script>
        // Stars canvas
        const canvas = document.getElementById('starsCanvas');
        const ctx = canvas.getContext('2d');

        function resize() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }

        window.addEventListener('resize', resize);
        resize();

        const stars = [];
        for (let i = 0; i < 150; i++) {
            stars.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                r: Math.random() * 1.5,
                d: Math.random() * 0.2,
                opacity: Math.random(),
                twinkleSpeed: Math.random() * 0.03 + 0.01,
            });
        }

        function drawStars() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            stars.forEach((s) => {
                ctx.fillStyle = `rgba(255, 255, 255, ${s.opacity})`;
                ctx.beginPath();
                ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
                ctx.fill();
                
                if (s.r > 1) {
                    ctx.fillStyle = `rgba(168, 85, 247, ${s.opacity * 0.2})`;
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

        // Auto focus email field
        document.addEventListener('DOMContentLoaded', function() {
            const emailField = document.getElementById('email');
            if (emailField && !emailField.value) {
                emailField.focus();
            }
        });
    </script>
</body>
</html>