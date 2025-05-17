@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Riwayat Penarikan Saldo</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($withdrawals->isEmpty())
        <div class="alert alert-info">
            Belum ada riwayat penarikan saldo.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Tujuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($withdrawals as $withdrawal)
                        <tr>
                            <td>{{ $withdrawal->created_at->format('d M Y, H:i') }}</td>
                            <td>IDR {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                            <td>{{ strtoupper($withdrawal->method) }}</td>
                            <td>{{ $withdrawal->destination }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <a href="{{ route('account.balance') }}" class="btn btn-secondary mt-3">Kembali ke Saldo</a>
</div>
@endsection