Intinya cuma program dan tutorial simpel untuk buat aplikasi web CRUD dasar (banget), untuk menjadi referensi

---

## CRUD apaan emang?
- **C**reate: Menambahkan data baru (seperti posting foto).
- **R**ead: Menampilkan data (seperti melihat feed).
- **U**pdate: Mengubah data (seperti edit caption).
- **D**elete: Menghapus data (seperti hapus postingan).

4 konsep dasar operasi aplikasi pada umumnya


---

## Langkah 0: Niat, Doa, Usaha dan Instalasi tools
Pertama, silahkan baca bismillah (atau sesuai kepercayaan masing masing),
Kemudian kita lakukan instalasi alat yang diperlukan untuk pembuatan web dasar

1. Install XAMPP, download disini: https://www.apachefriends.org/
   download sesuai sistem operasi masing masing
   <img width="1470" height="584" alt="Screenshot 2026-04-30 at 14 41 46" src="https://github.com/user-attachments/assets/bb87d6d3-a6a1-4207-aec7-33707404a812" />

2. Selesai di download tinggal next next dan yes aja semuanya sampai kebuka menu yang berisi Apache, mysql dan kawan kawan
   tampilan di windows
   <img width="668" height="434" alt="image" src="https://github.com/user-attachments/assets/e588cb4b-9f9f-470b-a375-8c7a5e9133d2" />

   tampilan di MacOS
   <img width="668" height="484" alt="Screenshot 2026-04-30 at 14 43 47" src="https://github.com/user-attachments/assets/aae6001e-ed6d-4328-8de7-71610bad324a" />

3. Klik tombol start disamping modul Apache dan MySQL (seperti di gambar), jikalau berubah jadi hijau artinya instalasi sudah berhasil dan XAMPP siap digunakan. Kalo belum ijo? klik lagi dan tunggu sampe bisa atau bisa tanyakan kepada ahli(*) karena mungkin terjadi kesalahan atau perbedaan konfigurasi di lapropnya

* XAMPP apaan? XAMPP sebenernya kayak aplikasi perkumpulan alat alat yang dibutuhkan untuk pemrograman web
* Isi XAMPP ada PHP, Apache, MySQL dan alat lain yang ga penting untuk sekarang
* PHP apaan? pemberi harapan palsu? PHP itu bahasa pemrograman yang kita pake buat bikin program web
* Apache? simpelnya gini, website itu butuh server untuk jalan, Apache ini ibaratnya server yang dipasang di laptop kita untuk jalanin program web nya
* MySQL? apkh ini MyBini? nahh MySQL ini intinya basis data atau tempat kita nyimpen data dari program web nya. Data di MySQL ini disimpen dalam bentuk tabel yang isinya ada baris dan kolom

4. Kalo udah start silahkan buka link ini di browser masing masing: http://localhost/phpmyadmin/ nantinya akan muncul halaman phpMyAdmin
<img width="1470" height="621" alt="Screenshot 2026-04-30 at 14 54 22" src="https://github.com/user-attachments/assets/c38c0806-5819-4f13-abe1-2e016cb11a28" />

* phpMyAdmin apaan? halaman ini buat kita bikin basis data, sebelum mulai ngoding kita perlu siapin dulu bebentukan tabel seperti apa yang akan kita pake nanti


---

## Langkah 1: Persiapan Database (Gudang Data)
Aplikasi butuh tempat untuk menyimpan informasi secara permanen. Tempat ini disebut **Database**.

1. Buka XAMPP Control Panel dan jalankan **Apache** dan **MySQL**.
2. Buka `localhost/phpmyadmin` di browser.
3. Klik tab **SQL** dan tempel kode ini:
   ```sql
   CREATE DATABASE inventory_db;
   USE inventory_db;

   CREATE TABLE items (
       id INT(11) AUTO_INCREMENT PRIMARY KEY,
       item_name VARCHAR(100) NOT NULL,
       quantity INT(11) NOT NULL,
       status VARCHAR(50) NOT NULL
   );
   ```
**Kenapa ini penting?** 
- `TABLE` ibarat sebuah lemari arsip. 
- `item_name`, `quantity`, dll adalah laci-laci di dalam lemari tersebut.
- `id` dengan `AUTO_INCREMENT` memastikan setiap barang punya nomor unik otomatis (seperti nomor KTP).

