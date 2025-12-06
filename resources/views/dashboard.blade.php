<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Night Runners Club</title>
    <link rel="icon" type="image/png" href="/images/night-runner-logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 0 20px rgba(168, 85, 247, 0.3);
        }
        .shimmer-border {
            background: linear-gradient(90deg, transparent, rgba(168, 85, 247, 0.3), transparent);
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }
        .grid-bg {
            background-image: 
                linear-gradient(rgba(168, 85, 247, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(168, 85, 247, 0.02) 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#0a0f1c] via-[#0d1128] to-[#03050a] min-h-screen text-white">

    <!-- Grid Background -->
    <div class="fixed inset-0 grid-bg opacity-50 pointer-events-none"></div>

    <!-- Navbar -->
    <nav class="relative border-b border-purple-500/10 backdrop-blur-xl bg-purple-950/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-600 to-purple-800 flex items-center justify-center shadow-lg shadow-purple-500/30">
                        <img src="/images/night-runner-logo.png" alt="NRC" class="w-300 h-300 object-contain">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-purple-300 to-purple-500 bg-clip-text text-transparent">
                            Night Runners
                        </h1>
                        <p class="text-xs text-purple-400/60">Dashboard</p>
                    </div>
                </div>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="#" class="px-4 py-2 rounded-lg bg-purple-600/20 text-purple-300 font-medium text-sm border border-purple-500/30 shadow-sm shadow-purple-500/20">
                        Home
                    </a>
                    <a href="#" class="px-4 py-2 rounded-lg text-purple-300/70 hover:bg-purple-600/10 hover:text-purple-300 font-medium text-sm transition">
                        Members
                    </a>
                    <a href="#" class="px-4 py-2 rounded-lg text-purple-300/70 hover:bg-purple-600/10 hover:text-purple-300 font-medium text-sm transition">
                        Posts
                    </a>
                    <a href="#" class="px-4 py-2 rounded-lg text-purple-300/70 hover:bg-purple-600/10 hover:text-purple-300 font-medium text-sm transition">
                        Settings
                    </a>
                </div>

                <!-- Right Side -->
                <div class="flex items-center gap-3">
                    <!-- Notifications -->
                    <button class="relative p-2 rounded-lg hover:bg-purple-600/10 transition">
                        <svg class="w-5 h-5 text-purple-300/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-purple-500 rounded-full animate-pulse"></span>
                    </button>

                    <!-- Profile -->
                    <div class="flex items-center gap-3 pl-3 border-l border-purple-500/20">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium text-purple-300">Admin</p>
                            <p class="text-xs text-purple-400/60">Super User</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center ring-2 ring-purple-500/30 shadow-lg shadow-purple-500/30">
                            <span class="text-sm font-bold">A</span>
                        </div>
                    </div>

                    <!-- Mobile Menu -->
                    <button class="md:hidden p-2 rounded-lg hover:bg-purple-600/10 transition">
                        <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Welcome Section -->
        <div class="mb-8 animate-fadeIn">
            <h2 class="text-3xl font-bold text-white mb-2">Welcome back, Runner 👋</h2>
            <p class="text-purple-300/70">Here's what's happening with Night Runners today.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Members -->
            <div class="card-hover relative bg-gradient-to-br from-purple-950/40 to-purple-900/20 backdrop-blur-xl rounded-2xl border border-purple-500/20 p-6 shadow-xl animate-fadeIn" style="animation-delay: 0.1s;">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-600/20 flex items-center justify-center border border-purple-500/30">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs text-green-400 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                        </svg>
                        +12%
                    </span>
                </div>
                <h3 class="text-3xl font-bold text-white mb-1">247</h3>
                <p class="text-purple-300/70 text-sm">Total Members</p>
            </div>

            <!-- Active Posts -->
            <div class="card-hover relative bg-gradient-to-br from-purple-950/40 to-purple-900/20 backdrop-blur-xl rounded-2xl border border-purple-500/20 p-6 shadow-xl animate-fadeIn" style="animation-delay: 0.2s;">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-600/20 flex items-center justify-center border border-purple-500/30">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xs text-green-400 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                        </svg>
                        +8%
                    </span>
                </div>
                <h3 class="text-3xl font-bold text-white mb-1">89</h3>
                <p class="text-purple-300/70 text-sm">Active Posts</p>
            </div>

            <!-- Engagement Rate -->
            <div class="card-hover relative bg-gradient-to-br from-purple-950/40 to-purple-900/20 backdrop-blur-xl rounded-2xl border border-purple-500/20 p-6 shadow-xl animate-fadeIn" style="animation-delay: 0.3s;">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-600/20 flex items-center justify-center border border-purple-500/30">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <span class="text-xs text-green-400 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                        </svg>
                        +5%
                    </span>
                </div>
                <h3 class="text-3xl font-bold text-white mb-1">76%</h3>
                <p class="text-purple-300/70 text-sm">Engagement Rate</p>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Recent Members -->
            <div class="lg:col-span-1 bg-gradient-to-br from-purple-950/40 to-purple-900/20 backdrop-blur-xl rounded-2xl border border-purple-500/20 p-6 shadow-xl animate-fadeIn" style="animation-delay: 0.4s;">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-white">Recent Members</h3>
                    <button class="text-xs text-purple-400 hover:text-purple-300 transition">View All</button>
                </div>

                <div class="space-y-4">
                    <!-- Member 1 -->
                    <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-purple-600/10 transition cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center ring-2 ring-purple-500/30">
                            <span class="text-sm font-bold">JS</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">John Smith</p>
                            <p class="text-xs text-purple-400/60">Joined 2 days ago</p>
                        </div>
                        <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                    </div>

                    <!-- Member 2 -->
                    <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-purple-600/10 transition cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-500 to-purple-700 flex items-center justify-center ring-2 ring-purple-500/30">
                            <span class="text-sm font-bold">SK</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">Sarah Kim</p>
                            <p class="text-xs text-purple-400/60">Joined 3 days ago</p>
                        </div>
                        <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                    </div>

                    <!-- Member 3 -->
                    <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-purple-600/10 transition cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-700 flex items-center justify-center ring-2 ring-purple-500/30">
                            <span class="text-sm font-bold">ML</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">Mike Lee</p>
                            <p class="text-xs text-purple-400/60">Joined 5 days ago</p>
                        </div>
                        <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                    </div>

                    <!-- Member 4 -->
                    <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-purple-600/10 transition cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-purple-700 flex items-center justify-center ring-2 ring-purple-500/30">
                            <span class="text-sm font-bold">EM</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">Emma Martinez</p>
                            <p class="text-xs text-purple-400/60">Joined 1 week ago</p>
                        </div>
                        <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                    </div>

                    <!-- Member 5 -->
                    <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-purple-600/10 transition cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-500 to-purple-700 flex items-center justify-center ring-2 ring-purple-500/30">
                            <span class="text-sm font-bold">DW</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">David Wong</p>
                            <p class="text-xs text-purple-400/60">Joined 1 week ago</p>
                        </div>
                        <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                    </div>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="lg:col-span-2 bg-gradient-to-br from-purple-950/40 to-purple-900/20 backdrop-blur-xl rounded-2xl border border-purple-500/20 p-6 shadow-xl animate-fadeIn" style="animation-delay: 0.5s;">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-white">Recent Posts</h3>
                    <button class="px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium transition shadow-lg shadow-purple-500/30">
                        + New Post
                    </button>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <!-- Post 1 -->
                    <div class="group relative aspect-square rounded-xl overflow-hidden cursor-pointer border border-purple-500/20 hover:border-purple-500/40 transition">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-600/40 to-purple-900/40"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-12 h-12 text-white/80 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-xs text-white/80">Night Run</p>
                            </div>
                        </div>
                        <div class="absolute top-2 right-2 w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                    </div>

                    <!-- Post 2 -->
                    <div class="group relative aspect-square rounded-xl overflow-hidden cursor-pointer border border-purple-500/20 hover:border-purple-500/40 transition">
                        <div class="absolute inset-0 bg-gradient-to-br from-pink-600/40 to-purple-900/40"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-12 h-12 text-white/80 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-xs text-white/80">Meetup</p>
                            </div>
                        </div>
                    </div>

                    <!-- Post 3 -->
                    <div class="group relative aspect-square rounded-xl overflow-hidden cursor-pointer border border-purple-500/20 hover:border-purple-500/40 transition">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/40 to-purple-900/40"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-12 h-12 text-white/80 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-xs text-white/80">Training</p>
                            </div>
                        </div>
                    </div>

                    <!-- Post 4 -->
                    <div class="group relative aspect-square rounded-xl overflow-hidden cursor-pointer border border-purple-500/20 hover:border-purple-500/40 transition">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-600/40 to-purple-900/40"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-12 h-12 text-white/80 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-xs text-white/80">Finish Line</p>
                            </div>
                        </div>
                    </div>

                    <!-- Post 5 -->
                    <div class="group relative aspect-square rounded-xl overflow-hidden cursor-pointer border border-purple-500/20 hover:border-purple-500/40 transition">
                        <div class="absolute inset-0 bg-gradient-to-br from-orange-600/40 to-purple-900/40"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-12 h-12 text-white/80 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-xs text-white/80">Gear Check</p>
                            </div>
                        </div>
                    </div>

                    <!-- Post 6 -->
                    <div class="group relative aspect-square rounded-xl overflow-hidden cursor-pointer border border-purple-500/20 hover:border-purple-500/40 transition">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/40 to-purple-900/40"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-12 h-12 text-white/80 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-xs text-white/80">Route Map</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>