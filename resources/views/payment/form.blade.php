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
      const qrisCode = document.getElementById('qris-code');
      const ewalletDetails = document.getElementById('ewallet-details');
      const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
      const servicePriceElement = document.getElementById('service-price');
      const adminFeeElement = document.getElementById('admin-fee');
      const totalTagihanElement = document.getElementById('total-tagihan');
      const qrisAmountElement = document.getElementById('qris-amount');
  
      const servicePrice = parseInt(servicePriceElement.dataset.price) || 0;
  
      const calculateAdminFee = (method) => {
        switch (method) {
          case 'credit_card':
            return 10000;
          case 'bank_transfer':
            return 5000;
          case 'e_wallet':
            return 3000;
          case 'qris':
            return 2000;
          default:
            return 5000;
        }
      };
  
      const calculateTotalTagihan = (adminFee) => {
        const totalTagihan = servicePrice + adminFee;
        totalTagihanElement.textContent = `Rp${totalTagihan.toLocaleString('id-ID')}`;
        qrisAmountElement.textContent = `Rp${totalTagihan.toLocaleString('id-ID')}`;
      };
  
      const updatePaymentDetailsVisibility = (method) => {
        bankOptions.style.display = 'none';
        cardDetails.style.display = 'none';
        qrisCode.style.display = 'none';
        ewalletDetails.style.display = 'none';
  
        switch (method) {
          case 'bank_transfer':
            bankOptions.style.display = 'block';
            break;
          case 'credit_card':
            cardDetails.style.display = 'block';
            break;
          case 'qris':
            qrisCode.style.display = 'block';
            break;
          case 'e_wallet':
            ewalletDetails.style.display = 'block';
            break;
        }
      };
  
      // Pasang event listener untuk setiap metode pembayaran
      paymentMethods.forEach(method => {
        method.addEventListener('change', function () {
          const selectedMethod = this.value;
          const adminFee = calculateAdminFee(selectedMethod);
          adminFeeElement.textContent = `Rp${adminFee.toLocaleString('id-ID')}`;
          calculateTotalTagihan(adminFee);
          updatePaymentDetailsVisibility(selectedMethod);
        });
      });
  
      // Trigger initial selection jika sudah ada yang terpilih saat halaman load
      const initialSelectedMethod = document.querySelector('input[name="payment_method"]:checked');
      if (initialSelectedMethod) {
        const adminFee = calculateAdminFee(initialSelectedMethod.value);
        adminFeeElement.textContent = `Rp${adminFee.toLocaleString('id-ID')}`;
        calculateTotalTagihan(adminFee);
        updatePaymentDetailsVisibility(initialSelectedMethod.value);
      } else {
        // Jika tidak ada yang dipilih, set default biaya admin
        adminFeeElement.textContent = `Rp0`;
        calculateTotalTagihan(0);
      }
  
      // Validasi form sebelum submit
      document.querySelector('form').addEventListener('submit', function (e) {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!selectedMethod) {
          e.preventDefault();
          alert('Silakan pilih metode pembayaran.');
          return;
        }
  
        if (selectedMethod.value === 'credit_card') {
          const cardNumber = document.querySelector('input[name="card_number"]').value;
          const cardExpiry = document.querySelector('input[name="card_expiry"]').value;
          if (!cardNumber || !cardExpiry) {
            e.preventDefault();
            alert('Mohon lengkapi detail kartu kredit.');
            return;
          }
        }
  
        if (selectedMethod.value === 'e_wallet') {
          const phoneNumber = document.querySelector('input[name="phone_number"]').value;
          if (!phoneNumber || !/^[0-9]{10,13}$/.test(phoneNumber)) {
            e.preventDefault();
            alert('Mohon masukkan nomor telepon yang valid (10-13 digit).');
            return;
          }
        }
  
        if (selectedMethod.value === 'bank_transfer') {
          const selectedBank = document.querySelector('input[name="bank_name"]:checked');
          if (!selectedBank) {
            e.preventDefault();
            alert('Mohon pilih bank untuk transfer.');
            return;
          }
        }
      });
    });
  </script>
  
  <link rel="stylesheet" href="{{ asset('css/payment.css') }}">

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validasi nama saat submit (bukan saat input)
        const nameInputs = document.querySelectorAll('input[name="full_name"], input[name="seller_name"]');
        
        // Validasi nomor telepon saat input (hanya angka tapi bisa dihapus)
        const phoneInput = document.querySelector('input[name="phone"]');
        phoneInput.addEventListener('input', function(e) {
            // Izinkan delete dan backspace
            if (e.inputType === 'deleteContentBackward') return;
            
            // Filter hanya angka
            const numbersOnly = this.value.replace(/[^\d]/g, '');
            this.value = numbersOnly;
            
            // Batasi panjang max 13 digit
            if (this.value.length > 13) {
                this.value = this.value.slice(0, 13);
            }
        });

        // Validasi form saat submit
        document.querySelector('form').addEventListener('submit', function(e) {
            // Validasi format nama
            nameInputs.forEach(input => {
                const nameRegex = /^[a-zA-Z\s]+$/;
                if (!nameRegex.test(input.value)) {
                    e.preventDefault();
                    alert('Nama hanya boleh berisi huruf');
                    input.focus();
                    return false;
                }
            });

            // Validasi format nomor telepon
            const phone = phoneInput.value;
            if (phone.length < 10) {
                e.preventDefault();
                alert('Nomor telepon minimal 10 digit');
                phoneInput.focus();
                return false;
            }
            
            if (phone.length > 13) {
                e.preventDefault();
                alert('Nomor telepon maksimal 13 digit');
                phoneInput.focus();
                return false;
            }
            
            if (!/^\d+$/.test(phone)) {
                e.preventDefault();
                alert('Nomor telepon hanya boleh berisi angka');
                phoneInput.focus();
                return false;
            }
        });
    });
  </script>