---

## Langkah 2: Membuat File Koneksi (`config.php`)
PHP adalah bahasa pemrograman, dan MySQL adalah database. Mereka adalah dua entitas berbeda yang perlu "berbicara" satu sama lain.

**Analogi:** `config.php` adalah kabel telepon yang menghubungkan kantor (PHP) dengan gudang (Database).

**Langkah:**
1. Buat file `config.php`.
2. Gunakan fungsi `mysqli_connect()`.
3. Masukkan "alamat" database: `localhost`, `root`, `""` (kosong), dan `inventory_db`.

**Kenapa ini penting?** Tanpa file ini, aplikasi kita tidak bisa mengambil atau menyimpan data apa pun.

---

## Langkah 3: Membuat Dashboard (`index.php`)
Halaman ini adalah wajah utama aplikasi di mana user bisa melihat isi "gudang".

**Langkah:**
1. Panggil kabel koneksi tadi dengan `include 'config.php'`.
2. Gunakan perintah SQL: `SELECT * FROM items` (Ambil SEMUA data dari tabel items).
3. Gunakan **Looping (while)**: Ini ibarat menyuruh komputer: *"Selama masih ada barang di gudang, tolong tuliskan namanya di baris tabel ini."*

**Kenapa ini penting?** Ini mengajarkan konsep **Read** (Membaca data) dan bagaimana menampilkan data dari database ke layar user.

---

## Langkah 4: Membuat Form Tambah (`create.php`)
Ini adalah pintu masuk data baru ke gudang.

**Langkah:**
1. Buat Form HTML. Penting: Gunakan `method="POST"`.
2. **Analogi POST:** Seperti mengirim surat di dalam amplop tertutup (aman dan bisa bawa banyak data).
3. Tangkap isi input dengan variabel PHP seperti `$_POST['item_name']`.

**Kenapa ini penting?** Mengajarkan konsep **Input** dan bagaimana PHP memproses data yang diketik oleh manusia di browser.

---

## Langkah 5: Membuat Form Ubah (`edit.php`)
Kadang kita salah input atau stok barang berubah. Di sini kita belajar cara memperbarui data.

**Langkah:**
1. Ambil ID dari URL (`$_GET['id']`). **Analogi GET:** Seperti menulis pesan di belakang kartu pos (terlihat di alamat bar browser).
2. Tampilkan data lama di dalam kotak input (`value="<?php echo $row['item_name']; ?>"`).
3. Kirim perubahan dengan perintah `UPDATE`.

**Kenapa ini penting?** Ini adalah langkah tersulit bagi pemula karena melibatkan proses mengambil data lama, menampilkannya, lalu menyimpannya kembali sebagai data baru.

---

## Langkah 6: Membuat Proses Hapus (`delete.php`)
Menghapus data yang sudah tidak diperlukan.

**Langkah:**
1. Ambil ID yang mau dihapus.
2. Jalankan perintah `DELETE FROM items WHERE id = $id`.
3. **PENTING:** Harus pakai `WHERE id = ...`, kalau tidak, SEMUA isi gudang akan terhapus!

---

## Tips Mengajar untuk Pemula (Zero Concept):
1. **Semicolon (;):** Ingatkan bahwa ini seperti titik di akhir kalimat. Tanpa titik, komputer akan bingung kapan kalimat berakhir.
2. **Dollar Sign ($):** Variabel (seperti `$name`) adalah sebuah kotak label. Kita bisa memasukkan apa saja ke dalam kotak tersebut.
3. **Case Sensitive:** Huruf besar dan kecil berpengaruh. `item_name` tidak sama dengan `Item_Name`.
4. **Error adalah Teman:** Jika muncul layar putih atau pesan error, jangan panik. Itu cara komputer memberitahu di baris mana kita "salah ketik".

---

## Checklist Kelulusan BNSP:
1. **Komentar:** Setiap baris kode penting harus ada penjelasan `//`.
2. **Identasi:** Pastikan kode menjorok ke dalam agar mudah dibaca.
3. **Bootstrap:** Pastikan tampilan rapi dan tombol berwarna (biru untuk tambah, kuning untuk edit, merah untuk hapus).
