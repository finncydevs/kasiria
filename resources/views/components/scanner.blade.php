<div id="scanner-container" class="mb-3 hidden">
    <div id="reader" style="width: 100%;"></div>
    <button type="button" class="btn btn-sm btn-danger mt-2" onclick="stopScanner()">Stop Scanner</button>
</div>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrcodeScanner = null;

    function startScanner() {
        document.getElementById('scanner-container').classList.remove('hidden');
        
        if (html5QrcodeScanner) {
            // Already running
            return;
        }

        html5QrcodeScanner = new Html5Qrcode("reader");
        const config = { fps: 10, qrbox: 250 };
        
        html5QrcodeScanner.start({ facingMode: "environment" }, config, onScanSuccess)
        .catch(err => {
            console.error("Error starting scanner", err);
            alert("Error starting scanner: " + err);
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
        // Handle the scanned code
        console.log(`Code matched = ${decodedText}`, decodedResult);
        
        // Dispatch custom event
        const event = new CustomEvent('code-scanned', { detail: decodedText });
        document.dispatchEvent(event);
        
        // Optional: Stop after scan? Or keep scanning?
        // Let's keep scanning for continuous entry, but maybe add a delay or sound.
        // For now, let's just flash or confirm.
        alert("Scanned: " + decodedText);
    }
</script>
@endpush
