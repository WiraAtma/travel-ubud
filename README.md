Judul : Web Informasi Daerah Ubud Untuk Turis

Nama Kelompok :
- I KADEK WIRA ATMAJA (2401020003 / IF) 
- IVAN MARCELINO IKHAZANDY PK. SUMICHAN (2401020023 / IF)
- NI KADEK LIDYA DWIMA ISKAYANI (2401020073 / IF)
- MARIA FARADITSIA YADHA (2401020101 / IF)

Step :
1. Clone Repo
  ```
  git clone https://github.com/WiraAtma/travel-ubud.git
  ```

2. Pastikan Node js dan Composer Sudah di Install
  - Cek Node js :
    ```
      node -v 
    ```
  - Cek Composer :
    ```
      npm -v
    ```

3. Setelah Berhasil Clone dan Terinstall Ikuti Langkah Berikut :
  ```
  composer install
  ```
  ```
  php artisan key:generate
  ```
  ```
  npm install
  ```
  ```
  php artisan storage:link
  ```

4. Run Localhost 
  ```
  npm run dev:all
  ```

5. Buka Lewat Browser (Chrome, Edge, Safari, dll) :
  ```
  http://127.0.0.1:8000/ atau http://localhost:8000
  ```

6. Pastikan memakai internet karena semua asset dan data database diambil dari cloud

4. Jika Sudah ada Tampilan Maka Bisa Mulai Coding

5. Saat Push Buat Branch Baru Dengan Nama Bebas , dan Push dengan branch tersebut , tidak bisa langsung ke main karena di proteksi

6. Buat pull request / merge request agar Wira bisa review code dan merge ke main