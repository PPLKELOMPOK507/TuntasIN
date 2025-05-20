<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>TUNTASIN - Chat Negosiasi</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      --tuntasin-blue: #1e88e5;
      --tuntasin-darker-blue: #1976d2;
      --tuntasin-light-blue: #e3f2fd;
      --tuntasin-red: #ff5757;
      --tuntasin-grey: #f5f7fa;
      --tuntasin-text: #333333;
      --tuntasin-light-grey: #eaeaea;
    }
    
    body {
      background-color: var(--tuntasin-grey);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .navbar {
      background-color: var(--tuntasin-blue);
      padding: 10px 20px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .navbar-brand {
      color: white;
      font-size: 24px;
      font-weight: bold;
    }
    
    .navbar-brand span {
      color: white;
    }
    
    .back-button {
      color: var(--tuntasin-text);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      margin-bottom: 15px;
      font-weight: 500;
      transition: all 0.2s ease;
    }
    
    .back-button:hover {
      color: var(--tuntasin-blue);
      transform: translateX(-3px);
    }
    
    .chat-container {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      overflow: hidden;
      margin-bottom: 30px;
    }
    
    .chat-header {
      background-color: var(--tuntasin-blue);
      color: white;
      padding: 15px 20px;
      border-bottom: 1px solid var(--tuntasin-light-grey);
    }
    
    .chat-header h5 {
      margin: 0;
      font-weight: 600;
    }
    
    .chat-header small {
      display: block;
      opacity: 0.85;
      margin-top: 3px;
    }
    
    .price-badge {
      background-color: rgba(255,255,255,0.2);
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 14px;
      font-weight: 600;
      display: inline-block;
    }
    
    #chat-messages {
      height: 400px;
      overflow-y: auto;
      padding: 20px;
      background-color: #f9f9f9;
    }
    
    .message-wrapper {
      margin-bottom: 15px;
      position: relative;
      clear: both;
    }
    
    .text-right {
      text-align: right;
    }
    
    .text-left {
      text-align: left;
    }
    
    .message {
      display: inline-block;
      max-width: 80%;
      padding: 12px 15px;
      border-radius: 12px;
      position: relative;
      box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    
    .sent {
      background-color: var(--tuntasin-light-blue);
      float: right;
      border-bottom-right-radius: 3px;
    }
    
    .received {
      background-color: white;
      float: left;
      border-bottom-left-radius: 3px;
    }
    
    .message-sender {
      font-weight: 600;
      font-size: 13px;
      margin-bottom: 5px;
      color: #444;
    }
    
    .message-content {
      margin-bottom: 5px;
      word-wrap: break-word;
      color: #333;
    }
    
    .price-offer {
      font-size: 13px;
      font-weight: 600;
      margin-top: 8px;
      padding-top: 8px;
      border-top: 1px solid rgba(0,0,0,0.1);
      color: var(--tuntasin-blue);
    }
    
    .price-offer i {
      margin-right: 5px;
    }
    
    .message-time {
      font-size: 11px;
      color: #888;
      text-align: right;
      margin-top: 5px;
    }
    
    .chat-input {
      padding: 15px 20px;
      border-top: 1px solid var(--tuntasin-light-grey);
      background-color: white;
    }
    
    .input-group {
      margin-bottom: 10px;
    }
    
    .form-control {
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 12px;
    }
    
    .form-control:focus {
      border-color: var(--tuntasin-blue);
      box-shadow: 0 0 0 0.2rem rgba(30, 136, 229, 0.25);
    }
    
    .price-input-group {
      display: flex;
      gap: 10px;
      margin-bottom: 10px;
    }
    
    .price-input-group .form-control {
      border-radius: 10px;
    }
    
    .price-prefix {
      background-color: #f5f5f5;
      color: #666;
      border: 1px solid #ddd;
      border-radius: 10px 0 0 10px;
      padding: 0 10px;
      display: flex;
      align-items: center;
      font-weight: 500;
    }
    
    textarea.form-control {
      resize: none;
    }
    
    .input-group-text {
      background-color: var(--tuntasin-blue);
      color: white;
      border: none;
      font-weight: 600;
    }
    
    .btn-primary {
      background-color: var(--tuntasin-blue);
      border: none;
      border-radius: 10px;
      padding: 10px 20px;
      font-weight: 600;
      transition: background-color 0.2s;
    }
    
    .btn-primary:hover {
      background-color: var(--tuntasin-darker-blue);
    }
    
    /* Service info sidebar */
    .service-info {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .service-info h5 {
      margin-bottom: 15px;
      font-weight: 600;
      color: #333;
      position: relative;
      padding-bottom: 10px;
    }
    
    .service-info h5:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 40px;
      height: 3px;
      background-color: var(--tuntasin-blue);
    }
    
    .seller-info {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 1px solid var(--tuntasin-light-grey);
    }
    
    .seller-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: #eee;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 12px;
      color: #777;
    }
    
    .seller-name {
      font-weight: 600;
      margin-bottom: 3px;
    }
    
    .seller-rating {
      color: #666;
      font-size: 13px;
    }
    
    .package-card {
      border: 1px solid #eee;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .package-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 15px rgba(0,0,0,0.08);
    }
    
    .package-title {
      font-weight: 600;
      margin-bottom: 10px;
      color: var(--tuntasin-blue);
    }
    
    .package-price {
      color: var(--tuntasin-blue);
      font-size: 22px;
      font-weight: 700;
      margin-bottom: 15px;
    }
    
    .package-desc {
      font-size: 14px;
      color: #666;
      margin-bottom: 15px;
      padding-bottom: 15px;
      border-bottom: 1px solid var(--tuntasin-light-grey);
    }
    
    .features-list {
      margin-bottom: 15px;
    }
    
    .feature-item {
      display: flex;
      align-items: center;
      margin-bottom: 8px;
      font-size: 14px;
    }
    
    .feature-icon {
      color: var(--tuntasin-blue);
      margin-right: 8px;
      font-size: 16px;
      width: 20px;
      text-align: center;
    }
    
    .order-button {
      background-color: var(--tuntasin-red);
      color: white;
      border: none;
      border-radius: 10px;
      padding: 12px;
      font-weight: 600;
      width: 100%;
      margin-top: 15px;
      transition: all 0.2s;
    }
    
    .order-button:hover {
      opacity: 0.9;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(255, 87, 87, 0.3);
    }
    
    .favorite-icon {
      position: absolute;
      top: 10px;
      right: 10px;
      color: #ddd;
      font-size: 20px;
      cursor: pointer;
      transition: all 0.2s;
    }
    
    .favorite-icon:hover, .favorite-icon.active {
      color: var(--tuntasin-red);
      transform: scale(1.1);
    }
    
    .category-dropdown {
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
      padding: 8px 15px;
      font-weight: 500;
    }
    
    /* Added feature for small screens */
    @media (max-width: 768px) {
      .service-info {
        margin-top: 20px;
      }
      
      .chat-input {
        padding: 15px;
      }
      
      .price-input-group {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="container">
      <a class="navbar-brand" href="/">TUNTAS<span>IN</span></a>
    </div>
  </nav>

  <div class="container mt-4">
    <!-- Back button -->
    <a href="/dashboard" class="back-button">
      <i class="fas fa-arrow-left me-2"></i>
      Kembali ke Dashboard
    </a>
    
    <div class="row mt-3">
      <!-- Chat column -->
      <div class="col-md-8">
        <div class="chat-container">
          <div class="chat-header d-flex justify-content-between align-items-center">
            <div>
              <h5 class="mb-0">Chat Negosiasi</h5>
            </div>
            <span class="price-badge">Harga Minimal: Rp 5.000.000</span>
          </div>
          
          <div id="chat-messages">
            <!-- Sample messages -->
            <div class="message-wrapper">
              <div class="message received">
                <div class="message-sender">Nama Penyedia</div>
                <div class="message-content">Halo! Terima kasih sudah tertarik dengan jasa design logo kami. Ada yang bisa saya bantu?</div>
                <div class="message-time">10:30</div>
              </div>
            </div>
            
            <div class="message-wrapper">
              <div class="message sent">
                <div class="message-sender">Anda</div>
                <div class="message-content">Hai, saya tertarik dengan paket Basic Anda. Apakah bisa dijelaskan lebih detail tentang revisi yang termasuk?</div>
                <div class="message-time">10:32</div>
              </div>
            </div>
            
            <div class="message-wrapper">
              <div class="message received">
                <div class="message-sender">Nama Penyedia</div>
                <div class="message-content">Tentu saja! Dalam paket Basic, Anda berhak mendapatkan 2 kali revisi mayor, termasuk perubahan konsep, warna, dan tipografi. Setiap revisi akan dikerjakan dalam waktu 1 hari kerja.</div>
                <div class="message-time">10:35</div>
              </div>
            </div>
            
            <div class="message-wrapper">
              <div class="message sent">
                <div class="message-sender">Anda</div>
                <div class="message-content">Baik, saya mengerti. Apakah bisa mendapatkan penawaran harga lebih baik?</div>
                <div class="price-offer">
                  <i class="fas fa-tag"></i> Penawaran Harga: Rp 5.000.000
                </div>
                <div class="message-time">10:37</div>
              </div>
            </div>
            
            <div class="message-wrapper">
              <div class="message received">
                <div class="message-sender">Nama Penyedia</div>
                <div class="message-content">Terima kasih atas penawaran Anda. Untuk penawaran Rp 5.000.000, saya bisa memberikan 1 revisi tambahan menjadi total 3 revisi. Bagaimana menurut Anda?</div>
                <div class="message-time">10:40</div>
              </div>
            </div>
          </div>
          
          <div class="chat-input">
            <form>
              <input type="hidden" name="jasa_id" value="{{ $jasa->id }}">
              <input type="hidden" name="receiver_id" value="{{ $jasa->user_id }}">
              
              <div class="input-group">
                <textarea class="form-control" id="message-input" rows="2" placeholder="Ketik pesan..."></textarea>
              </div>
              
              <div class="price-input-group">
                <div class="input-group">
                  <span class="input-group-text price-prefix">Rp</span>
                  <input type="number" name="price_offer" class="form-control" placeholder="Masukkan penawaran harga (opsional)">
                </div>
                <button type="button" class="btn btn-primary" onclick="sendMessage()">
                  <i class="fas fa-paper-plane me-1"></i> Kirim
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      
      <!-- Service info sidebar -->
      <div class="col-md-4">
        <div class="service-info">
          <h5>Informasi Jasa</h5>
          
          <div class="seller-info">
            <div class="seller-avatar">
              <i class="fas fa-user"></i>
            </div>
            <div>
              <div class="seller-name">Nama Penyedia</div>
              <div class="seller-rating">
                <i class="fas fa-star" style="color: #FFBA49;"></i>
                4.9 (120 ulasan)
              </div>
            </div>
          </div>
          
          <div class="package-card position-relative">
            <i class="fas fa-heart favorite-icon"></i>
            <div class="package-title">Paket Basic</div>
            <div class="package-price">Rp 5.555.000</div>
            <div class="package-desc">Layanan standar sesuai deskripsi dengan kualitas terjamin.</div>
            
            <div class="features-list">
              <div class="feature-item">
                <span class="feature-icon">
                  <i class="fas fa-clock"></i>
                </span>
                <span>Pengerjaan dalam 3 Hari</span>
              </div>
              
              <div class="feature-item">
                <span class="feature-icon">
                  <i class="fas fa-sync-alt"></i>
                </span>
                <span>Garansi 2 Revisi</span>
              </div>
              
              <div class="feature-item">
                <span class="feature-icon">
                  <i class="fas fa-comments"></i>
                </span>
                <span>Konsultasi Gratis</span>
              </div>
              
              <div class="feature-item">
                <span class="feature-icon">
                  <i class="fas fa-shield-alt"></i>
                </span>
                <span>Garansi Kepuasan</span>
              </div>
            </div>
            
            <a href="{{ route('pesanan.create', $jasa->id) }}"  class="btn order-button">
              <i class="fas fa-shopping-cart me-2"></i> Pesan Sekarang
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script>
    // Sample function for sending messages
    function sendMessage() {
      const messageInput = document.getElementById('message-input');
      const priceOffer = document.querySelector('input[name="price_offer"]');
      
      if (messageInput.value.trim() === '' && priceOffer.value.trim() === '') {
        return;
      }
      
      // Here you would normally send the message to the server
      // For demo purposes, we'll just add it to the chat
      
      const chatMessages = document.getElementById('chat-messages');
      const messageWrapper = document.createElement('div');
      messageWrapper.className = 'message-wrapper';
      
      const message = document.createElement('div');
      message.className = 'message sent';
      
      const messageSender = document.createElement('div');
      messageSender.className = 'message-sender';
      messageSender.textContent = 'Anda';
      
      const messageContent = document.createElement('div');
      messageContent.className = 'message-content';
      messageContent.textContent = messageInput.value;
      
      const messageTime = document.createElement('div');
      messageTime.className = 'message-time';
      const now = new Date();
      messageTime.textContent = `${now.getHours()}:${now.getMinutes().toString().padStart(2, '0')}`;
      
      message.appendChild(messageSender);
      message.appendChild(messageContent);
      
      if (priceOffer.value.trim() !== '') {
        const priceOfferDiv = document.createElement('div');
        priceOfferDiv.className = 'price-offer';
        priceOfferDiv.innerHTML = `<i class="fas fa-tag"></i> Penawaran Harga: Rp ${parseInt(priceOffer.value).toLocaleString('id-ID')}`;
        message.appendChild(priceOfferDiv);
      }
      
      message.appendChild(messageTime);
      messageWrapper.appendChild(message);
      chatMessages.appendChild(messageWrapper);
      
      // Clear inputs
      messageInput.value = '';
      priceOffer.value = '';
      
      // Scroll to the bottom
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Toggle favorite
    document.querySelector('.favorite-icon').addEventListener('click', function() {
      this.classList.toggle('active');
    });
    
    // Auto scroll to bottom on page load
    document.addEventListener('DOMContentLoaded', function() {
      const chatMessages = document.getElementById('chat-messages');
      chatMessages.scrollTop = chatMessages.scrollHeight;
    });
  </script>
</body>
</html>