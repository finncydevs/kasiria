<div id="universal-modal" class="fixed inset-0 z-[100] hidden items-center justify-center">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity opacity-0" id="modal-backdrop"></div>

    <!-- Modal Content -->
    <div class="relative bg-[#1e293b]/90 border border-white/10 rounded-2xl shadow-2xl w-full max-w-md mx-4 transform scale-95 opacity-0 transition-all duration-300 p-6" id="modal-content">
        <!-- Icon -->
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-500/20 mb-4" id="modal-icon-bg">
            <i class="fas fa-info-circle text-blue-400 text-xl" id="modal-icon"></i>
        </div>

        <!-- Text -->
        <div class="text-center">
            <h3 class="text-lg font-medium leading-6 text-white mb-2" id="modal-title">Konfirmasi</h3>
            <p class="text-sm text-slate-400" id="modal-message">
                Apakah Anda yakin ingin melakukan tindakan ini?
            </p>
        </div>

        <!-- Actions -->
        <div class="mt-6 flex gap-3 justify-center" id="modal-actions">
            <button type="button" class="glass-btn bg-white/5 hover:bg-white/10 text-slate-300 w-full justify-center" onclick="closeModal()">
                Batal
            </button>
            <button type="button" id="modal-confirm-btn" class="glass-btn bg-blue-600 hover:bg-blue-500 text-white w-full justify-center shadow-lg shadow-blue-500/30">
                Ya, Lanjutkan
            </button>
        </div>
    </div>
</div>

<script>
    // Modal State
    let onConfirmCallback = null;
    const modal = document.getElementById('universal-modal');
    const backdrop = document.getElementById('modal-backdrop');
    const content = document.getElementById('modal-content');
    const titleEl = document.getElementById('modal-title');
    const messageEl = document.getElementById('modal-message');
    const iconEl = document.getElementById('modal-icon');
    const iconBgEl = document.getElementById('modal-icon-bg');
    const confirmBtn = document.getElementById('modal-confirm-btn');
    const cancelBtn = modal.querySelector('button[onclick="closeModal()"]');

    function showConfirm(message, callback, title = 'Konfirmasi', type = 'warning') {
        onConfirmCallback = callback;
        
        // Setup UI based on type
        setupModalUI(type, title, message);
        
        // Show buttons for confirm
        cancelBtn.classList.remove('hidden');
        confirmBtn.classList.remove('hidden');
        confirmBtn.onclick = function() {
            if (onConfirmCallback) onConfirmCallback();
            closeModal();
        };

        openModal();
    }

    function showAlert(message, title = 'Informasi', type = 'info') {
        // Setup UI
        setupModalUI(type, title, message);

        // Hide cancel, change confirm to "OK"
        cancelBtn.classList.add('hidden');
        confirmBtn.classList.remove('hidden');
        confirmBtn.innerText = 'OK';
        confirmBtn.onclick = closeModal;

        openModal();
    }

    function setupModalUI(type, title, message) {
        titleEl.innerText = title;
        messageEl.innerText = message;
        confirmBtn.innerText = 'Ya, Lanjutkan';

        // Reset styles
        iconEl.className = 'fas text-xl';
        iconBgEl.className = 'mx-auto flex h-12 w-12 items-center justify-center rounded-full mb-4';
        confirmBtn.className = 'glass-btn w-full justify-center shadow-lg text-white';

        if (type === 'danger' || type === 'delete') {
            iconEl.classList.add('fa-exclamation-triangle', 'text-red-400');
            iconBgEl.classList.add('bg-red-500/20');
            confirmBtn.classList.add('bg-red-600', 'hover:bg-red-500', 'shadow-red-500/30');
        } else if (type === 'success') {
            iconEl.classList.add('fa-check-circle', 'text-emerald-400');
            iconBgEl.classList.add('bg-emerald-500/20');
            confirmBtn.classList.add('bg-emerald-600', 'hover:bg-emerald-500', 'shadow-emerald-500/30');
        } else if (type === 'info') {
            iconEl.classList.add('fa-info-circle', 'text-blue-400');
            iconBgEl.classList.add('bg-blue-500/20');
            confirmBtn.classList.add('bg-blue-600', 'hover:bg-blue-500', 'shadow-blue-500/30');
        } else {
            // Warning/Default
            iconEl.classList.add('fa-question-circle', 'text-amber-400');
            iconBgEl.classList.add('bg-amber-500/20');
            confirmBtn.classList.add('bg-amber-600', 'hover:bg-amber-500', 'shadow-amber-500/30');
        }
    }

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Animation
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            content.classList.remove('opacity-0', 'scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    function closeModal() {
        backdrop.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            onConfirmCallback = null;
        }, 300);
    }

    // Expose to window
    window.showConfirm = showConfirm;
    window.showAlert = showAlert;

    // Helper for forms
    window.confirmSubmit = function(event, message, title = 'Konfirmasi Hapus', type = 'delete') {
        event.preventDefault();
        const form = event.target;
        showConfirm(message, () => {
            form.submit();
        }, title, type);
        return false;
    };
    
    // Helper for links
    window.confirmAction = function(event, message, href, title = 'Konfirmasi', type = 'warning') {
        event.preventDefault();
        showConfirm(message, () => {
            window.location.href = href;
        }, title, type);
        return false;
    };
</script>
