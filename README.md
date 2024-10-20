## Template admin
    -- NobleUi


## Tech
    -- Laravel (Backend)
    -- Javascript (Frontend)

## Fitur

### Auth
    -- Login
    -- Manajemen User
    -- Delete Session User

### Library
    -- Yajra/DataTable (Serverside)
    -- DataTable (Clientside)

### Persiapan
    -- Pastikan Install server terlebih dahulu, seperti xampp atau laragon
    -- Masuk Ke Folder www
### Instalation
    -- Donwload file di https://github.com/arjun-ux/perpus
    -- atau bisa juga dengan menggunakan perintah "git clone https://github.com/arjun-ux/perpus.git" diterminal atau git
    -- Jalankan perintah "composer install" atau "composer update" untuk menginstal semua library yang dibutuhkan
    -- setting file .env di dalam folder perpus
    -- setting .env
    -- jalanakan perintah "php artisan key:generate"
    -- Jalankan Perintah "php artisan migrate" untuk membuat database
    -- Jalankan Perintah "php artisan db:seed" untuk mengisi database dengan bawaaan
    -- Jalankan Perinta "php artisan storage:link" 

### Login
    -- Masuk Ke alamat
    -- Username "admin"
    -- password "popo"

$direktori = __DIR__ . '/perpus'; // arahkan ke folder projek

if (is_dir($direktori)) {
    header("Location: /perpus"); // arahkan ke folder projek
    exit;
} else {
    echo "Path yang diberikan bukan direktori.";
}

