# Generator E-Ticket (Laravel 12 + Bootstrap 5)

Aplikasi sederhana untuk membuat **e-ticket penerbangan** dalam format PDF,
tanpa login. Pengguna mengisi form (data agen, booking, penerbangan, dan
penumpang — bisa lebih dari satu), lalu sistem menghasilkan PDF e-ticket
yang rapi, mengikuti format e-ticket travel agent pada umumnya.

> Catatan: paket ini berisi **file aplikasi (source code)**, bukan proyek
> Laravel yang lengkap dengan folder `vendor/`. Karena environment saat ini
> tidak memiliki akses internet untuk menjalankan `composer install`, silakan
> ikuti langkah instalasi di bawah ini di komputer Anda sendiri (yang punya
> akses internet). Prosesnya singkat, ±5 menit.

## Struktur file yang disertakan

```
eticket-app/
├── app/Http/Controllers/ETicketController.php   # Logika validasi & generate PDF
├── routes/web.php                               # Route (GET form, POST generate)
├── resources/views/layouts/app.blade.php        # Layout dasar (Bootstrap 5 via CDN)
├── resources/views/eticket/index.blade.php      # Form input (dinamis: multi flight & multi penumpang)
├── resources/views/eticket/pdf.blade.php        # Template PDF e-ticket (dompdf)
├── composer.json                                # Referensi dependency yang dibutuhkan
└── .env.example
```

## Langkah instalasi

1. **Buat proyek Laravel 12 baru** (butuh PHP >= 8.2 dan Composer terpasang):

    ```bash
    composer create-project laravel/laravel eticket-app "^12.0"
    cd eticket-app
    ```

2. **Install package PDF (dompdf):**

    ```bash
    composer require barryvdh/laravel-dompdf
    ```

    Laravel 12 akan otomatis mendaftarkan service provider-nya (auto-discovery),
    jadi tidak perlu edit `config/app.php`.

3. **Salin file dari paket ini** ke dalam folder proyek Laravel yang baru
   dibuat, timpa file yang sudah ada bila diminta:

    - `app/Http/Controllers/ETicketController.php` → salin ke lokasi yang sama
    - `routes/web.php` → timpa file bawaan
    - `resources/views/layouts/app.blade.php` → buat folder `layouts` lalu salin
    - `resources/views/eticket/index.blade.php` → buat folder `eticket` lalu salin
    - `resources/views/eticket/pdf.blade.php` → salin ke folder `eticket` yang sama

4. **Siapkan file environment:**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    (Proyek ini tidak memakai database, jadi tidak perlu migrasi.)

5. **Jalankan server:**
    ```bash
    php artisan serve
    ```
    Buka `http://127.0.0.1:8000` di browser.

## Cara pakai

1. Isi **Data Agen** (nama travel & tagline — bisa diganti sesuai brand Anda).
2. Isi **Data Booking**: PNR, tanggal terbit, total fare, mata uang.
3. Klik **Tambah Penerbangan** untuk menambah baris penerbangan
   (mendukung lebih dari satu segmen, misalnya pergi-pulang atau transit).
4. Klik **Tambah Penumpang** untuk menambah baris penumpang
   (mendukung banyak penumpang dalam satu booking).
5. Klik **Buat E-Ticket (PDF)** — PDF akan terbuka di tab baru, siap
   diunduh/dicetak oleh pelanggan.

## Pengembangan lanjutan (opsional, ide untuk versi berikutnya)

-   Simpan histori e-ticket ke database (butuh migrasi + model).
-   Tambah logo agen (upload gambar) untuk header PDF.
-   Tambah opsi "download" langsung (`->download()`) selain `->stream()`.
-   Tambah autentikasi (login admin) jika perlu dibatasi hanya staf internal.
-   Validasi tambahan (misalnya format nomor tiket 13 digit e-ticket IATA).

## Referensi tampilan

Format field (Booking Reference/PNR, Flight Details, Passenger Details,
Fare Details, dsb.) mengikuti struktur e-ticket contoh yang dilampirkan
pada proyek ini (KOSIKAS TRAVEL — rute BTJ–CGK).
