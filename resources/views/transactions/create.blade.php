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
                        <label class="form-label">Nama Customer (optional)</label>
                        <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="cash">Tunai</option>
                            <option value="card">Kartu</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                </div>

                <h5>Item</h5>
                <div class="table-responsive">
                    <table class="table table-sm" id="items-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Diskon</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="item-row">
                                <td style="width:40%">
                                    <select name="items[][product_id]" class="form-select product-select" required>
                                        <option value="">-- Pilih Produk --</option>
                                        @foreach($products as $p)
                                            <option value="{{ $p->id }}" data-price="{{ $p->price }}">{{ $p->name }} ({{ $p->sku }}) - Rp {{ number_format($p->price,0,',','.') }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="items[][unit_price]" class="form-control unit-price" step="0.01" required>
                                </td>
                                <td>
                                    <input type="number" name="items[][quantity]" class="form-control quantity" value="1" min="1" required>
                                </td>
                                <td>
                                    <input type="number" name="items[][discount]" class="form-control discount" step="0.01" value="0">
                                </td>
                                <td class="text-end subtotal-cell">Rp 0</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger remove-row">×</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-3">
                    <button type="button" id="add-row" class="btn btn-sm btn-outline-primary"><i class="fas fa-plus"></i> Tambah Item</button>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Diskon (total)</label>
                        <input type="number" name="discount" class="form-control" step="0.01" value="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pajak</label>
                        <input type="number" name="tax" class="form-control" step="0.01" value="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jumlah Dibayar</label>
                        <input type="number" name="amount_paid" class="form-control" step="0.01" required>
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control" rows="2"></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function recalcRow($row) {
            var price = parseFloat($row.querySelector('.unit-price').value) || 0;
            var qty = parseFloat($row.querySelector('.quantity').value) || 0;
            var disc = parseFloat($row.querySelector('.discount').value) || 0;
            var subtotal = (price * qty) - disc;
            $row.querySelector('.subtotal-cell').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        }

        function bindRow(row) {
            row.querySelector('.product-select').addEventListener('change', function(e){
                var opt = this.options[this.selectedIndex];
                var price = opt ? opt.getAttribute('data-price') : 0;
                row.querySelector('.unit-price').value = price || '';
                recalcRow(row);
            });
            row.querySelector('.unit-price').addEventListener('input', function(){ recalcRow(row); });
            row.querySelector('.quantity').addEventListener('input', function(){ recalcRow(row); });
            row.querySelector('.discount').addEventListener('input', function(){ recalcRow(row); });
            row.querySelector('.remove-row').addEventListener('click', function(){
                if (document.querySelectorAll('#items-table tbody tr').length > 1) {
                    row.remove();
                } else {
                    // clear
                    row.querySelector('.product-select').value = '';
                    row.querySelector('.unit-price').value = '';
                    row.querySelector('.quantity').value = 1;
                    row.querySelector('.discount').value = 0;
                    recalcRow(row);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function(){
            var add = document.getElementById('add-row');
            var tbody = document.querySelector('#items-table tbody');
            var template = document.querySelector('.item-row');
            bindRow(template);

            add.addEventListener('click', function(){
                var clone = template.cloneNode(true);
                // clear values
                clone.querySelector('.product-select').value = '';
                clone.querySelector('.unit-price').value = '';
                clone.querySelector('.quantity').value = 1;
                clone.querySelector('.discount').value = 0;
                tbody.appendChild(clone);
                bindRow(clone);
            });

            // initial recalc
            document.querySelectorAll('#items-table tbody tr').forEach(function(r){ recalcRow(r); });
        });
    </script>
    @endpush
@endsection
