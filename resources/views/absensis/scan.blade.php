@extends('layouts.app')

@section('title', 'Scan Absensi')

@section('page_title', 'Scan Absensi')

@section('content')
<div class="min-h-[80vh] flex flex-col items-center justify-center p-4">
    
    <div class="glass-panel w-full max-w-lg p-0 overflow-hidden relative">
        <!-- Decoration -->
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-purple-500"></div>

        <div class="p-8 text-center">
            <h2 class="text-2xl font-bold text-white mb-2">Scan QR Code</h2>
            <p class="text-slate-400 text-sm mb-6">Arahkan kamera ke kartu ID Karyawan</p>

            <!-- Scanner Area -->
            <div class="relative rounded-2xl overflow-hidden border-2 border-white/10 shadow-2xl bg-black/50 aspect-square">
                <div id="reader" class="w-full h-full"></div>
                
                <!-- Scanning Overlay Animation -->
                <div class="absolute inset-0 pointer-events-none">
                    <div class="w-full h-1 bg-blue-500/50 shadow-[0_0_15px_rgba(59,130,246,0.8)] absolute top-0 animate-scan"></div>
                </div>
            </div>
            
            <!-- Result & Feedback -->
            <div id="result" class="mt-6 min-h-[3rem] flex items-center justify-center">
                <div class="text-slate-500 text-sm animate-pulse">Menunggu scan...</div>
            </div>
        </div>

        <!-- Last Scan Info Panel -->
        <div id="lastScanInfo" class="bg-white/5 border-t border-white/10 p-6 hidden transition-all duration-500">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                    <span id="scanInitial">U</span>
                </div>
                <div class="flex-1 text-left">
                    <p class="text-xs text-slate-400 uppercase tracking-wider mb-1">Terakhir Scan</p>
                    <h3 id="scanName" class="font-bold text-white text-lg leading-tight">User Name</h3>
                    <p id="scanTime" class="text-sm text-slate-300 font-mono mt-1">12:30:45</p>
                </div>
                <div id="scanType" class="px-4 py-2 rounded-lg font-bold text-sm bg-green-500/20 text-green-400 border border-green-500/30">
                    Check In
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-8">
        <a href="{{ route('dashboard') }}" class="glass-btn flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Dashboard</span>
        </a>
    </div>

</div>

<!-- Styles for specific scanner overrides -->
<style>
    #reader video { object-fit: cover; width: 100% !important; height: 100% !important; border-radius: 1rem; }
    /* #reader__scan_region { display: none; } Removed to fix black screen */
    @keyframes scan {
        0% { top: 0%; opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { top: 100%; opacity: 0; }
    }
    .animate-scan {
        animation: scan 2s cubic-bezier(0.4, 0, 0.2, 1) infinite;
    }
</style>

<!-- HTML5-QRCode Library -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js" type="text/javascript"></script>
<script>
    const csrfToken = "{{ csrf_token() }}";
    let html5QrCode;
    
    // Config
    const config = { fps: 10, qrbox: { width: 250, height: 250 } };
    
    // Start scanning on load
    document.addEventListener("DOMContentLoaded", function() {
        startScanning();
    });

    function startScanning() {
        html5QrCode = new Html5Qrcode("reader");
        
        // Prefer back camera
        const cameraIdOrConfig = { facingMode: "environment" };
        
        html5QrCode.start(
            cameraIdOrConfig, 
            config, 
            onScanSuccess, 
            onScanFailure
        ).catch(err => {
            console.error("Error starting scanner:", err);
            document.getElementById('result').innerHTML = `
                <div class="text-red-400 text-center">
                    <p class="mb-2"><i class="fas fa-camera-slash text-2xl"></i></p>
                    <p>Gagal mengakses kamera.</p>
                    <p class="text-xs text-slate-500 mt-1">${err}</p>
                    <button onclick="startScanning()" class="mt-3 px-3 py-1 bg-blue-600 rounded text-xs text-white">Coba Lagi</button>
                </div>
            `;
        });
    }

    function onScanSuccess(decodedText, decodedResult) {
        if(window.isScanningProcessing) return;
        
        // Play sound
        // const audio = new Audio('/sounds/beep.mp3'); 
        // audio.play().catch(e => {}); 

        window.isScanningProcessing = true;

        // Visual feedback
        const resultDiv = document.getElementById('result');
        resultDiv.innerHTML = `<div class="flex items-center gap-2 text-blue-400"><i class="fas fa-circle-notch fa-spin"></i> Memproses...</div>`;
        
        // Pause scanning temporarily
        html5QrCode.pause();

        fetch('{{ route("absensis.storeScan") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ kode_karyawan: decodedText })
        })
        .then(response => response.json())
        .then(data => {
            const lastScanDiv = document.getElementById('lastScanInfo');
            
            if (data.status === 'success') {
                // Success Badge
                resultDiv.innerHTML = `
                    <div class="px-4 py-2 rounded-lg bg-green-500/20 border border-green-500/30 text-green-400 flex items-center gap-2">
                        <i class="fas fa-check-circle"></i> ${data.message}
                    </div>
                `;
                
                // Update Info Panel
                document.getElementById('scanName').innerText = data.karyawan;
                document.getElementById('scanInitial').innerText = data.karyawan.charAt(0).toUpperCase();
                document.getElementById('scanTime').innerText = data.time;
                
                const typeEl = document.getElementById('scanType');
                if(data.type === 'in') {
                    typeEl.innerText = 'Check In';
                    typeEl.className = 'px-4 py-2 rounded-lg font-bold text-sm bg-green-500/20 text-green-400 border border-green-500/30';
                } else {
                    typeEl.innerText = 'Check Out';
                    typeEl.className = 'px-4 py-2 rounded-lg font-bold text-sm bg-yellow-500/20 text-yellow-400 border border-yellow-500/30';
                }
                
                lastScanDiv.classList.remove('hidden');
                
            } else {
                // Error Badge
                resultDiv.innerHTML = `
                    <div class="px-4 py-2 rounded-lg bg-red-500/20 border border-red-500/30 text-red-400 flex items-center gap-2">
                        <i class="fas fa-exclamation-circle"></i> ${data.message}
                    </div>
                `;
            }

            // Resume scanning after delay
            setTimeout(() => { 
                window.isScanningProcessing = false; 
                html5QrCode.resume();
                resultDiv.innerHTML = '<div class="text-slate-500 text-sm animate-pulse">Menunggu scan...</div>';
            }, 3000);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('result').innerHTML = `<div class="text-red-400">Terjadi kesalahan sistem.</div>`;
            window.isScanningProcessing = false;
            html5QrCode.resume();
        });
    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // console.warn(`Code scan error = ${error}`);
    }
</script>
@endsection
