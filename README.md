# Sales Dashboard (TEST) - Laravel Project

Project ini dibuat sebagai bagian dari tes teknis untuk menampilkan
- Tabel data penjualan
- Total penjualan
- Grafik tren penjualan
- Filter data berdasarkan rentang tanggal

## Cara Instalasi Lokal
1. git clone https://github.com/inipocong/test-sales-dashboard.git
cd test-sales-dashboard
2. composer install
3. cp .env.example .env
4. Konfigurasi database di .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sales_db
DB_USERNAME=root
DB_PASSWORD=

5. php artisan key:generate
6. php artisan migrate --seed
7. php artisan serve
8. buka http://127.0.0.1:8000

Untuk cek versi web yang sudah terhosting dapat di cek di link terlampir
https://test-sales-dashboard-production-4d1f.up.railway.app/