
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Form Pembayaran</h2>

        <!-- Order Details -->
        <div class="mb-6 p-4 bg-gray-50 rounded">
            <h3 class="font-semibold mb-2">Detail Pesanan:</h3>
            <p>Jasa: {{ $pemesanan->jasa->nama_jasa }}</p>
            <p>Penyedia: {{ $pemesanan->jasa->user->full_name }}</p>
            <p>Harga: Rp {{ number_format($pemesanan->harga, 0, ',', '.') }}</p>
            <p>Deskripsi: {{ $pemesanan->catatan }}</p>
        </div>

        <form action="{{ route('payment.process', $pemesanan->id) }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">
                    Metode Pembayaran
                </label>
                <div class="space-y-2">
                    <label class="block">
                        <input type="radio" name="payment_method" value="credit_card" required>
                        <span class="ml-2">Kartu Kredit</span>
                    </label>
                    <label class="block">
                        <input type="radio" name="payment_method" value="bank_transfer">
                        <span class="ml-2">Transfer Bank</span>
                    </label>
                    <label class="block">
                        <input type="radio" name="payment_method" value="e_wallet">
                        <span class="ml-2">E-Wallet</span>
                    </label>
                    <label class="block">
                        <input type="radio" name="payment_method" value="qris">
                        <span class="ml-2">QRIS</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="phone">
                    Nomor Telepon
                </label>
                <input type="tel" 
                       name="phone" 
                       id="phone"
                       class="w-full px-3 py-2 border rounded" 
                       required
                       pattern="[0-9]{10,13}">
            </div>

            <!-- Add payment details based on method -->
            <div id="payment-details" class="mb-4">
                <!-- Dynamic payment fields will be shown here -->
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Proses Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Add your JavaScript for handling payment method changes
</script>
@endpush
@endsection