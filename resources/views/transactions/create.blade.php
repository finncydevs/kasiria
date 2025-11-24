@extends('layouts.admin')

@section('title', 'Buat Transaksi - Kasiria')
@section('page_title', 'Buat Transaksi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Transaksi</a></li>
    <li class="breadcrumb-item active">Buat</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">Transaksi Baru</div>
        <div class="card-body">
            {{-- Error Display --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('transactions.store') }}" method="POST" id="transaction-form">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">No. Transaksi</label>
                        <input type="text" class="form-control" value="{{ $transactionNumber }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pelanggan (Optional)</label>
                        <select name="pelanggan_id" class="form-select">
                            <option value="">-- Tidak Ada --</option>
                            @foreach($pelanggans as $p)
                                <option value="{{ $p->id }}" {{ old('pelanggan_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }} ({{ $p->no_hp ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Tunai</option>
                            <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Kartu</option>
                            <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                </div>

                <h5>Item</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered" id="items-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 35%">Produk</th>
                                <th style="width: 15%">Harga</th>
                                <th style="width: 10%">Qty</th>
                                <th style="width: 15%">Diskon Item</th>
                                <th style="width: 20%">Subtotal</th>
                                <th style="width: 5%">Act</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Initial Row --}}
                            <tr class="item-row">
                                <td>
                                    {{-- Notice: name="items[0][product_id]" --}}
                                    <select name="items[0][product_id]" class="form-select product-select" required>
                                        <option value="">-- Pilih Produk --</option>
                                        @foreach($products as $p)
                                            <option value="{{ $p->id }}" data-price="{{ $p->harga_jual }}">
                                                {{ $p->nama_produk }} (Stok: {{ $p->stok }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="items[0][unit_price]" class="form-control unit-price" step="0.01" readonly>
                                </td>
                                <td>
                                    <input type="number" name="items[0][quantity]" class="form-control quantity" value="1" min="1" required>
                                </td>
                                <td>
                                    <input type="number" name="items[0][discount]" class="form-control discount" step="0.01" value="0">
                                </td>
                                <td class="text-end subtotal-cell fw-bold">Rp 0</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger remove-row"><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <button type="button" id="add-row" class="btn btn-sm btn-outline-primary mb-3">
                    <i class="fas fa-plus"></i> Tambah Item
                </button>

                <div class="card bg-light border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <div class="mb-2 row">
                                    <label class="col-sm-4 col-form-label">Subtotal</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="display-subtotal" class="form-control-plaintext fw-bold text-end" value="Rp 0" readonly>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-sm-4 col-form-label">Diskon Global</label>
                                    <div class="col-sm-8">
                                        <input type="number" name="discount" id="global-discount" class="form-control text-end" value="0" min="0">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-sm-4 col-form-label">Pajak</label>
                                    <div class="col-sm-8">
                                        <input type="number" name="tax" id="global-tax" class="form-control text-end" value="0" min="0">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-sm-4 col-form-label fw-bold text-primary">Total Akhir</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="display-total" class="form-control-plaintext fw-bold text-end text-primary h5" value="Rp 0" readonly>
                                        {{-- Hidden input for calculation validation if needed --}}
                                        <input type="hidden" id="real-total" value="0">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label fw-bold">Jumlah Dibayar</label>
                                    <div class="col-sm-8">
                                        <input type="number" name="amount_paid" id="amount-paid" class="form-control form-control-lg text-end" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 col-form-label">Kembalian</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="change" class="form-control-plaintext fw-bold text-end text-success" value="Rp 0" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control" rows="2"></textarea>
                </div>

                <!-- Hidden field to track payment option -->
                <input type="hidden" id="payment_option" name="payment_option" value="save_only">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary" onclick="document.getElementById('payment_option').value='save_only'">
                        <i class="fas fa-save"></i> Simpan Transaksi
                    </button>
                    <button type="submit" class="btn btn-success" onclick="document.getElementById('payment_option').value='pay_now'">
                        <i class="fas fa-credit-card"></i> Bayar & Simpan
                    </button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function formatRupiah(angka) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
        }

        // Updates the index (0, 1, 2) for name attributes: items[0][product_id], items[1][product_id]
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
            });
        });
    </script>
    @endpush
@endsection
