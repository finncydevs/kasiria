@extends('layouts.app')

@section('title', 'Buat Transaksi - Kasiria')
@section('page_title', 'Buat Transaksi')

@section('breadcrumb')
    <li class="flex items-center">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center">
        <a href="{{ route('transactions.index') }}" class="hover:text-blue-400 transition-colors">Transaksi</a>
        <i class="fas fa-chevron-right text-xs mx-2"></i>
    </li>
    <li class="flex items-center text-slate-200">
        Buat
    </li>
@endsection

@section('content')
    <div class="glass-panel">
        <div class="flex items-center gap-3 mb-6 border-b border-white/10 pb-4">
            <div class="p-3 bg-blue-500/10 rounded-xl text-blue-400">
                <i class="fas fa-cash-register text-xl"></i>
            </div>
            <h2 class="text-xl font-semibold text-white">Transaksi Baru</h2>
        </div>

        {{-- Error Display --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl">
                <ul class="mb-0 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('transactions.store') }}" method="POST" id="transaction-form">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">No. Transaksi</label>
                    <input type="text" class="glass-input w-full bg-white/5 opacity-75 cursor-not-allowed" value="{{ $transactionNumber }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Pelanggan (Optional)</label>
                    <select name="pelanggan_id" class="glass-input w-full">
                        <option value="" class="text-slate-800">-- Tidak Ada --</option>
                        @foreach($pelanggans as $p)
                            <option value="{{ $p->id }}" {{ old('pelanggan_id') == $p->id ? 'selected' : '' }} class="text-slate-800">
                                {{ $p->nama }} ({{ $p->no_hp ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-2">Metode Pembayaran</label>
                    <select name="payment_method" class="glass-input w-full" required>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }} class="text-slate-800">Tunai</option>
                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }} class="text-slate-800">Kartu</option>
                        <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }} class="text-slate-800">Lainnya</option>
                    </select>
                </div>
            </div>

            <div class="mb-2 flex items-center justify-between">
                <h5 class="text-lg font-medium text-white">Item Transaksi</h5>
                <button type="button" id="add-row" class="glass-btn text-sm px-3 py-1.5 flex items-center gap-2 text-blue-400 hover:text-blue-300">
                    <i class="fas fa-plus"></i> Tambah Item
                </button>
            </div>

            <div class="overflow-x-auto mb-6 rounded-xl border border-white/10">
                <table class="w-full text-left" id="items-table">
                    <thead class="bg-white/5 text-xs text-slate-400 uppercase tracking-wider">
                        <tr>
                            <th class="p-4 w-[35%]">Produk</th>
                            <th class="p-4 w-[15%]">Harga</th>
                            <th class="p-4 w-[10%]">Qty</th>
                            <th class="p-4 w-[15%]">Diskon Item</th>
                            <th class="p-4 w-[20%] text-right">Subtotal</th>
                            <th class="p-4 w-[5%] text-center">Act</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        {{-- Initial Row --}}
                        <tr class="item-row hover:bg-white/5 transition-colors">
                            <td class="p-3">
                                <select name="items[0][product_id]" class="glass-input w-full product-select text-sm p-2 bg-transparent" required>
                                    <option value="" class="text-slate-800">-- Pilih Produk --</option>
                                    @foreach($products as $p)
                                        <option value="{{ $p->id }}" data-price="{{ $p->harga_jual }}" data-barcode="{{ $p->kode_barcode ?? '' }}" class="text-slate-800">
                                            {{ $p->nama_produk }} (Stok: {{ $p->stok }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-3">
                                <input type="number" name="items[0][unit_price]" class="glass-input w-full unit-price text-right text-sm p-2 bg-white/5" step="0.01" readonly>
                            </td>
                            <td class="p-3">
                                <input type="number" name="items[0][quantity]" class="glass-input w-full quantity text-center text-sm p-2" value="1" min="1" required>
                            </td>
                            <td class="p-3">
                                <input type="number" name="items[0][discount]" class="glass-input w-full discount text-right text-sm p-2" step="0.01" value="0">
                            </td>
                            <td class="p-3 text-right subtotal-cell font-bold text-emerald-400 group-hover:text-emerald-300">Rp 0</td>
                            <td class="p-3 text-center">
                                <button type="button" class="text-red-400 hover:text-red-300 hover:bg-red-500/10 p-2 rounded-lg transition-colors remove-row">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Scanner Section -->
                <div class="glass-panel bg-white/5 !p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h6 class="text-white font-medium flex items-center gap-2">
                            <i class="fas fa-qrcode text-purple-400"></i> Barcode Scanner
                        </h6>
                        <button type="button" class="glass-btn text-xs px-3 py-1.5" onclick="startScanner()">
                            <i class="fas fa-camera mr-1"></i> Start
                        </button>
                    </div>
                    <div class="rounded-lg overflow-hidden border border-white/10 bg-black/20 min-h-[150px] flex items-center justify-center relative">
                        <x-scanner />
                    </div>
                </div>

                <!-- Totals Section -->
                <div class="glass-panel bg-white/5 !p-6">
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-slate-400">
                            <label>Subtotal</label>
                            <input type="text" id="display-subtotal" class="bg-transparent text-right font-medium text-slate-200 border-none focus:ring-0 p-0 w-40" value="Rp 0" readonly>
                        </div>
                        <div class="flex justify-between items-center text-slate-400">
                            <label>Diskon Global</label>
                            <input type="number" name="discount" id="global-discount" class="glass-input w-32 text-right p-1 text-sm h-8" value="0" min="0">
                        </div>
                        <div class="flex justify-between items-center text-slate-400">
                            <label>Pajak</label>
                            <input type="number" name="tax" id="global-tax" class="glass-input w-32 text-right p-1 text-sm h-8" value="0" min="0">
                        </div>
                        
                        <div class="my-4 border-t border-white/10"></div>
                        
                        <div class="flex justify-between items-center">
                            <label class="text-lg font-bold text-white">Total Akhir</label>
                            <div class="text-right">
                                <input type="text" id="display-total" class="bg-transparent text-right font-bold text-2xl text-blue-400 border-none focus:ring-0 p-0 w-full" value="Rp 0" readonly>
                                <input type="hidden" id="real-total" value="0">
                            </div>
                        </div>
                        
                        <div class="my-4 border-t border-white/10"></div>

                        <div class="flex justify-between items-center mb-2">
                            <label class="font-medium text-slate-300">Jumlah Dibayar</label>
                            <input type="number" name="amount_paid" id="amount-paid" class="glass-input w-48 text-right p-2 text-lg font-bold text-emerald-400" required>
                        </div>
                        <div class="flex justify-between items-center">
                            <label class="text-slate-400">Kembalian</label>
                            <input type="text" id="change" class="bg-transparent text-right font-bold text-xl text-emerald-400 border-none focus:ring-0 p-0 w-40" value="Rp 0" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 mb-4">
                <button type="button" class="flex items-center gap-2 text-slate-400 hover:text-white transition-colors text-sm mb-2" onclick="document.getElementById('notes-container').classList.toggle('hidden')">
                    <i class="fas fa-sticky-note"></i> Tambah Catatan (Opsional)
                </button>
                <div id="notes-container" class="hidden">
                    <textarea name="notes" class="glass-input w-full" rows="2" placeholder="Catatan transaksi..."></textarea>
                </div>
            </div>

            <div class="fixed bottom-0 left-0 right-0 p-4 bg-slate-900/90 backdrop-blur-md border-t border-white/10 z-50 lg:pl-72 flex justify-end gap-3 shadow-2xl">
                <a href="{{ route('transactions.index') }}" class="px-6 py-2.5 rounded-xl border border-white/10 text-slate-300 hover:bg-white/5 transition-colors font-medium">
                    Batal
                </a>
                
                {{-- Hidden field to track payment option --}}
                <input type="hidden" id="payment_option" name="payment_option" value="save_only">

                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white shadow-lg shadow-blue-500/20 font-medium transition-all" onclick="document.getElementById('payment_option').value='save_only'">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white shadow-lg shadow-emerald-500/20 font-bold transition-all" onclick="document.getElementById('payment_option').value='pay_now'">
                    <i class="fas fa-check-circle mr-2"></i> Bayar & Simpan
                </button>
            </div>
            
            {{-- Spacer for fixed bottom bar --}}
            <div class="h-20"></div>

        </form>
    </div>

    @push('scripts')
    <script>
        function formatRupiah(angka) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
        }

        // Updates the index (0, 1, 2) for name attributes
        function updateRowIndices() {
            const rows = document.querySelectorAll('#items-table tbody tr');
            rows.forEach((row, index) => {
                row.querySelector('.product-select').name = `items[${index}][product_id]`;
                row.querySelector('.unit-price').name = `items[${index}][unit_price]`;
                row.querySelector('.quantity').name = `items[${index}][quantity]`;
                row.querySelector('.discount').name = `items[${index}][discount]`;
            });
        }

        function recalcRow(row) {
            const price = parseFloat(row.querySelector('.unit-price').value) || 0;
            const qty = parseFloat(row.querySelector('.quantity').value) || 0;
            const disc = parseFloat(row.querySelector('.discount').value) || 0;

            let subtotal = (price * qty) - disc;
            if(subtotal < 0) subtotal = 0;

            row.querySelector('.subtotal-cell').textContent = formatRupiah(subtotal);
            row.querySelector('.subtotal-cell').dataset.value = subtotal; // Store raw value

            recalcGrandTotal();
        }

        function recalcGrandTotal() {
            let subtotalAll = 0;
            document.querySelectorAll('.subtotal-cell').forEach(cell => {
                subtotalAll += parseFloat(cell.dataset.value) || 0;
            });

            const globalDisc = parseFloat(document.getElementById('global-discount').value) || 0;
            const globalTax = parseFloat(document.getElementById('global-tax').value) || 0;

            const grandTotal = subtotalAll - globalDisc + globalTax;

            document.getElementById('display-subtotal').value = formatRupiah(subtotalAll);
            document.getElementById('display-total').value = formatRupiah(grandTotal);
            document.getElementById('real-total').value = grandTotal;

            calcChange();
        }

        function calcChange() {
            const total = parseFloat(document.getElementById('real-total').value) || 0;
            const paid = parseFloat(document.getElementById('amount-paid').value) || 0;
            // Allow negative change? usually no, but just display logic here.
            const change = paid - total;

            document.getElementById('change').value = formatRupiah(change);
        }

        document.addEventListener('DOMContentLoaded', function(){
            const tbody = document.querySelector('#items-table tbody');

            // Event Delegation for Calculation
            tbody.addEventListener('input', function(e) {
                if (e.target.matches('.quantity, .discount')) {
                    recalcRow(e.target.closest('tr'));
                }
            });

            // Event Delegation for Product Selection
            tbody.addEventListener('change', function(e) {
                if (e.target.matches('.product-select')) {
                    const row = e.target.closest('tr');
                    const option = e.target.options[e.target.selectedIndex];
                    const price = option.getAttribute('data-price') || 0;

                    row.querySelector('.unit-price').value = price;
                    recalcRow(row);
                }
            });

            // Event Delegation for Remove Row
            tbody.addEventListener('click', function(e) {
                if (e.target.closest('.remove-row')) {
                    const row = e.target.closest('tr');
                    if (tbody.querySelectorAll('tr').length > 1) {
                        row.remove();
                        updateRowIndices(); // IMPORTANT: Fix indices after delete
                        recalcGrandTotal();
                    } else {
                        // Could use a custom toast here
                        alert("Minimal satu item.");
                    }
                }
            });

            // Global inputs
            document.getElementById('global-discount').addEventListener('input', recalcGrandTotal);
            document.getElementById('global-tax').addEventListener('input', recalcGrandTotal);
            document.getElementById('amount-paid').addEventListener('input', calcChange);

            // Add Row Logic
            document.getElementById('add-row').addEventListener('click', function() {
                addNewRow();
            });

            function addNewRow() {
                const firstRow = tbody.querySelector('tr');
                const newRow = firstRow.cloneNode(true);

                // Clear inputs
                newRow.querySelector('.product-select').value = '';
                newRow.querySelector('.unit-price').value = '';
                newRow.querySelector('.quantity').value = 1;
                newRow.querySelector('.discount').value = 0;
                newRow.querySelector('.subtotal-cell').textContent = 'Rp 0';
                newRow.querySelector('.subtotal-cell').dataset.value = 0;

                tbody.appendChild(newRow);
                updateRowIndices(); // IMPORTANT: Fix indices after add
                return newRow;
            }

            // Listen for Barcode Scan
            document.addEventListener('code-scanned', function(e) {
                const code = e.detail;
                
                let foundInRow = false;
                const rows = tbody.querySelectorAll('tr');
                
                // Helper to find option by barcode
                const referenceSelect = document.querySelector('.product-select');
                let targetOption = null;
                for (let opt of referenceSelect.options) {
                    if (opt.getAttribute('data-barcode') === code) {
                        targetOption = opt;
                        break;
                    }
                }
                
                if (!targetOption) {
                    // Use a toast or styled alert ideally, but alert is fine for now
                    alert("Produk tidak ditemukan untuk barcode: " + code);
                    return;
                }
                
                const productId = targetOption.value;

                // Check existing rows
                for (let row of rows) {
                    const select = row.querySelector('.product-select');
                    if (select.value === productId) {
                        // Found, increment qty
                        const qtyInput = row.querySelector('.quantity');
                        qtyInput.value = parseInt(qtyInput.value) + 1;
                        recalcRow(row);
                        foundInRow = true;
                        
                        // Visual feedback (glass style)
                        const originalBg = row.style.backgroundColor;
                        row.style.backgroundColor = 'rgba(59, 130, 246, 0.2)'; // blue tint
                        setTimeout(() => row.style.backgroundColor = originalBg, 500);
                        break;
                    }
                }

                if (!foundInRow) {
                    // Not in list, find empty row or add new
                    let targetRow = null;
                    for (let row of rows) {
                        const select = row.querySelector('.product-select');
                        if (!select.value) {
                            targetRow = row;
                            break;
                        }
                    }

                    if (!targetRow) {
                        targetRow = addNewRow();
                    }

                    // Select the product
                    const select = targetRow.querySelector('.product-select');
                    select.value = productId;
                    
                    // Trigger change to update price
                    select.dispatchEvent(new Event('change', { bubbles: true }));
                    
                    // Visual feedback
                    const originalBg = targetRow.style.backgroundColor;
                    targetRow.style.backgroundColor = 'rgba(16, 185, 129, 0.2)'; // emerald tint
                    setTimeout(() => targetRow.style.backgroundColor = originalBg, 500);
                }
            });
        });
    </script>
    @endpush
@endsection
