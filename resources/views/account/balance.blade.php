@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="balance-card">
        <div class="balance-info">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-1">Saldo Tersedia</p>
                    <h2 class="balance-amount">IDR {{ number_format(Auth::user()->balance ?? 0, 0, ',', '.') }}</h2>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <div class="balance-actions">
                        <button id="withdrawBtn" class="btn-primary btn-action" data-bs-toggle="modal" data-bs-target="#withdrawModal">Tarik Dana</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="balance-tabs">
            <div class="balance-tab active">Riwayat Saldo</div>
        </div>
        <div class="transaction-body">
            <div class="empty-state">
                <p>Belum ada riwayat transaksi</p>
            </div>
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
                <form id="withdrawForm" action="{{ route('account.withdraw') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="withdrawAmount">Masukkan jumlah untuk ditarik</label>
                        <input type="text" class="form-control" id="withdrawAmount" name="amount" placeholder="0">
                        <small class="form-text text-muted">IDR {{ number_format(Auth::user()->balance ?? 0, 0, ',', '.') }} tersedia</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="bankAccount">Penarikan ke</label>
                        <div class="bank-select">
                            <div>
                                ID_BCA<br>
                                <span class="account-number">3491266986</span><br>
                                Gabriel
                            </div>
                            <span class="chevron-down">▼</span>
                        </div>
                    </div>

                    <button type="button" class="add-bank-btn">
                        <span class="plus-icon">+</span> Tambahkan rekening bank Anda
                    </button>

                    <div class="withdraw-settings">
                        <input type="checkbox" id="withdrawSettings" name="withdraw_settings">
                        <label for="withdrawSettings">Pengaturan Tarik Dana</label>
                    </div>

                    <div class="action-buttons">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-submit" id="submitWithdraw" disabled>Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background-color: #f5f5f5;
    }

    .container-fluid {
        max-width: 1200px;
        padding: 20px;
    }

    .balance-card {
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .balance-header {
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }

    .balance-info {
        padding: 10px 0;
        margin-bottom: 20px;
    }

    .balance-amount {
        font-size: 24px;
        font-weight: bold;
        margin: 8px 0;
    }

    .balance-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-action {
        background-color: #2563eb !important;
        color: white !important;
        border: none;
        padding: 10px 30px;
        border-radius: 4px;
        font-weight: 500;
        min-width: 150px;
    }

    .link-text {
        color: #0d6efd;
        text-decoration: none;
    }

    .link-text:hover {
        text-decoration: underline;
    }

    .balance-tabs {
        display: flex;
        border-bottom: 1px solid #eee;
        margin-bottom: 15px;
    }

    .balance-tab {
        padding: 10px 15px;
        cursor: pointer;
    }

    .balance-tab.active {
        border-bottom: 2px solid #0d6efd;
        color: #0d6efd;
        font-weight: 500;
    }

    .transaction-filters {
        padding: 10px 0;
    }

    .btn-outline {
        border: 1px solid #ddd;
        background: white;
        padding: 6px 12px;
        border-radius: 4px;
    }

    .transaction-header {
        font-weight: 500;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .empty-state {
        text-align: center;
        padding: 30px 0;
        color: #6c757d;
    }

    /* Modal and Withdraw section styles */
    .modal-dialog.modal-sm {
        max-width: 380px;
        margin: auto;
    }


    .modal-side-right {
        position: fixed !important;
        right: 0;
        top: 0;
        margin: 0  !important;
        width: 400px;
        max-width: 100vw;
        height: 100vh;
        transform: translateX(100%);
        transition: transform 0.3s ease-out;
    }
    
    .modal-side-right.show {
        transform: translateX(0);
    }
    
    .modal-side-right .modal-content {
        height: 100vh;
        border-radius: 0;
        border-left: 1px solid #ddd;
        overflow-y: auto;
    }
    
    .modal-side-right .modal-header {
        position: sticky;
        top: 0;
        background: white;
        z-index: 1;
    }
    
    /* Responsive Mobile */
    @media (max-width: 576px) {
        .modal-side-right {
            width: 100vw;
        }
        
        .modal-side-right .modal-content {
            border-left: none;
        }
    }
    
    /* Override default modal positioning */
    .modal.fade .modal-side-right {
        transition: transform 0.3s ease-out;
    }

    /* Pastikan modal muncul tepat di tengah vertikal */
    .modal-dialog-centered {
        display: flex;
        align-items: center;
        min-height: calc(100% - 1rem);
    }

    .modal-content {
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border: none;
    }

    .modal-header {
        border-bottom: none;
        padding: 15px 20px 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        font-weight: 500;
        font-size: 1rem;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
        padding: 0;
        opacity: 0.5;
    }

    .modal-body {
        padding: 5px 20px 20px;
    }

    .info-box {
        background-color: #e8f0fe;
        border-radius: 6px;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        font-size: 0.9rem;
        margin-bottom: 15px;
    }

    .info-icon {
        color: #0d6efd;
        margin-right: 8px;
        font-size: 1.1rem;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .form-text {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 5px;
        display: block;
    }

    .bank-select {
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 10px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .account-number {
        color: #6c757d;
    }

    .chevron-down {
        color: #6c757d;
        font-size: 0.7rem;
    }

    .add-bank-btn {
        width: 100%;
        text-align: center;
        padding: 10px;
        border: 1px dashed #0d6efd;
        border-radius: 6px;
        background: none;
        color: #0d6efd;
        margin: 15px 0;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .plus-icon {
        color: #0d6efd;
        margin-right: 5px;
    }

    .withdraw-settings {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }

    .withdraw-settings input {
        margin-right: 8px;
    }

    .action-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .btn-cancel {
        flex: 1;
        margin-right: 10px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: white;
        color: #333;
        cursor: pointer;
        font-weight: 500;
    }

    .btn-submit {
        flex: 1;
        margin-left: 10px;
        padding: 10px;
        border: none;
        border-radius: 6px;
        background: #f0f0f0;
        color: #999;
        cursor: not-allowed;
        font-weight: 500;
    }

    .btn-submit.active {
        background-color: #0d6efd;
        color: white;
        cursor: pointer;
    }

    @media (max-width: 576px) {
        .modal-dialog.modal-sm {
            margin: 10px;
            max-width: calc(100% - 20px);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const withdrawAmount = document.getElementById('withdrawAmount');
        const submitButton = document.getElementById('submitWithdraw');

        withdrawAmount.addEventListener('input', function () {
            // Hanya angka
            const amount = parseFloat(this.value.replace(/[^0-9]/g, ''));
            const balance = {{ Auth::user()->balance ?? 0 }};

            if (amount > 0 && amount <= balance) {
                submitButton.classList.add('active');
                submitButton.disabled = false;
            } else {
                submitButton.classList.remove('active');
                submitButton.disabled = true;
            }
        });
    });
</script>
@endpush
