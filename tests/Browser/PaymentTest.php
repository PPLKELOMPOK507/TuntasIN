<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PaymentTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test payment form submission with valid data.
     * @group payment
     */
    public function testPaymentSuccess(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/payment/form')
                    ->assertSee('Metode Pembayaran') // Pastikan halaman form terlihat
                    ->type('full_name', 'John Doe') // Isi nama lengkap
                    ->type('phone', '081234567890') // Isi nomor telepon
                    ->type('address', 'Jl. Contoh No. 123') // Isi alamat
                    ->type('seller_name', 'Service Provider') // Isi nama penjual
                    ->type('service_description', 'Web Development Service') // Isi deskripsi jasa
                    ->radio('payment_method', 'credit_card') // Pilih metode pembayaran
                    ->type('card_number', '4111111111111111') // Isi nomor kartu kredit
                    ->type('card_expiry', '12/25') // Isi masa berlaku kartu
                    ->press('Submit') // Tekan tombol submit
                    ->waitForText('Pembayaran berhasil!') // Tunggu notifikasi sukses
                    ->assertSee('Pembayaran berhasil!'); // Pastikan notifikasi sukses terlihat
        });
    }

    /**
     * Test payment form submission with invalid card expiry.
     * @group payment
     */
    public function testPaymentInvalidCardExpiry(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/payment/form')
                    ->assertSee('Metode Pembayaran') // Pastikan halaman form terlihat
                    ->type('full_name', 'John Doe') // Isi nama lengkap
                    ->type('phone', '081234567890') // Isi nomor telepon
                    ->type('address', 'Jl. Contoh No. 123') // Isi alamat
                    ->type('seller_name', 'Service Provider') // Isi nama penjual
                    ->type('service_description', 'Web Development Service') // Isi deskripsi jasa
                    ->radio('payment_method', 'credit_card') // Pilih metode pembayaran
                    ->type('card_number', '4111111111111111') // Isi nomor kartu kredit
                    ->type('card_expiry', '01/20') // Isi masa berlaku kartu yang sudah expired
                    ->press('Submit') // Tekan tombol submit
                    ->waitForText('Masa berlaku kartu tidak valid atau sudah expired.') // Tunggu notifikasi error
                    ->assertSee('Masa berlaku kartu tidak valid atau sudah expired.'); // Pastikan notifikasi error terlihat
        });
    }

    /**
     * Test payment form submission with invalid phone number.
     * @group payment
     */
    public function testPaymentInvalidPhoneNumber(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/payment/form')
                    ->assertSee('Metode Pembayaran') // Pastikan halaman form terlihat
                    ->type('full_name', 'John Doe') // Isi nama lengkap
                    ->type('phone', 'invalid-phone') // Isi nomor telepon yang tidak valid
                    ->type('address', 'Jl. Contoh No. 123') // Isi alamat
                    ->type('seller_name', 'Service Provider') // Isi nama penjual
                    ->type('service_description', 'Web Development Service') // Isi deskripsi jasa
                    ->radio('payment_method', 'credit_card') // Pilih metode pembayaran
                    ->type('card_number', '4111111111111111') // Isi nomor kartu kredit
                    ->type('card_expiry', '12/25') // Isi masa berlaku kartu
                    ->press('Submit') // Tekan tombol submit
                    ->waitForText('Nomor telepon hanya boleh berisi angka') // Tunggu notifikasi error
                    ->assertSee('Nomor telepon hanya boleh berisi angka'); // Pastikan notifikasi error terlihat
        });
    }

    /**
     * Test case 1: User mengisi Nama Lengkap hanya dengan huruf.
     */
    public function testPaymentWithValidFullName(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/payment/form')
                    ->type('full_name', 'John Doe') // Nama hanya huruf
                    ->type('phone', '081234567890') // Nomor telepon valid
                    ->type('address', 'Jl. Contoh No. 123')
                    ->type('seller_name', 'Service Provider')
                    ->type('service_description', 'Web Development Service')
                    ->radio('payment_method', 'credit_card')
                    ->type('card_number', '4111111111111111')
                    ->type('card_expiry', '12/25')
                    ->press('Submit')
                    ->waitForText('Pembayaran berhasil!')
                    ->assertSee('Pembayaran berhasil!');
        });
    }

    /**
     * Test case 2: User mengisi Nomor Hp hanya dengan angka.
     */
    public function testPaymentWithValidPhoneNumber(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/payment/form')
                    ->type('full_name', 'John Doe')
                    ->type('phone', '081234567890') // Nomor telepon valid
                    ->type('address', 'Jl. Contoh No. 123')
                    ->type('seller_name', 'Service Provider')
                    ->type('service_description', 'Web Development Service')
                    ->radio('payment_method', 'credit_card')
                    ->type('card_number', '4111111111111111')
                    ->type('card_expiry', '12/25')
                    ->press('Submit')
                    ->waitForText('Pembayaran berhasil!')
                    ->assertSee('Pembayaran berhasil!');
        });
    }

    /**
     * Test case 3: User memilih metode pembayaran kartu kredit dan menyelesaikan pembayaran.
     */
    public function testPaymentWithCreditCard(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/payment/form')
                    ->type('full_name', 'John Doe')
                    ->type('phone', '081234567890')
                    ->type('address', 'Jl. Contoh No. 123')
                    ->type('seller_name', 'Service Provider')
                    ->type('service_description', 'Web Development Service')
                    ->radio('payment_method', 'credit_card') // Pilih kartu kredit
                    ->type('card_number', '4111111111111111')
                    ->type('card_expiry', '12/25')
                    ->press('Submit')
                    ->waitForText('Pembayaran berhasil!')
                    ->assertSee('Pembayaran berhasil!');
        });
    }

    /**
     * Test case 4: User memilih metode pembayaran kartu kredit dan memasukkan nomor kartu dengan huruf.
     */
    public function testPaymentWithInvalidCardNumber(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/payment/form')
                    ->type('full_name', 'John Doe')
                    ->type('phone', '081234567890')
                    ->type('address', 'Jl. Contoh No. 123')
                    ->type('seller_name', 'Service Provider')
                    ->type('service_description', 'Web Development Service')
                    ->radio('payment_method', 'credit_card')
                    ->type('card_number', 'invalidcard') // Nomor kartu tidak valid
                    ->type('card_expiry', '12/25')
                    ->press('Submit')
                    ->waitForText('Nomor kartu kredit tidak valid.')
                    ->assertSee('Nomor kartu kredit tidak valid.');
        });
    }

    /**
     * Test case 5: User memilih metode pembayaran transfer bank dan menyelesaikan pembayaran.
     */
    public function testPaymentWithBankTransfer(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/payment/form')
                    ->type('full_name', 'John Doe')
                    ->type('phone', '081234567890')
                    ->type('address', 'Jl. Contoh No. 123')
                    ->type('seller_name', 'Service Provider')
                    ->type('service_description', 'Web Development Service')
                    ->radio('payment_method', 'bank_transfer') // Pilih transfer bank
                    ->press('Submit')
                    ->waitForText('Pembayaran berhasil!')
                    ->assertSee('Pembayaran berhasil!');
        });
    }

    /**
     * Test case 6: User memilih metode pembayaran e-wallet dan menyelesaikan pembayaran.
     */
    public function testPaymentWithEWallet(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/payment/form')
                    ->type('full_name', 'John Doe')
                    ->type('phone', '081234567890')
                    ->type('address', 'Jl. Contoh No. 123')
                    ->type('seller_name', 'Service Provider')
                    ->type('service_description', 'Web Development Service')
                    ->radio('payment_method', 'e_wallet') // Pilih e-wallet
                    ->press('Submit')
                    ->waitForText('Pembayaran berhasil!')
                    ->assertSee('Pembayaran berhasil!');
        });
    }

    /**
     * Test case 7: User tidak memilih metode pembayaran.
     */
    public function testPaymentWithoutSelectingMethod(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/payment/form')
                    ->type('full_name', 'John Doe')
                    ->type('phone', '081234567890')
                    ->type('address', 'Jl. Contoh No. 123')
                    ->type('seller_name', 'Service Provider')
                    ->type('service_description', 'Web Development Service')
                    ->press('Submit') // Tidak memilih metode pembayaran
                    ->waitForText('Silakan pilih metode pembayaran.')
                    ->assertSee('Silakan pilih metode pembayaran.');
        });
    }
}
