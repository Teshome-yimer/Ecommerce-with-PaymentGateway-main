# Setup Midtrans Payment Gateway

## 🚨 **PENTING: Cara Mendapatkan Midtrans Keys**

### 1. **Daftar Akun Midtrans**
1. Kunjungi [https://dashboard.midtrans.com/register](https://dashboard.midtrans.com/register)
2. Daftar dengan email dan data bisnis
3. Verifikasi email
4. Login ke dashboard

### 2. **Mendapatkan Sandbox Keys (untuk Testing)**
1. Login ke [https://dashboard.sandbox.midtrans.com](https://dashboard.sandbox.midtrans.com)
2. Pilih menu **Settings** → **Access Keys**
3. Copy **Server Key** dan **Client Key**
4. Gunakan keys ini untuk testing

### 3. **Mendapatkan Production Keys**
1. Verifikasi dokumen bisnis di dashboard
2. Tunggu approval dari Midtrans
3. Setelah approved, dapatkan production keys
4. Gunakan untuk live website

### 2. **Konfigurasi di Laravel**

#### Update file `.env`:
```env
# Midtrans Configuration
MIDTRANS_SERVER_KEY=your-actual-server-key
MIDTRANS_CLIENT_KEY=your-actual-client-key
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

#### Untuk Testing (Sandbox):
```env
# Midtrans Sandbox Configuration
MIDTRANS_SERVER_KEY=SB-Mid-server-GwUP_WGbJPXsDhkJRRUHHyat
MIDTRANS_CLIENT_KEY=SB-Mid-client-61XuGAwQ8Bx8LkSm
MIDTRANS_IS_PRODUCTION=false
```

#### Untuk Production:
```env
# Midtrans Production Configuration
MIDTRANS_SERVER_KEY=Mid-server-your-production-key
MIDTRANS_CLIENT_KEY=Mid-client-your-production-key
MIDTRANS_IS_PRODUCTION=true
```

### 3. **Test Payment Methods**

#### Sandbox Test Cards:
- **Visa**: 4811 1111 1111 1114
- **Mastercard**: 5211 1111 1111 1117
- **JCB**: 3528 0000 0000 0007
- **CVV**: 123
- **Expiry**: 12/25

#### Test Bank Transfer:
- **BCA**: 10203040
- **BNI**: 1234567890
- **BRI**: 1234567890

#### Test E-Wallet:
- **GoPay**: Gunakan nomor HP apapun
- **OVO**: Gunakan nomor HP apapun
- **DANA**: Gunakan nomor HP apapun

### 4. **Webhook Configuration**

#### Setup Notification URL di Midtrans Dashboard:
```
https://yourdomain.com/midtrans/notification
```

#### Untuk Development (ngrok):
```
https://your-ngrok-url.ngrok.io/midtrans/notification
```

### 5. **Clear Cache Setelah Update Config**
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### 6. **Testing Flow**

1. **Login sebagai user**:
   - Email: user@test.com
   - Password: password

2. **Add produk ke cart**
3. **Proceed to checkout**
4. **Isi alamat pengiriman**
5. **Klik "Place Order & Pay"**
6. **Popup Midtrans akan muncul**
7. **Pilih metode pembayaran**
8. **Complete payment**

### 7. **Troubleshooting**

#### Error 401 - Unauthorized:
- Pastikan Server Key dan Client Key benar
- Pastikan tidak ada spasi di awal/akhir key
- Clear cache setelah update config

#### Error 400 - Bad Request:
- Periksa format data yang dikirim
- Pastikan gross_amount adalah integer
- Periksa order_id format

#### Payment Popup Tidak Muncul:
- Periksa Client Key di frontend
- Pastikan Snap.js ter-load dengan benar
- Check browser console untuk error

### 8. **Security Notes**

- **Jangan commit** Server Key ke repository
- Gunakan environment variables
- Validasi notification dari Midtrans
- Implement proper error handling

### 9. **Production Checklist**

- [ ] Akun Midtrans verified
- [ ] Production keys obtained
- [ ] Webhook URL configured
- [ ] SSL certificate installed
- [ ] Error logging implemented
- [ ] Payment flow tested

## 📞 Support

Jika ada masalah dengan Midtrans:
- Documentation: https://docs.midtrans.com
- Support: https://midtrans.com/contact-us
- Slack Community: https://midtrans-community.slack.com
