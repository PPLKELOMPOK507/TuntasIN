<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Pembayaran</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const bankOptions = document.getElementById('bank-options');
      const cardDetails = document.getElementById('card-details');
      const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
      const servicePriceElement = document.getElementById('service-price');
      const adminFeeElement = document.getElementById('admin-fee');
      const totalTagihanElement = document.getElementById('total-tagihan');

      // Placeholder harga jasa (akan diambil dari database di masa mendatang)
      const servicePrice = parseInt(servicePriceElement.dataset.price) || 0;

      // Hitung biaya admin berdasarkan metode pembayaran
      const calculateAdminFee = (method) => {
        switch (method) {
          case 'credit_card':
            return 10000; // Biaya admin untuk kartu kredit
          case 'bank_transfer':
            return 5000; // Biaya admin untuk transfer bank
          case 'e_wallet':
            return 3000; // Biaya admin untuk e-wallet
          case 'paypal':
            return 15000; // Biaya admin untuk PayPal
          case 'qris':
            return 2000; // Biaya admin untuk QRIS
          default:
            return 5000; // Default biaya admin
        }
      };

      // Hitung total tagihan
      const calculateTotalTagihan = (adminFee) => {
        const totalTagihan = servicePrice + adminFee;
        totalTagihanElement.textContent = `Rp${totalTagihan.toLocaleString('id-ID')}`;
      };

      // Inisialisasi total tagihan
      let initialAdminFee = calculateAdminFee(document.querySelector('input[name="payment_method"]:checked')?.value || '');
      adminFeeElement.textContent = `Rp${initialAdminFee.toLocaleString('id-ID')}`;
      calculateTotalTagihan(initialAdminFee);

      paymentMethods.forEach(method => {
        method.addEventListener('change', function () {
          const selectedMethod = this.value;
          const adminFee = calculateAdminFee(selectedMethod);
          adminFeeElement.textContent = `Rp${adminFee.toLocaleString('id-ID')}`;
          calculateTotalTagihan(adminFee);

          if (selectedMethod === 'bank_transfer') {
            bankOptions.style.display = 'block';
            cardDetails.style.display = 'none';
          } else if (selectedMethod === 'credit_card') {
            cardDetails.style.display = 'block';
            bankOptions.style.display = 'none';
          } else {
            bankOptions.style.display = 'none';
            cardDetails.style.display = 'none';
          }
        });
      });

      // Validasi form sebelum submit
      document.querySelector('form').addEventListener('submit', function (e) {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!selectedMethod) {
          e.preventDefault();
          alert('Silakan pilih metode pembayaran.');
        }
      });
    });
  </script>
