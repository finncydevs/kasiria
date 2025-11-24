@extends('layouts.admin')

@section('title', 'Pembayaran Transaksi')

@section('content')
<div class="card">
    <div class="card-header">Pembayaran Transaksi #{{ $transaction->transaction_number }}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <h5 class="mb-3">Ringkasan Transaksi</h5>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->items as $item)
                            <tr>
                                <td>{{ optional($item->product)->nama_produk ?? 'Produk' }}</td>
                                <td class="text-end">{{ $item->quantity }}</td>
                                <td class="text-end">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($item->total ?? $item->subtotal ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
                <div class="text-end">
                    <div class="mb-2">Subtotal: <strong>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</strong></div>
                    <div class="mb-2">Diskon: <strong>-Rp {{ number_format($transaction->discount ?? 0, 0, ',', '.') }}</strong></div>
                    <div class="mb-2">Pajak: <strong>+Rp {{ number_format($transaction->tax ?? 0, 0, ',', '.') }}</strong></div>
                    <div class="mb-3"><h5>Total: <strong class="text-primary">Rp {{ number_format($transaction->total, 0, ',', '.') }}</strong></h5></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="mb-3">Metode Pembayaran</h6>
                        <p class="mb-3">
                            <strong>{{ ucfirst($transaction->payment_method) }}</strong>
                        </p>

                        <button type="button" id="pay-button" class="btn btn-success w-100 mb-2">
                            <i class="fas fa-lock"></i> Lanjutkan Pembayaran
                        </button>

                        <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-secondary w-100 btn-sm">
                            Kembali
                        </a>

                        <div class="mt-3 small text-muted">
                            <p>Pembayaran diproses melalui Midtrans dengan keamanan tingkat enterprise.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Midtrans Snap Script -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        // Trigger snap payment popup
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                // Payment success
                console.log('Payment successful:', result);
                alert('Pembayaran berhasil! Transaksi sedang diproses.');
                window.location.href = "{{ route('transactions.show', $transaction) }}";
            },
            onPending: function(result){
                console.log('Payment pending:', result);
                alert('Pembayaran sedang diproses, silakan selesaikan di browser Anda.');
            },
            onError: function(result){
                console.log('Payment error:', result);
                alert('Pembayaran gagal! Silakan coba lagi.');
            },
            onClose: function(){
                console.log('Payment popup closed');
            }
        });
    });
</script>
@endsection
