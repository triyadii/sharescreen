<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShareScreen - Berbagi Layar Jaringan Lokal</title>
    <!-- Plus Jakarta Sans Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            /* Light Mode Variables */
            --bg-color: #f1f5f9;
            --text-color: #0f172a;
            --text-muted: #475569;
            --card-bg: rgba(255, 255, 255, 0.8);
            --card-border: rgba(15, 23, 42, 0.06);
            --input-bg: rgba(255, 255, 255, 0.95);
            --input-border: #cbd5e1;
            --header-bg: rgba(255, 255, 255, 0.4);
            --gradient-overlay: radial-gradient(circle at 0% 0%, rgba(6, 182, 212, 0.08) 0%, transparent 60%),
                                radial-gradient(circle at 100% 100%, rgba(16, 185, 129, 0.08) 0%, transparent 60%);
            --logo-text-color: #0f172a;
            --btn-toggle-bg: #e2e8f0;
            --btn-toggle-border: #cbd5e1;
            --btn-toggle-text: #475569;
        }

        .dark {
            /* Dark Mode Variables (Cyber/Tech Dark Theme) */
            --bg-color: #060913;
            --text-color: #f8fafc;
            --text-muted: #94a3b8;
            --card-bg: rgba(11, 19, 38, 0.45);
            --card-border: rgba(6, 182, 212, 0.1);
            --input-bg: rgba(2, 6, 12, 0.7);
            --input-border: #1e293b;
            --header-bg: rgba(8, 14, 27, 0.3);
            --gradient-overlay: radial-gradient(circle at 0% 0%, rgba(6, 182, 212, 0.12) 0%, transparent 50%),
                                radial-gradient(circle at 100% 100%, rgba(16, 185, 129, 0.08) 0%, transparent 50%);
            --logo-text-color: #f8fafc;
            --btn-toggle-bg: #0f172a;
            --btn-toggle-border: rgba(6, 182, 212, 0.15);
            --btn-toggle-text: #94a3b8;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            background-image: var(--gradient-overlay);
            color: var(--text-color);
            transition: background-color 0.3s, color 0.3s, background-image 0.3s;
        }
        .theme-card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            transition: all 0.3s ease;
        }
        .theme-input {
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-color);
            transition: all 0.3s ease;
        }
        .theme-text-muted {
            color: var(--text-muted);
            transition: color 0.3s;
        }
        .theme-header {
            background-color: var(--header-bg);
            transition: background-color 0.3s;
        }
        .theme-logo-text {
            color: var(--logo-text-color);
        }
        .theme-toggle-btn {
            background-color: var(--btn-toggle-bg);
            border: 1px solid var(--btn-toggle-border);
            color: var(--btn-toggle-text);
            transition: all 0.3s;
        }
        .theme-toggle-btn:hover {
            filter: brightness(1.15);
            border-color: rgba(6, 182, 212, 0.4);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between overflow-x-hidden">

    <!-- Header -->
    <header class="container mx-auto px-6 py-6 flex justify-between items-center z-10">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center shadow-lg shadow-cyan-500/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <span class="text-xl font-bold tracking-tight theme-logo-text">Share<span class="text-cyan-500">Screen</span></span>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-xs font-semibold text-emerald-500 flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Jaringan Lokal Aktif
            </div>
            <button id="theme-toggle" class="p-2.5 rounded-xl theme-toggle-btn cursor-pointer shadow-sm" aria-label="Toggle Theme">
                <!-- Sun Icon -->
                <svg id="theme-toggle-sun" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 7a5 5 0 100 10 5 5 0 000-10z"></path>
                </svg>
                <!-- Moon Icon -->
                <svg id="theme-toggle-moon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-12 flex-grow flex flex-col items-center justify-center z-10">
        <div class="max-w-4xl w-full text-center mb-12">
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-4 leading-tight">
                Bagikan Layar Anda <br class="hidden md:inline">
                <span class="bg-gradient-to-r from-cyan-500 via-blue-500 to-emerald-400 bg-clip-text text-transparent">Secara Real-time di Jaringan Lokal</span>
            </h1>
            <p class="theme-text-muted text-lg max-w-2xl mx-auto">
                Tanpa internet, tanpa ribet instalasi aplikasi tambahan. Cukup gunakan browser Anda untuk berbagi layar dengan rekan dalam satu Wi-Fi atau LAN.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 w-full max-w-3xl">
            <!-- Card 1: Host / Mulai Berbagi -->
            <div class="theme-card p-8 rounded-3xl flex flex-col justify-between hover:border-cyan-500/30 transition-all duration-300 shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-20 -top-20 w-48 h-48 bg-cyan-500/5 rounded-full blur-3xl group-hover:bg-cyan-500/10 transition-all duration-500"></div>
                <div>
                    <div class="h-12 w-12 rounded-2xl bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center mb-6 text-cyan-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold mb-2">Mulai Bagikan Layar</h2>
                    <p class="theme-text-muted text-sm mb-8">
                        Bertindak sebagai presenter. Dapatkan kode room dan bagikan layar browser atau desktop Anda sekarang.
                    </p>
                </div>
                <button id="btn-create-room" class="w-full py-4 px-6 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white font-bold rounded-2xl transition-all duration-200 transform hover:-translate-y-0.5 shadow-lg shadow-cyan-500/10 flex items-center justify-center gap-2 cursor-pointer">
                    <span>Mulai Berbagi</span>
                    <svg class="w-5 h-5 transition-transform duration-200 group-hover:translate-x-1 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </div>

            <!-- Card 2: Join / Tonton Screen Share -->
            <div class="theme-card p-8 rounded-3xl flex flex-col justify-between hover:border-emerald-500/30 transition-all duration-300 shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-20 -top-20 w-48 h-48 bg-emerald-500/5 rounded-full blur-3xl group-hover:bg-emerald-500/10 transition-all duration-500"></div>
                <div>
                    <div class="h-12 w-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center mb-6 text-emerald-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold mb-2">Gabung ke Room</h2>
                    <p class="theme-text-muted text-sm mb-6">
                        Masukkan kode room unik yang dibagikan oleh presenter untuk mulai menonton layar secara langsung.
                    </p>
                    
                    <!-- Input Code -->
                    <div class="mb-6">
                        <input type="text" id="input-room-code" placeholder="MASUKKAN KODE ROOM" maxlength="6" class="w-full py-4 px-5 theme-input rounded-2xl text-center text-xl font-bold tracking-widest placeholder-slate-500 focus:outline-none focus:border-emerald-550/50 focus:ring-1 focus:ring-emerald-500/20 transition-all uppercase">
                    </div>
                </div>
                <button id="btn-join-room" class="w-full py-4 px-6 bg-gradient-to-r from-emerald-600 to-teal-650 hover:from-emerald-500 hover:to-teal-550 text-white font-bold rounded-2xl transition-all duration-200 transform hover:-translate-y-0.5 shadow-lg shadow-emerald-500/10 flex items-center justify-center gap-2 cursor-pointer">
                    <span>Gabung Room</span>
                    <svg class="w-5 h-5 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Alert Toast -->
        <div id="toast" class="fixed bottom-6 right-6 px-5 py-4 rounded-2xl bg-slate-900 border border-red-500/30 shadow-2xl text-red-200 text-sm font-semibold flex items-center gap-3 translate-y-24 opacity-0 transition-all duration-300 z-50">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <span id="toast-message">Pesan error</span>
        </div>
    </main>

    <!-- Footer -->
    <footer class="container mx-auto px-6 py-8 text-center theme-text-muted text-xs border-t border-[var(--card-border)] z-10">
        <p>&copy; 2026 ShareScreen. Dikembangkan untuk efisiensi jaringan lokal (Wi-Fi/LAN).</p>
    </footer>

    <script>
        // ==========================================
        // MANAJEMEN LIGHT & DARK THEME
        // ==========================================
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleSun = document.getElementById('theme-toggle-sun');
        const themeToggleMoon = document.getElementById('theme-toggle-moon');

        let currentTheme = localStorage.getItem('theme') || 'dark';

        function applyTheme(theme) {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                themeToggleSun.classList.remove('hidden');
                themeToggleMoon.classList.add('hidden');
            } else {
                document.documentElement.classList.remove('dark');
                themeToggleSun.classList.add('hidden');
                themeToggleMoon.classList.remove('hidden');
            }
            localStorage.setItem('theme', theme);
        }

        applyTheme(currentTheme);

        themeToggleBtn.addEventListener('click', () => {
            currentTheme = currentTheme === 'dark' ? 'light' : 'dark';
            applyTheme(currentTheme);
        });

        // ==========================================
        // AKSI TOMBOL FORM
        // ==========================================
        const btnCreateRoom = document.getElementById('btn-create-room');
        const btnJoinRoom = document.getElementById('btn-join-room');
        const inputRoomCode = document.getElementById('input-room-code');
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');

        function showToast(message) {
            toastMessage.textContent = message;
            toast.classList.remove('translate-y-24', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-24', 'opacity-0');
            }, 4000);
        }

        @if(session('error'))
            showToast("{{ session('error') }}");
        @endif

        btnCreateRoom.addEventListener('click', async () => {
            btnCreateRoom.disabled = true;
            btnCreateRoom.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menyiapkan Room...</span>
            `;

            try {
                const response = await fetch('/api/rooms', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const data = await response.json();
                if (data.success) {
                    localStorage.setItem(`host_id_${data.code}`, data.host_id);
                    window.location.href = `/host/${data.code}`;
                } else {
                    showToast('Gagal membuat room. Silakan coba lagi.');
                    resetCreateButton();
                }
            } catch (err) {
                console.error(err);
                showToast('Gagal terhubung ke server.');
                resetCreateButton();
            }
        });

        function resetCreateButton() {
            btnCreateRoom.disabled = false;
            btnCreateRoom.innerHTML = `
                <span>Mulai Berbagi</span>
                <svg class="w-5 h-5 transition-transform duration-200 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            `;
        }

        btnJoinRoom.addEventListener('click', async () => {
            const code = inputRoomCode.value.trim().toUpperCase();
            if (!code || code.length !== 6) {
                showToast('Kode room harus terdiri dari 6 karakter.');
                return;
            }

            btnJoinRoom.disabled = true;
            btnJoinRoom.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Menghubungkan...</span>
            `;

            try {
                const response = await fetch(`/api/rooms/join/${code}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();
                if (response.ok && data.success) {
                    window.location.href = `/join/${code}`;
                } else {
                    showToast(data.message || 'Room tidak valid atau sudah mati.');
                    resetJoinButton();
                }
            } catch (err) {
                console.error(err);
                showToast('Koneksi gagal. Periksa jaringan Anda.');
                resetJoinButton();
            }
        });

        function resetJoinButton() {
            btnJoinRoom.disabled = false;
            btnJoinRoom.innerHTML = `
                <span>Gabung Room</span>
                <svg class="w-5 h-5 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
            `;
        }

        inputRoomCode.addEventListener('keyup', (e) => {
            if (e.key === 'Enter') {
                btnJoinRoom.click();
            }
        });
    </script>
</body>
</html>