</head>
<body class="bg-gray-100 min-h-screen">
  <nav class="nav-container p-6">
    <div class="logo text-2xl font-bold">
      @auth
          <a href="{{ route('dashboard') }}">TUNTAS<span class="text-blue-500">IN</span></a>
      @else
          <a href="/">TUNTAS<span class="text-blue-500">IN</span></a>
      @endauth
    </div>
  </nav>

  <div class="bg-white p-6 md:p-10 rounded-lg shadow-md w-full mx-auto">
    <!-- Notifikasi Status Pembayaran -->
    @if (session('status'))
      <div class="mb-6 p-4 rounded text-white {{ session('status') === 'success' ? 'bg-green-500' : 'bg-red-500' }}">
        {{ session('message') }}
      </div>
    @endif

    <form action="{{ route('payment.submit') }}" method="POST">
      @csrf
      <input type="hidden" name="status" value="pending" />
      <div class="flex flex-col lg:flex-row gap-8 px-6 md:px-12">
        <!-- Informasi Pembayaran -->
        <div class="flex-1">
          <h2 class="text-2xl font-semibold mb-6">Informasi Pembayaran</h2>
          <div class="mb-5">
            <label class="block font-medium mb-2">Nama Lengkap</label>
            <input type="text" name="full_name" class="w-full border p-4 rounded text-lg" placeholder="Nama Anda" required />
          </div>
          <div class="mb-5">
            <label class="block font-medium mb-2">Nomor HP</label>
            <input type="text" name="phone" class="w-full border p-4 rounded text-lg" placeholder="08xxxxxxxxxx" required />
          </div>
          <div class="mb-5">
            <label class="block font-medium mb-2">Alamat</label>
            <textarea name="address" class="w-full border p-4 rounded text-lg" placeholder="Alamat lengkap..." required></textarea>
          </div>
          <div class="mb-5">
            <label class="block font-medium mb-2">Nama Penjual Jasa</label>
            <input type="text" name="seller_name" class="w-full border p-4 rounded text-lg" placeholder="Nama Penjual" required />
          </div>
          <div class="mb-5">
            <label class="block font-medium mb-2">Deskripsi Jasa Yang Digunakan</label>
            <textarea name="service_description" class="w-full border p-4 rounded text-lg" placeholder="Deskripsi Jasa" required></textarea>
          </div>
        </div>

        <!-- Metode Pembayaran -->
        <div class="flex-1">
          <h2 class="text-2xl font-semibold mb-6">Metode Pembayaran</h2>
          <div class="mb-5">
            <label class="block font-medium mb-2">Pilih Metode Pembayaran</label>
            <div class="flex flex-col gap-4">
              <label class="flex items-center gap-3">
                <input type="radio" name="payment_method" value="credit_card" class="form-radio" required />
                <img src="https://img.icons8.com/color/48/visa.png" class="h-10" alt="Visa" />
                <span>Kartu Kredit</span>
              </label>
              <label class="flex items-center gap-3">
                <input type="radio" name="payment_method" value="bank_transfer" class="form-radio" required />
                <img src="https://img.icons8.com/color/48/bank.png" class="h-10" alt="Bank Transfer" />
                <span>Transfer Bank</span>
              </label>
              <label class="flex items-center gap-3">
                <input type="radio" name="payment_method" value="e_wallet" class="form-radio" required />
                <img src="https://img.icons8.com/color/48/google-pay.png" class="h-10" alt="E-Wallet" />
                <span>E-Wallet</span>
              </label>
              <label class="flex items-center gap-3">
                <input type="radio" name="payment_method" value="paypal" class="form-radio" required />
                <img src="https://img.icons8.com/color/48/paypal.png" class="h-10" alt="PayPal" />
                <span>PayPal</span>
              </label>
              <label class="flex items-center gap-3">
                <input type="radio" name="payment_method" value="qris" class="form-radio" required />
                <img src="https://img.icons8.com/color/48/qr-code.png" class="h-10" alt="QRIS" />
                <span>QRIS</span>
              </label>
            </div>
          </div>

          <!-- Opsi Bank -->
          <div id="bank-options" class="mb-5" style="display: none;">
            <label class="block font-medium mb-2">Virtual Account</label>
            <div class="flex flex-col gap-4">
              <label class="flex items-center gap-3">
                <input type="radio" name="bank_name" value="bca" class="form-radio" />
                <span>BCA</span>
              </label>
              <label class="flex items-center gap-3">
                <input type="radio" name="bank_name" value="bni" class="form-radio" />
                <span>BNI</span>
              </label>
              <label class="flex items-center gap-3">
                <input type="radio" name="bank_name" value="mandiri" class="form-radio" />
                <span>Mandiri</span>
              </label>
              <label class="flex items-center gap-3">
                <input type="radio" name="bank_name" value="bri" class="form-radio" />
                <span>BRI</span>
              </label>
            </div>
          </div>

          <!-- Detail Kartu Kredit -->
          <div id="card-details" class="mb-5" style="display: none;">
            <label class="block font-medium mb-2">Nomor Kartu</label>
            <input type="text" name="card_number" class="w-full border p-4 rounded text-lg" placeholder="Masukkan Nomor Kartu" />
            <label class="block font-medium mb-2 mt-4">Masa Berlaku Kartu</label>
            <input type="text" name="card_expiry" class="w-full border p-4 rounded text-lg" placeholder="MM/YY" />
          </div>

          <!-- Detail Harga -->
          <div class="mb-6 bg-gray-100 p-5 rounded text-lg">
            <p>Total Harga Jasa: <span id="service-price" data-price="100000" class="font-semibold">Rp100.000</span></p>
            <p>Biaya Admin: <span id="admin-fee" data-fee="5000" class="font-semibold">Rp5.000</span></p>
            <p>Total Tagihan: <span id="total-tagihan" class="font-semibold"></span></p>
          </div>

          <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded text-lg hover:bg-blue-700">
            Bayar Sekarang
          </button>
        </div>
      </div>
    </form>
  </div>
</body>
</html>
