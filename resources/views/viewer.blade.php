<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menonton ShareScreen - {{ $code }}</title>
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
            /* Dark Mode Variables */
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
        .shimmer {
            background: linear-gradient(90deg, #090d16 25%, #131b2e 50%, #090d16 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between overflow-x-hidden">

    <header class="container mx-auto px-6 py-4 flex justify-between items-center z-10 border-b border-[var(--card-border)] bg-slate-950/10 backdrop-blur-md">
        <div class="flex items-center gap-3">
            <a href="{{ url('/') }}" class="h-9 w-9 rounded-xl bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center shadow-lg shadow-cyan-500/20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div class="flex flex-col">
                <span class="text-sm font-bold tracking-tight theme-logo-text">Menonton Layar</span>
                <span class="text-xs text-cyan-555 font-mono">ROOM: {{ $code }}</span>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <div id="mode-badge" class="px-3 py-1 rounded-full bg-slate-800 border border-slate-700 text-[10px] font-bold text-slate-300">
                Mendeteksi Mode...
            </div>
            <div id="network-badge" class="px-3 py-1 rounded-full text-[10px] font-bold">
                Mendeteksi...
            </div>
            <div id="status-badge" class="px-3.5 py-1 rounded-full bg-blue-500/10 border border-blue-500/30 text-xs font-semibold text-blue-400 flex items-center gap-1.5">
                <span class="h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                Menghubungkan...
            </div>
            
            <button id="theme-toggle" class="p-2.5 rounded-xl theme-toggle-btn cursor-pointer shadow-sm" aria-label="Toggle Theme">
                <svg id="theme-toggle-sun" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 7a5 5 0 100 10 5 5 0 000-10z"></path>
                </svg>
                <svg id="theme-toggle-moon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </button>
        </div>
    </header>

    <main class="container mx-auto px-6 py-6 flex-grow flex flex-col items-center justify-center z-10 relative">
        <div id="screen-container" class="w-full max-w-5xl theme-card rounded-3xl shadow-2xl relative overflow-hidden flex items-center justify-center aspect-video group">
            
            <video id="remote-video" autoplay playsinline muted class="w-full h-full object-contain hidden z-10 bg-black"></video>

            <img id="fallback-img" class="w-full h-full object-contain hidden z-10" alt="Screen Stream Frame">

            <div id="loading-state" class="absolute inset-0 shimmer flex flex-col items-center justify-center gap-4 z-20">
                <div class="h-12 w-12 rounded-full border-4 border-cyan-500/30 border-t-cyan-500 animate-spin"></div>
                <div class="text-center">
                    <p class="text-sm font-semibold text-slate-350">Menunggu Sinyal Layar...</p>
                    <p class="text-xs text-slate-500 mt-1">Pastikan Host sudah mulai membagikan layar.</p>
                </div>
            </div>

            <div id="error-state" class="absolute inset-0 bg-slate-950/90 hidden flex-col items-center justify-center gap-4 z-20 text-center p-6">
                <div class="h-16 w-16 rounded-full bg-red-500/10 border border-red-500/30 flex items-center justify-center text-red-500 mb-2">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold" id="error-title">Room Tidak Aktif</h3>
                <p class="text-sm text-slate-400 max-w-sm" id="error-message">Sesi screen sharing telah dihentikan oleh host atau room tidak valid.</p>
                <a href="{{ url('/') }}" class="mt-4 px-6 py-2.5 bg-slate-800 hover:bg-slate-700 text-white text-sm font-semibold rounded-xl border border-slate-700 transition-all">
                    Kembali ke Beranda
                </a>
            </div>

            <div class="absolute bottom-4 left-4 right-4 bg-slate-950/80 backdrop-blur-md px-6 py-3 rounded-2xl border border-white/10 flex justify-between items-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-30">
                <div class="flex items-center gap-3 text-xs text-slate-450">
                    <span id="resolution-indicator" class="font-mono bg-slate-900 px-2 py-1 rounded border border-slate-800 text-slate-300">1080p</span>
                    <span id="latency-indicator" class="flex items-center gap-1 text-slate-300">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> P2P Lancar
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <button id="btn-fullscreen" class="p-2 bg-slate-900 hover:bg-slate-800 rounded-xl border border-slate-800 text-slate-300 hover:text-white transition-all cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-5h-4m4 0v4m0-4l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <footer class="container mx-auto px-6 py-6 text-center theme-text-muted text-xs border-t border-[var(--card-border)] z-10 bg-slate-950/5">
        <p>&copy; 2026 ShareScreen. Berbagi layar cepat tanpa internet.</p>
    </footer>

    <div id="toast" class="fixed bottom-6 right-6 px-5 py-4 rounded-2xl bg-slate-900 border border-red-500/30 shadow-2xl text-red-200 text-sm font-semibold flex items-center gap-3 translate-y-24 opacity-0 transition-all duration-300 z-50">
        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <span id="toast-message">Pesan error</span>
    </div>

    <script>
        // DAFTARKAN BASE URL APLIKASI
        const APP_URL = "{{ url('') }}";

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
        // MANAJEMEN PENERIMAAN STREAM
        // ==========================================
        const roomCode = "{{ $code }}";
        const viewerId = 'viewer_' + Math.random().toString(36).substring(2, 12);

        const videoElem = document.getElementById('remote-video');
        const fallbackImg = document.getElementById('fallback-img');
        const loadingState = document.getElementById('loading-state');
        const errorState = document.getElementById('error-state');
        const errorTitle = document.getElementById('error-title');
        const errorMessage = document.getElementById('error-message');
        const statusBadge = document.getElementById('status-badge');
        const modeBadge = document.getElementById('mode-badge');
        const btnFullscreen = document.getElementById('btn-fullscreen');
        const screenContainer = document.getElementById('screen-container');
        const latencyIndicator = document.getElementById('latency-indicator');
        const resolutionIndicator = document.getElementById('resolution-indicator');

        let currentMode = null; 
        let roomStatus = 'active';
        let pc = null;
        let signalingInterval = null;
        let lastSignalId = 0;
        let framePollInterval = null;
        let statusPollInterval = null;

        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');
        function showToast(message) {
            toastMessage.textContent = message;
            toast.classList.remove('translate-y-24', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-24', 'opacity-0');
            }, 4000);
        }

        btnFullscreen.addEventListener('click', () => {
            if (!document.fullscreenElement) {
                screenContainer.requestFullscreen().catch(err => {
                    showToast('Gagal masuk ke mode layar penuh.');
                });
            } else {
                document.exitFullscreen();
            }
        });

        async function pollRoomStatus() {
            try {
                // MENGGUNAKAN APP_URL
                const response = await fetch(`${APP_URL}/api/rooms/${roomCode}/status`);
                const data = await response.json();

                if (!data.success || data.status === 'inactive') {
                    showError('Room Ditutup', 'Sesi screen sharing telah dihentikan oleh host.');
                    stopAllConnections();
                    return;
                }

                if (data.mode !== currentMode) {
                    console.log(`Mengubah mode dari ${currentMode} ke ${data.mode}`);
                    currentMode = data.mode;
                    handleModeChange();
                }
            } catch (err) {
                console.error("Gagal polling status room:", err);
            }
        }

        function handleModeChange() {
            stopAllConnections();

            if (currentMode === 'webrtc') {
                modeBadge.className = "px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-[10px] font-bold text-cyan-500";
                modeBadge.textContent = "WebRTC (35 FPS)";
                
                statusBadge.className = "px-3.5 py-1 rounded-full bg-blue-500/10 border border-blue-500/30 text-xs font-semibold text-blue-450 flex items-center gap-1.5";
                statusBadge.innerHTML = `<span class="h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span> Menghubungkan P2P...`;

                fallbackImg.classList.add('hidden');
                loadingState.classList.remove('hidden');

                connectWebRTC();
            } else if (currentMode === 'frame') {
                modeBadge.className = "px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-[10px] font-bold text-emerald-500";
                modeBadge.textContent = "Frame (5-10 FPS)";

                statusBadge.className = "px-3.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-xs font-semibold text-emerald-500 flex items-center gap-1.5";
                statusBadge.innerHTML = `<span class="h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span> Live (HTTP Frame)`;

                videoElem.classList.add('hidden');
                loadingState.classList.add('hidden');
                fallbackImg.classList.remove('hidden');
                
                resolutionIndicator.textContent = "Frame";
                latencyIndicator.innerHTML = `<span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Mode Kompatibilitas`;

                startFramePolling();
            }
        }

        function stopAllConnections() {
            if (pc) {
                pc.close();
                pc = null;
            }
            if (signalingInterval) {
                clearInterval(signalingInterval);
                signalingInterval = null;
            }
            if (framePollInterval) {
                clearInterval(framePollInterval);
                framePollInterval = null;
            }
        }

        async function connectWebRTC() {
            try {
                pc = new RTCPeerConnection({
                    iceServers: @json($iceServers)
                });

                pc.addTransceiver('video', { direction: 'recvonly' });

                pc.ontrack = (event) => {
                    console.log('Menerima WebRTC video track!', event);
                    
                    if (event.streams && event.streams[0]) {
                        videoElem.srcObject = event.streams[0];
                    } else {
                        const newStream = new MediaStream();
                        newStream.addTrack(event.track);
                        videoElem.srcObject = newStream;
                    }
                    
                    videoElem.classList.remove('hidden');
                    loadingState.classList.add('hidden');
                    
                    videoElem.play().catch(err => {
                        console.warn("Autoplay terhambat:", err);
                    });
                    
                    statusBadge.className = "px-3.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-xs font-semibold text-emerald-500 flex items-center gap-1.5";
                    statusBadge.innerHTML = `<span class="h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span> Live`;

                    latencyIndicator.innerHTML = `<span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> P2P Lancar`;
                    
                    const videoTrack = event.streams[0] ? event.streams[0].getVideoTracks()[0] : event.track;
                    if (videoTrack) {
                        const settings = videoTrack.getSettings();
                        if (settings.width && settings.height) {
                            resolutionIndicator.textContent = `${settings.width}x${settings.height}`;
                        }
                    }
                };

                pc.onicecandidate = (event) => {
                    if (event.candidate) {
                        sendSignal('candidate', JSON.stringify(event.candidate));
                    }
                };

                pc.onconnectionstatechange = () => {
                    console.log("WebRTC Connection State:", pc.connectionState);
                    if (pc.connectionState === 'connected') {
                        loadingState.classList.add('hidden');
                    } else if (pc.connectionState === 'disconnected' || pc.connectionState === 'failed') {
                        statusBadge.className = "px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-xs font-semibold text-amber-500 flex items-center gap-1.5";
                        statusBadge.innerHTML = `<span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span> Mencoba Reconnect...`;
                    }
                };

                const offer = await pc.createOffer();
                await pc.setLocalDescription(offer);

                await sendSignal('offer', JSON.stringify(offer));

                signalingInterval = setInterval(pollSignals, 1000);

            } catch (err) {
                console.error("Gagal setup WebRTC:", err);
                showToast("Browser Anda bermasalah atau tidak mendukung WebRTC.");
            }
        }

        async function pollSignals() {
            try {
                // MENGGUNAKAN APP_URL
                const response = await fetch(`${APP_URL}/api/rooms/${roomCode}/signals?recipient_id=${viewerId}&last_signal_id=${lastSignalId}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();

                if (data.success && data.signals.length > 0) {
                    for (const signal of data.signals) {
                        lastSignalId = Math.max(lastSignalId, signal.id);
                        await handleIncomingSignal(signal);
                    }
                }
            } catch (err) {
                console.error("Gagal polling sinyal:", err);
            }
        }

        async function handleIncomingSignal(signal) {
            if (signal.type === 'answer' && pc) {
                console.log("Menerima WebRTC Answer dari Host");
                const answerDescription = new RTCSessionDescription(JSON.parse(signal.payload));
                await pc.setRemoteDescription(answerDescription);
            } else if (signal.type === 'candidate' && pc) {
                console.log("Menerima ICE Candidate dari Host");
                try {
                    const candidate = new RTCIceCandidate(JSON.parse(signal.payload));
                    await pc.addIceCandidate(candidate);
                } catch (e) {
                    console.error("Gagal menambahkan ICE candidate:", e);
                }
            }
        }

        async function sendSignal(type, payload) {
            try {
                // MENGGUNAKAN APP_URL
                await fetch(`${APP_URL}/api/rooms/${roomCode}/signals`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        sender_id: viewerId,
                        recipient_id: null, 
                        type: type,
                        payload: payload
                    })
                });
            } catch (err) {
                console.error("Gagal mengirim sinyal:", err);
            }
        }

        function startFramePolling() {
            if (framePollInterval) clearInterval(framePollInterval);
            updateFrameSrc();
            framePollInterval = setInterval(updateFrameSrc, 180);
        }

        function updateFrameSrc() {
            const timestamp = Date.now();
            // MENGGUNAKAN APP_URL
            fallbackImg.src = `${APP_URL}/storage/rooms/${roomCode.toUpperCase()}.jpg?t=${timestamp}`;
        }

        fallbackImg.onerror = () => {
            fallbackImg.classList.add('hidden');
            loadingState.classList.remove('hidden');
        };

        fallbackImg.onload = () => {
            fallbackImg.classList.remove('hidden');
            loadingState.classList.add('hidden');
        };

        function showError(title, message) {
            errorTitle.textContent = title;
            errorMessage.textContent = message;
            errorState.classList.remove('hidden');
            loadingState.classList.add('hidden');
            videoElem.classList.add('hidden');
            fallbackImg.classList.add('hidden');
            
            statusBadge.className = "px-3.5 py-1 rounded-full bg-red-500/10 border border-red-500/30 text-xs font-semibold text-red-500 flex items-center gap-1.5";
            statusBadge.innerHTML = `<span class="h-2 w-2 rounded-full bg-red-500"></span> Off`;
        }

        window.addEventListener('DOMContentLoaded', () => {
            pollRoomStatus();
            statusPollInterval = setInterval(pollRoomStatus, 1500);
        });

        window.addEventListener('beforeunload', () => {
            stopAllConnections();
            if (statusPollInterval) clearInterval(statusPollInterval);
        });

        // ==========================================
        // AUTO-DETEKSI LINGKUNGAN JARINGAN (LOKAL VS ONLINE)
        // ==========================================
        const networkBadge = document.getElementById('network-badge');
        const isLocalNetwork = window.location.hostname === 'localhost' || 
                             window.location.hostname === '127.0.0.1' || 
                             /^192\.168\./.test(window.location.hostname) || 
                             /^10\./.test(window.location.hostname) || 
                             /^172\.(1[6-9]|2[0-9]|3[0-1])\./.test(window.location.hostname);

        if (isLocalNetwork) {
            networkBadge.className = "px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-[10px] font-bold text-cyan-500";
            networkBadge.textContent = "Lokal (LAN)";
        } else {
            networkBadge.className = "px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-[10px] font-bold text-blue-400";
            networkBadge.textContent = "Online (Internet)";
        }
    </script>
</body>
</html>