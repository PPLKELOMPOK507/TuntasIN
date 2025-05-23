@extends('layouts.app')

@section('content')
<div class="container">  <!-- Container ini bikin konten jadi center dan ada padding kiri kanan -->
    <div class="d-flex justify-content-left my-4"> <!-- Membuat tombol center dan beri margin vertical -->
        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary px-4">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
        </a>
    </div>

<div class="container-fluid">
    <div class="balance-card">
        <div class="balance-info">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-1">Saldo Tersedia</p>
                    <h2 class="balance-amount">IDR {{ number_format(auth()->user()->balance, 0, ',', '.') }}</h2>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <div class="balance-actions">
                        <button id="depositBtn" class="btn btn-secondary btn-action me-2" data-bs-toggle="modal" data-bs-target="#depositModal">Tambah Saldo</button>
                        <button id="withdrawBtn" class="btn-primary btn-action" data-bs-toggle="modal" data-bs-target="#withdrawModal">Tarik Dana</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="balance-tabs">
            <div class="balance-tab active">Riwayat Saldo</div>
        </div>
    <div class="transaction-body">
        @forelse ($withdrawals as $withdrawal)
            <div class="transaction-item shadow-sm p-3 mb-3 bg-white rounded d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="icon bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                        <i class="fas fa-wallet wallet-icon" style="color: #dc3545; font-size: 20px;"></i>
                    </div>
                    <div>
                        <p class="mb-1 fw-semibold">{{ strtoupper($withdrawal->method) }} ke {{ $withdrawal->destination }}</p>
                        <small class="text-muted">IDR {{ number_format($withdrawal->amount, 0, ',', '.') }}</small>
                    </div>
                </div>
                <div class="text-end">
                    <p class="mb-1 text-danger fw-bold">-IDR {{ number_format($withdrawal->amount, 0, ',', '.') }}</p>
                    <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $withdrawal->created_at->format('d M Y') }}</small>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <p>Belum ada riwayat transaksi</p>
            </div>
        @endforelse
    </div>
    </div>
</div>

<!-- Withdraw Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-side-right">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="withdrawModalLabel">Tarik Saldo Anda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="withdrawForm" action="{{ route('account.withdraw') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="withdrawAmount">Masukkan jumlah untuk ditarik</label>
                        <input type="number" min="50000" step="1000" class="form-control" id="withdrawAmount" name="amount" placeholder="0">
                        <small class="form-text text-muted">IDR {{ number_format(auth()->user()->balance, 0, ',', '.') }} tersedia</small>
                    </div>

                    <div class="form-group mb-3">
                    <label class="form-label mb-2">Pilih Metode Penarikan</label>

                    <div class="flex flex-col gap-2">
                        <label class="payment-card">
                            <input type="radio" name="withdraw_method" value="bank" checked onclick="showBankField()">
                            <div class="card-content">
                                <span>🏦</span>
                                <span>Transfer Bank</span>
                            </div>
                        </label>

                        <label class="payment-card">
                            <input type="radio" name="withdraw_method" value="ewallet" onclick="showEwalletField()">
                            <div class="card-content">
                                <span>📱</span>
                                <span>E-Wallet</span>
                            </div>
                        </label>
                    </div>

                    <div id="bankField" class="mt-3">
                        <label for="bankAccount" class="form-label">Nomor Rekening</label>
                        <input 
                            type="text" 
                            id="bankAccount" 
                            name="bank_account" 
                            class="form-control" 
                            placeholder="Masukkan nomor rekening" 
                            maxlength="16" 
                            pattern="[0-9]{16}"
                            title="Nomor rekening harus 16 digit angka" 
                            inputmode="numeric"
                            autocomplete = "off"
                        >
                        <!-- <input type="number" id="bankAccount" name="bank_account" class="form-control" placeholder="Masukkan nomor rekening" maxlength="16" pattern="\d{16}" title="Masukkan 16 digit angka"> -->
                    </div>
                    <div id="ewalletField" class="mt-3" style="display:none">
                        <label for="ewalletPhone" class="form-label">Nomor Telepon</label>
                         <input 
                            type="text" 
                            id="ewalletPhone" 
                            name="ewallet_phone" 
                            class="form-control" 
                            placeholder="Masukkan nomor telepon" 
                            maxlength="12" 
                            pattern="[0-9]{12}" 
                            title="Nomor telepon harus 12 digit angka" 
                            inputmode="numeric"
                            autocomplete = "off"
                        >
                    </div>
                </div>
            
                    <div class="action-buttons">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-submit" id="submitWithdraw">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Deposit Modal -->
<div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="depositModalLabel">Tambah Saldo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('account.deposit') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="depositAmount">Jumlah Saldo</label>
                        <input type="number" min="10000" class="form-control" name="amount" id="depositAmount" placeholder="Masukkan jumlah saldo" required>
                        <small class="form-text text-muted">Minimal IDR 10.000</small>
                    </div>
                    <div class="action-buttons">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-submit">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link href="{{ asset('css/balance.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const withdrawModal = document.getElementById('withdrawModal');
    const bankField = document.getElementById('bankField');
    const ewalletField = document.getElementById('ewalletField');
    const bankInput = document.getElementById('bankAccount');
    const ewalletInput = document.getElementById('ewalletPhone');

    function showBankField() {
        bankField.style.display = 'block';
        ewalletField.style.display = 'none';

        bankInput.disabled = false;
        ewalletInput.disabled = true;

        bankInput.readOnly = false;
        ewalletInput.readOnly = true;

        bankInput.value = bankInput.value.trim();
        ewalletInput.value = ''; // bersihkan kalau perlu
    }

    function showEwalletField() {
        bankField.style.display = 'none';
        ewalletField.style.display = 'block';

        bankInput.disabled = true;
        ewalletInput.disabled = false;

        bankInput.readOnly = true;
        ewalletInput.readOnly = false;

        ewalletInput.value = ewalletInput.value.trim();
        bankInput.value = ''; // bersihkan kalau perlu
    }

    function toggleFields() {
        const selectedMethod = document.querySelector('input[name="withdraw_method"]:checked').value;
        if (selectedMethod === 'bank') {
            showBankField();
        } else {
            showEwalletField();
        }
    }

    withdrawModal.addEventListener('shown.bs.modal', function () {
        const radios = withdrawModal.querySelectorAll('input[name="withdraw_method"]');
        radios.forEach(radio => {
            radio.addEventListener('change', toggleFields);
        });
        toggleFields(); // initial call
    });
});
</script>
@endpush