</head>
<body class="bg-gray-100 min-h-screen">
  <nav class="nav-container">
    <div class="logo">
        @auth
            <a href="{{ route('dashboard') }}">TUNTAS<span class="logo-in">IN</span></a>
        @else
            <a href="/">TUNTAS<span class="logo-in">IN</span></a>
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
            <input 
                type="text" 
                name="full_name" 
                class="w-full border p-4 rounded text-lg"
                placeholder="Nama Anda"
                value="{{ old('full_name') }}"
                required
            />
            <span class="error-message" id="full_name_error">Nama hanya boleh berisi huruf</span>
            @error('full_name')
              <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-5">
            <label class="block font-medium mb-2">Nomor HP</label>
            <input 
                type="tel" 
                name="phone" 
                class="w-full border p-4 rounded text-lg"
                placeholder="08xxxxxxxxxx"
                value="{{ old('phone') }}"
                required
            />
            <span class="error-message" id="phone_error">Nomor telepon harus 10-13 digit angka</span>
            @error('phone')
              <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-5">
            <label class="block font-medium mb-2">Alamat</label>
            <textarea name="address" class="w-full border p-4 rounded text-lg" placeholder="Alamat lengkap..." required>{{ old('address') }}</textarea>
            @error('address')
              <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-5">
            <label class="block font-medium mb-2">Nama Penjual Jasa</label>
            <input type="text" name="seller_name" class="w-full border p-4 rounded text-lg" placeholder="Nama Penjual" value="{{ old('seller_name') }}" required />
            @error('seller_name')
              <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-5">
            <label class="block font-medium mb-2">Deskripsi Jasa Yang Digunakan</label>
            <textarea name="service_description" class="w-full border p-4 rounded text-lg" placeholder="Deskripsi Jasa" required>{{ old('service_description') }}</textarea>
            @error('service_description')
              <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <!-- Metode Pembayaran -->
        <div class="flex-1">
          <h2 class="text-2xl font-semibold mb-6">Metode Pembayaran</h2>
          <div class="mb-5">
            <label class="block font-medium mb-4">Pilih Metode Pembayaran</label>
            <div class="space-y-4">
                <!-- Credit Card -->
                <div class="payment-method-item">
                    <input type="radio" name="payment_method" value="credit_card" id="credit_card" class="form-radio" required />
                    <label for="credit_card" class="payment-method-label">
                        <img src="https://img.icons8.com/color/48/visa.png" class="payment-icon" alt="Visa" />
                        <span class="payment-text">Kartu Kredit</span>
                    </label>
                </div>

                <!-- Bank Transfer -->
                <div class="payment-method-item">
                    <input type="radio" name="payment_method" value="bank_transfer" id="bank_transfer" class="form-radio" required />
                    <label for="bank_transfer" class="payment-method-label">
                        <img src="https://img.icons8.com/color/48/bank.png" class="payment-icon" alt="Bank Transfer" />
                        <span class="payment-text">Transfer Bank</span>
                    </label>
                </div>

                <!-- E-Wallet -->
                <div class="payment-method-item">
                    <input type="radio" name="payment_method" value="e_wallet" id="e_wallet" class="form-radio" required />
                    <label for="e_wallet" class="payment-method-label">
                        <img src="https://img.icons8.com/color/48/google-pay.png" class="payment-icon" alt="E-Wallet" />
                        <span class="payment-text">E-Wallet</span>
                    </label>
                </div>

                <!-- QRIS -->
                <div class="payment-method-item">
                    <input type="radio" name="payment_method" value="qris" id="qris" class="form-radio" required />
                    <label for="qris" class="payment-method-label">
                        <img src="https://img.icons8.com/color/48/qr-code.png" class="payment-icon" alt="QRIS" />
                        <span class="payment-text">QRIS</span>
                    </label>
                </div>
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

          <!-- QRIS Code Section -->
          <div id="qris-code" class="mb-5" style="display: none;">
            <div class="qris-container">
                <img src="{{ asset('images/QRCode.png') }}" alt="QRIS Code" class="qris-image">
                <p class="text-center mt-4">Scan QR code untuk melakukan pembayaran</p>
                <p class="text-sm text-gray-500 mt-2">Total Pembayaran: <span id="qris-amount"></span></p>
            </div>
          </div>

          <!-- E-Wallet Details -->
          <div id="ewallet-details" class="mb-5" style="display: none;">
            <div class="form-group">
                <label class="block font-medium mb-2">Nomor Telepon</label>
                <input type="tel" name="phone_number" class="form-input" placeholder="Contoh: 08123456789" pattern="[0-9]{10,13}">
            </div>
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
