<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host Berbagi Layar - {{ $code }}</title>
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
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between overflow-x-hidden">

    <!-- Header -->
    <header class="container mx-auto px-6 py-4 flex justify-between items-center z-10 border-b border-[var(--card-border)] bg-slate-950/10 backdrop-blur-md">
        <div class="flex items-center gap-3">
            <a href="{{ url('/') }}" class="h-9 w-9 rounded-xl bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center shadow-lg shadow-cyan-500/20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </a>
            <span class="text-lg font-bold tracking-tight theme-logo-text">Share<span class="text-cyan-500">Screen</span> <span class="text-xs text-slate-500 font-mono ml-2">HOST</span></span>
        </div>
        <div class="flex items-center gap-3">
            <div id="status-badge" class="px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-xs font-semibold text-amber-550 flex items-center gap-1.5">
                <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                Belum Berbagi
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

            <a href="{{ url('/') }}" class="px-4 py-2 rounded-xl bg-slate-900 border border-slate-800 text-xs text-slate-300 hover:bg-slate-800 transition-all font-semibold">
                Keluar
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8 flex-grow grid lg:grid-cols-4 gap-8 z-10">
        <!-- Sidebar Controls -->
        <div class="lg:col-span-1 flex flex-col gap-6">
            <!-- Room Info Card -->
            <div class="theme-card p-6 rounded-2xl shadow-xl">
                <h3 class="theme-text-muted text-xs font-bold uppercase tracking-wider mb-4">Informasi Sesi</h3>
                <div class="bg-[var(--input-bg)] border border-[var(--input-border)] rounded-xl p-4 text-center mb-4 transition-all">
                    <span class="text-slate-500 text-xs block mb-1">KODE ROOM</span>
                    <span class="text-3xl font-black tracking-widest text-cyan-500" id="room-code-display">{{ $code }}</span>
                </div>
                
                <div class="flex flex-col gap-2">
                    <button id="btn-copy-link" class="w-full py-2.5 px-4 bg-slate-800 hover:bg-slate-700 text-white text-sm font-semibold rounded-xl transition-all flex items-center justify-center gap-2 border border-slate-700 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                        </svg>
                        <span>Salin Tautan</span>
                    </button>
                    <span class="text-[10px] text-slate-500 text-center block mt-1">Bagikan tautan ini ke penonton di jaringan lokal.</span>
                </div>
            </div>


            <!-- Streaming Mode Card -->
            <div class="theme-card p-6 rounded-2xl shadow-xl">
                <h3 class="theme-text-muted text-xs font-bold uppercase tracking-wider mb-4">Mode Berbagi</h3>
                <div class="grid grid-cols-2 gap-2 bg-[var(--input-bg)] border border-[var(--input-border)] p-1 rounded-xl mb-4 transition-all">
                    <button id="mode-webrtc" class="py-2 text-xs font-bold rounded-lg transition-all cursor-pointer bg-cyan-600 text-white shadow">
                        WebRTC (Cepat)
                    </button>
                    <button id="mode-frame" class="py-2 text-xs font-bold rounded-lg transition-all cursor-pointer theme-text-muted hover:text-[var(--text-color)]">
                        Frame (Kompatibel)
                    </button>
                </div>
                
                <!-- Mode explanation -->
                <div id="mode-desc-webrtc" class="text-xs theme-text-muted leading-relaxed">
                    <strong class="text-cyan-500">Mode WebRTC:</strong> Latensi sangat rendah dan framerate mulus (30 FPS). Menggunakan koneksi P2P langsung antar browser. Memerlukan secure context.
                </div>
                <div id="mode-desc-frame" class="text-xs theme-text-muted leading-relaxed hidden">
                    <strong class="text-emerald-500">Mode Frame Fallback:</strong> Server bertindak sebagai perantara dengan membagikan gambar JPEG statis berkala (5-10 FPS). Bekerja di perangkat apapun tanpa HTTPS/WebRTC.
                </div>
            </div>

            <!-- Viewer list card -->
            <div class="theme-card p-6 rounded-2xl shadow-xl flex-grow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="theme-text-muted text-xs font-bold uppercase tracking-wider">Penonton Terkoneksi</h3>
                    <span id="viewer-count" class="px-2 py-0.5 rounded bg-cyan-500/10 text-[10px] font-bold text-cyan-500">0</span>
                </div>
                <ul id="viewer-list" class="text-xs theme-text-muted flex flex-col gap-2 max-h-48 overflow-y-auto pr-1">
                    <li class="py-2 text-center text-slate-500 italic">Belum ada penonton</li>
                </ul>
            </div>
        </div>

        <!-- Video Preview Area -->
        <div class="lg:col-span-3 flex flex-col gap-4">
            <div class="theme-card bg-slate-900/10 backdrop-blur-md rounded-3xl p-4 flex-grow flex flex-col items-center justify-center relative min-h-[450px] shadow-inner overflow-hidden group">
                <!-- Video tag -->
                <video id="local-video" autoplay playsinline muted class="w-full h-full rounded-2xl object-contain hidden border border-slate-800 bg-black"></video>

                <!-- Hidden Canvas for Fallback Image Streaming -->
                <canvas id="fallback-canvas" class="hidden"></canvas>

                <!-- Large Center Button to Start sharing -->
                <div id="start-overlay" class="text-center z-10 flex flex-col items-center gap-4">
                    <button id="btn-start-share" class="h-24 w-24 rounded-full bg-gradient-to-tr from-cyan-600 to-blue-600 hover:from-cyan-550 hover:to-blue-500 flex items-center justify-center shadow-lg shadow-cyan-600/30 cursor-pointer animate-bounce">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                    <div>
                        <h2 class="text-xl font-bold mb-1">Mulai Berbagi Layar</h2>
                        <p class="text-sm theme-text-muted max-w-sm">Klik tombol di atas untuk memilih layar, jendela aplikasi, atau tab browser yang ingin dibagikan.</p>
                    </div>
                </div>

                <!-- Stop sharing overlay (visible on hover when sharing) -->
                <div id="sharing-controls" class="absolute bottom-6 left-1/2 transform -translate-x-1/2 bg-slate-950/80 backdrop-blur-md px-6 py-3 rounded-full border border-white/10 flex items-center gap-4 shadow-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                    <span class="text-xs text-slate-300 font-semibold">Berbagi Aktif</span>
                    <div class="h-4 w-px bg-slate-800"></div>
                    <button id="btn-stop-share" class="py-1 px-3 bg-red-650 hover:bg-red-550 text-white text-xs font-bold rounded-lg transition-all pointer-events-auto cursor-pointer">
                        Hentikan Berbagi
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="container mx-auto px-6 py-6 text-center theme-text-muted text-xs border-t border-[var(--card-border)] z-10 bg-slate-950/5">
        <p>&copy; 2026 ShareScreen. Pastikan Anda tetap berada di halaman ini selama berbagi layar.</p>
    </footer>



    <!-- Alert Toast -->
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
        // MANAJEMEN ROOM & SCREEN SHARING LOGIC
        // ==========================================
        const roomCode = "{{ $code }}";
        const hostId = localStorage.getItem(`host_id_${roomCode}`);

        if (!hostId) {
            alert('Anda tidak memiliki akses sebagai host untuk room ini. Mengarahkan ke halaman menonton...');
            window.location.href = `${APP_URL}/join/${roomCode}`;
        }

        const videoElem = document.getElementById('local-video');
        const startOverlay = document.getElementById('start-overlay');
        const sharingControls = document.getElementById('sharing-controls');
        const statusBadge = document.getElementById('status-badge');
        const btnStartShare = document.getElementById('btn-start-share');
        const btnStopShare = document.getElementById('btn-stop-share');
        const btnCopyLink = document.getElementById('btn-copy-link');
        const viewerCountElem = document.getElementById('viewer-count');
        const viewerListElem = document.getElementById('viewer-list');

        const modeWebRTCBtn = document.getElementById('mode-webrtc');
        const modeFrameBtn = document.getElementById('mode-frame');
        const modeDescWebRTC = document.getElementById('mode-desc-webrtc');
        const modeDescFrame = document.getElementById('mode-desc-frame');

        let localStream = null;
        let activeMode = 'webrtc'; 
        let peers = {}; 
        let pendingCandidates = {}; 
        let signalingInterval = null;
        let lastSignalId = 0;
        let frameUploadInterval = null;
        let isUploadingFrame = false;

        const viewerUrl = `${APP_URL}/join/${roomCode}`;

        function copyTextToClipboard(text) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    showCopiedSuccess();
                }).catch(err => {
                    fallbackCopy(text);
                });
            } else {
                fallbackCopy(text);
            }
        }

        function fallbackCopy(text) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";
            textArea.style.opacity = "0";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    showCopiedSuccess();
                } else {
                    showToast('Gagal menyalin tautan.');
                }
            } catch (err) {
                console.error('Fallback copy failed', err);
                showToast('Gagal menyalin tautan.');
            }
            document.body.removeChild(textArea);
        }

        function showCopiedSuccess() {
            const originalText = btnCopyLink.innerHTML;
            btnCopyLink.innerHTML = `
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-emerald-500">Tersalin!</span>
            `;
            setTimeout(() => {
                btnCopyLink.innerHTML = originalText;
            }, 2000);
        }

        btnCopyLink.addEventListener('click', () => {
            copyTextToClipboard(viewerUrl);
        });

        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');
        function showToast(message) {
            toastMessage.textContent = message;
            toast.classList.remove('translate-y-24', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-24', 'opacity-0');
            }, 4000);
        }

        btnStartShare.addEventListener('click', startScreenShare);
        btnStopShare.addEventListener('click', stopScreenShare);

        async function startScreenShare() {
            try {
                localStream = await navigator.mediaDevices.getDisplayMedia({
                    video: {
                        cursor: "always",
                        displaySurface: "monitor"
                    },
                    audio: false
                });

                videoElem.srcObject = localStream;
                videoElem.classList.remove('hidden');
                startOverlay.classList.add('hidden');
                
                statusBadge.className = "px-3.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-xs font-semibold text-emerald-500 flex items-center gap-1.5";
                statusBadge.innerHTML = `<span class="h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span> Live`;

                localStream.getVideoTracks()[0].onended = () => {
                    stopScreenShare();
                };

                startSignaling();

                if (activeMode === 'frame') {
                    startFrameUploading();
                }

            } catch (err) {
                console.error("Gagal menangkap layar: ", err);
                showToast("Izin screen share ditolak atau gagal. Coba pastikan menggunakan browser modern.");
            }
        }

        function stopScreenShare() {
            if (localStream) {
                localStream.getTracks().forEach(track => track.stop());
                localStream = null;
            }

            videoElem.srcObject = null;
            videoElem.classList.add('hidden');
            startOverlay.classList.remove('hidden');

            statusBadge.className = "px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-xs font-semibold text-amber-500 flex items-center gap-1.5";
            statusBadge.innerHTML = `<span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span> Belum Berbagi`;

            stopSignaling();
            stopFrameUploading();

            Object.keys(peers).forEach(viewerId => {
                peers[viewerId].close();
            });
            peers = {};
            updateViewerListUI();
        }

        modeWebRTCBtn.addEventListener('click', () => changeRoomMode('webrtc'));
        modeFrameBtn.addEventListener('click', () => changeRoomMode('frame'));

        async function changeRoomMode(mode) {
            if (activeMode === mode) return;

            try {
                const response = await fetch(`${APP_URL}/api/rooms/${roomCode}/mode`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ mode })
                });

                if (response.ok) {
                    activeMode = mode;
                    updateModeUI();

                    if (localStream) {
                        if (activeMode === 'frame') {
                            Object.keys(peers).forEach(viewerId => {
                                peers[viewerId].close();
                            });
                            peers = {};
                            updateViewerListUI();

                            startFrameUploading();
                        } else {
                            stopFrameUploading();
                        }
                    }
                } else {
                    showToast('Gagal mengubah mode di server.');
                }
            } catch (err) {
                console.error(err);
                showToast('Koneksi server gagal saat merubah mode.');
            }
        }

        function updateModeUI() {
            if (activeMode === 'webrtc') {
                modeWebRTCBtn.className = "py-2 text-xs font-bold rounded-lg transition-all cursor-pointer bg-cyan-600 text-white shadow";
                modeFrameBtn.className = "py-2 text-xs font-bold rounded-lg transition-all cursor-pointer theme-text-muted hover:text-[var(--text-color)]";
                modeDescWebRTC.classList.remove('hidden');
                modeDescFrame.classList.add('hidden');
            } else {
                modeFrameBtn.className = "py-2 text-xs font-bold rounded-lg transition-all cursor-pointer bg-emerald-600 text-white shadow";
                modeWebRTCBtn.className = "py-2 text-xs font-bold rounded-lg transition-all cursor-pointer theme-text-muted hover:text-[var(--text-color)]";
                modeDescFrame.classList.remove('hidden');
                modeDescWebRTC.classList.add('hidden');
            }
        }

        function startSignaling() {
            stopSignaling();
            signalingInterval = setInterval(pollSignals, 1000);
        }

        function stopSignaling() {
            if (signalingInterval) {
                clearInterval(signalingInterval);
                signalingInterval = null;
            }
        }

        async function pollSignals() {
            try {
                const response = await fetch(`${APP_URL}/api/rooms/${roomCode}/signals?recipient_id=${hostId}&last_signal_id=${lastSignalId}`, {
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
                console.error("Signaling error:", err);
            }
        }

        async function handleIncomingSignal(signal) {
            const viewerId = signal.sender_id;

            if (signal.type === 'offer') {
                console.log(`Menerima WebRTC Offer dari ${viewerId}`);
                
                if (peers[viewerId]) {
                    peers[viewerId].close();
                }

                const pc = new RTCPeerConnection({
                    iceServers: @json($iceServers)
                });

                peers[viewerId] = pc;
                updateViewerListUI();

                if (localStream) {
                    localStream.getTracks().forEach(track => {
                        pc.addTrack(track, localStream);
                    });
                }

                pc.onicecandidate = (event) => {
                    if (event.candidate) {
                        sendSignal(viewerId, 'candidate', JSON.stringify(event.candidate));
                    }
                };

                pc.onconnectionstatechange = () => {
                    console.log(`Peer ${viewerId} Connection State: ${pc.connectionState}`);
                    if (pc.connectionState === 'disconnected' || pc.connectionState === 'failed' || pc.connectionState === 'closed') {
                        pc.close();
                        delete peers[viewerId];
                        delete pendingCandidates[viewerId];
                        updateViewerListUI();
                    }
                };

                const offerDescription = new RTCSessionDescription(JSON.parse(signal.payload));
                await pc.setRemoteDescription(offerDescription);

                const answer = await pc.createAnswer();
                await pc.setLocalDescription(answer);

                await sendSignal(viewerId, 'answer', JSON.stringify(answer));

                // Proses pending candidates untuk viewer ini jika ada
                if (pendingCandidates[viewerId]) {
                    console.log(`Memproses ${pendingCandidates[viewerId].length} pending candidates untuk ${viewerId}`);
                    for (const candidateData of pendingCandidates[viewerId]) {
                        try {
                            await pc.addIceCandidate(new RTCIceCandidate(candidateData));
                        } catch (e) {
                            console.error("Gagal menambahkan pending ICE candidate:", e);
                        }
                    }
                    delete pendingCandidates[viewerId];
                }

            } else if (signal.type === 'candidate') {
                console.log(`Menerima ICE Candidate dari ${viewerId}`);
                const pc = peers[viewerId];
                if (pc) {
                    try {
                        const candidate = new RTCIceCandidate(JSON.parse(signal.payload));
                        await pc.addIceCandidate(candidate);
                    } catch (e) {
                        console.error("Gagal menambahkan ICE candidate:", e);
                    }
                } else {
                    console.log(`Menyimpan pending candidate dari ${viewerId}`);
                    pendingCandidates[viewerId] = pendingCandidates[viewerId] || [];
                    pendingCandidates[viewerId].push(JSON.parse(signal.payload));
                }
            }
        }

        async function sendSignal(recipientId, type, payload) {
            try {
                await fetch(`${APP_URL}/api/rooms/${roomCode}/signals`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        sender_id: hostId,
                        recipient_id: recipientId,
                        type: type,
                        payload: payload
                    })
                });
            } catch (err) {
                console.error("Gagal mengirim sinyal:", err);
            }
        }

        function updateViewerListUI() {
            const viewerIds = Object.keys(peers);
            viewerCountElem.textContent = viewerIds.length;

            if (viewerIds.length === 0) {
                viewerListElem.innerHTML = `<li class="py-2 text-center text-slate-500 italic">Belum ada penonton</li>`;
                return;
            }

            viewerListElem.innerHTML = viewerIds.map(id => `
                <li class="flex items-center justify-between py-2 px-3 bg-[var(--input-bg)] border border-[var(--input-border)] rounded-xl transition-all">
                    <span class="font-mono theme-text-muted">${id.substring(0, 12)}...</span>
                    <span class="h-2 w-2 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></span>
                </li>
            `).join('');
        }

        // ==========================================
        // LOGIKA FALLBACK / HTTP FRAME STREAMING
        // ==========================================
        function startFrameUploading() {
            stopFrameUploading();
            frameUploadInterval = setInterval(captureAndUploadFrame, 150);
        }

        function stopFrameUploading() {
            if (frameUploadInterval) {
                clearInterval(frameUploadInterval);
                frameUploadInterval = null;
            }
        }

        const canvas = document.getElementById('fallback-canvas');
        const ctx = canvas.getContext('2d');

        function captureAndUploadFrame() {
            if (!localStream || videoElem.paused || videoElem.ended || isUploadingFrame) return;

            if (canvas.width !== videoElem.videoWidth || canvas.height !== videoElem.videoHeight) {
                canvas.width = videoElem.videoWidth;
                canvas.height = videoElem.videoHeight;
            }

            ctx.drawImage(videoElem, 0, 0, canvas.width, canvas.height);

            canvas.toBlob((blob) => {
                if (!blob) return;
                uploadFrameBlob(blob);
            }, 'image/jpeg', 0.55);
        }

        async function uploadFrameBlob(blob) {
            isUploadingFrame = true;

            const formData = new FormData();
            formData.append('frame', blob, 'frame.jpg');

            try {
                const response = await fetch(`${APP_URL}/api/rooms/${roomCode}/frame`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                if (!response.ok) {
                    console.error("Gagal mengunggah frame:", response.statusText);
                }
            } catch (err) {
                console.error("Koneksi gagal saat unggah frame:", err);
            } finally {
                isUploadingFrame = false;
            }
        }


    </script>
</body>
</html>