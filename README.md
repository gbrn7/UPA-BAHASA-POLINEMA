# 🚀 Laravel Application

Aplikasi ini dibangun menggunakan [Laravel](https://laravel.com/) sebagai backend framework.  
Struktur dan konfigurasi mengikuti standar Laravel dengan beberapa penyesuaian sesuai kebutuhan proyek.

---

## 📋 Requirement

Pastikan environment sudah memenuhi spesifikasi berikut:

-   PHP >= 8.1
-   Composer >= 2.x
-   MySQL / MariaDB
-   Node.js >= 20 & NPM
-   Git

---

## ⚙️ Instalasi

1. Clone repository:
    ```bash
    git clone https://github.com/gbrn7/UPA-BAHASA-POLINEMA.git
    cd UPA-BAHASA-POLINEMA
    ```
2. Install dependency:
    ```bash
    composer install
    ```
3. Install dependency JavaScript:
    ```bash
    npm install
    ```
4. Salin file .env.example menjadi .env:

    ```bash
    cp .env.example .env
    ```

5. Buat database mysql dengan nama 'upa_bahasa_polinema'

6. Generate application key:

    ```bash
    php artisan key:generate
    ```

7. Konfigurasi database di file .env, lalu jalankan migrasi dan seeder:

    ```bash
    php artisan migrate --seed
    ```

8. Buat symbolic link untuk storage:

    ```bash
    php artisan storage:link
    ```

9. Build asset frontend (sekali jalan untuk production atau jika ada perubahan asset):

    ```bash
    npm run build
    ```

10. Jalankan server lokal Laravel:

    ```bash
    php artisan serve
    ```

11. (Opsional / dapat dijalankan atau tidak) Jalankan Vite untuk asset bundling (development mode):

    ```bash
    npm run dev

    ```
