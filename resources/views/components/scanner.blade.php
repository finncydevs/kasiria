<div id="scanner-container" class="mb-3 hidden">
    <div id="reader" style="width: 100%; min-height: 300px; background-color: #000;"></div>
    <!-- <div id="scanner-debug-log" class="text-xs text-red-400 font-mono mt-2 p-2 bg-black/50 overflow-auto h-24 hidden"></div> -->
    <button type="button" class="btn btn-sm btn-danger mt-2" onclick="stopScanner()">Stop Scanner</button>
</div>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js" type="text/javascript"></script>
<script>
    let html5QrcodeScanner = null;
    
    function logDebug(message) {
        console.log("[Scanner]", message);
        // Debug UI disabled for production
    }

    function startScanner() {
        document.getElementById('scanner-container').classList.remove('hidden');
        logDebug("Initializing scanner...");
        
        if (typeof Html5Qrcode === 'undefined') {
            logDebug("ERROR: Html5Qrcode library not loaded!");
            alert("Error: Scanner library failed to load. Check internet connection.");
            return;
        }

        if (html5QrcodeScanner) {
            logDebug("Scanner already running.");
            return;
        }

        try {
            html5QrcodeScanner = new Html5Qrcode("reader");
            logDebug("Instance created.");
        } catch (e) {
            logDebug("Error creating instance: " + e);
            return;
        }
        
        // Use a more robust config for 1D barcodes
        const config = { 
            fps: 10, 
            // Make the scanning box wider for 1D barcodes
            qrbox: { width: 300, height: 150 },
            // aspect ratio removed to use default (full width)
            experimentalFeatures: {
                useBarCodeDetectorIfSupported: true
            }
        };
        
        const formatsToSupport = [ 
            Html5QrcodeSupportedFormats.QR_CODE,
            Html5QrcodeSupportedFormats.EAN_13,
            Html5QrcodeSupportedFormats.EAN_8,
            Html5QrcodeSupportedFormats.CODE_128,
            Html5QrcodeSupportedFormats.CODE_39,
            Html5QrcodeSupportedFormats.UPC_A,
            Html5QrcodeSupportedFormats.UPC_E,
            Html5QrcodeSupportedFormats.CODABAR
        ];

        html5QrcodeScanner.start(
            { facingMode: "environment" }, 
            config, 
            onScanSuccess,
            onScanFailure
        )
        .then(() => {
            logDebug("Camera started successfully.");
        })
        .catch(err => {
            logDebug("Error starting camera: " + err);
            console.error("Error starting scanner", err);
            alert("Gagal memulai kamera: " + err);
            // Don't hide immediately so user can see the log
        });
    }

    function stopScanner() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.stop().then(() => {
                html5QrcodeScanner.clear();
                html5QrcodeScanner = null;
                document.getElementById('scanner-container').classList.add('hidden');
            }).catch(err => {
                console.error("Failed to stop scanner", err);
            });
        } else {
            document.getElementById('scanner-container').classList.add('hidden');
        }
    }

    function onScanSuccess(decodedText, decodedResult) {
        logDebug("Scan Success: " + decodedText);
        // Handle the scanned code
        console.log(`Code matched = ${decodedText}`, decodedResult);
        
        // Dispatch custom event
        const event = new CustomEvent('code-scanned', { detail: decodedText });
        document.dispatchEvent(event);
        
        // Visual feedback
        // alert("Scanned: " + decodedText); // Removed to rely on logs
    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // logDebug("Scan frame skipped/error: " + error); // Too verbose for UI
    }
</script>
@endpush
