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

3. Klik tombol start disamping modul Apache dan MySQL (seperti di gambar), jikalau berubah jadi hijau artinya instalasi sudah berhasil dan XAMPP siap digunakan. Kalo belum ijo? klik lagi dan tunggu sampe bisa atau bisa tanyakan kepada ahli(*) karena mungkin terjadi kesalahan atau perbedaan konfigurasi di laptopnya

- XAMPP apaan? XAMPP sebenernya kayak aplikasi perkumpulan alat alat yang dibutuhkan untuk pemrograman web
- Isi XAMPP ada PHP, Apache, MySQL dan alat lain yang ga penting untuk sekarang
- PHP apaan? pemberi harapan palsu? PHP itu bahasa pemrograman yang kita pake buat bikin program web
- Apache? simpelnya gini, website itu butuh server untuk jalan, Apache ini ibaratnya server yang dipasang di laptop kita untuk jalanin program web nya
- MySQL? apkh ini MyBini? nahh MySQL ini intinya basis data atau tempat kita nyimpen data dari program web nya. Data di MySQL ini disimpen dalam bentuk tabel yang isinya ada baris dan kolom

4. Kalo udah start silahkan buka link ini di browser masing masing: http://localhost/phpmyadmin/ nantinya akan muncul halaman phpMyAdmin
<img width="1470" height="621" alt="Screenshot 2026-04-30 at 14 54 22" src="https://github.com/user-attachments/assets/c38c0806-5819-4f13-abe1-2e016cb11a28" />

- phpMyAdmin apaan? halaman ini buat kita bikin basis data, sebelum mulai ngoding kita perlu siapin dulu bebentukan tabel seperti apa yang akan kita pake nanti

5. Install Visual Studio Code https://code.visualstudio.com/, kita nulis kode pake VS Code karena banyak extension yang nanti bisa dipake untuk mempermudah hidup
<img width="1470" height="798" alt="Screenshot 2026-04-30 at 21 01 55" src="https://github.com/user-attachments/assets/e34e55da-8faf-435d-93e6-867deda5a3a4" />
<img width="1190" height="797" alt="Screenshot 2026-04-30 at 21 02 09" src="https://github.com/user-attachments/assets/5884aa0f-3c4b-4922-9239-af40a9504fa6" />


---

## Langkah 1: Mari mulai memasak, dengan bikin Databasenya dulu
Kenapa kudu pake database? Gunanya database itu buat naro Data secara permanen dan terstruktur, karena data yang diinput di program yang berjalan tanpa database itu hanya tersimpan sementara doang, kayak perasaan dia.

1. Buka XAMPP dan jalanin **Apache** dan **MySQL**. (kalo tadi udah ga usah di pencet lagi)
2. Buka `localhost/phpmyadmin` di browser. (tadi juga udah dibuka kan)
3. Klik menu "SQL" diatas
   <img width="1470" height="661" alt="Screenshot 2026-04-30 at 20 18 00" src="https://github.com/user-attachments/assets/aff8e078-7285-40a4-ba92-992372e0e361" />
 
4. Jika dilihat ada input besar untuk ngetik SQL disitu, coba masukan dulu kode berikut:
   ```sql
   -- Untuk membuat Database nya dulu (anggep lah kertas kosongnya dulu)
   CREATE DATABASE inventory_db; -- nama database nya "inventory_db"
   USE inventory_db; -- kita aktifkan Database nya, maksudnya command apapun dibawah ini akan dijalankan di kertas kosong yang baru kita buat

   CREATE TABLE items ( -- kita mulai gambar tabel nya, dikasih nama items (alias barang)
       id INT(11) AUTO_INCREMENT PRIMARY KEY, -- ini kolom kolom di tabel yang kita gambar, ada 4 kolom
       item_name VARCHAR(100) NOT NULL, 
       quantity INT(11) NOT NULL,
       status VARCHAR(50) NOT NULL
   );
   ```
5. Kemudian klik tombol Go dipojok bawah, tujuan kode ini buat bikin database, tabel beserta kolomnya
<img width="1228" height="445" alt="Screenshot 2026-04-30 at 20 36 56" src="https://github.com/user-attachments/assets/b4b46104-1a94-4bbc-ab46-f5f1121d69ae" />

6. Loh yang tadi kode apaan? namanya SQL ( structured query language ) yaitu bahasa buat set up dan ngatur database, namanya ngobrol sama mesin itu ada aturannya, harus jelas struktur dan perintahnya makanya dibuatlah SQL.
7. jika sudah sukses nantinya bisa kita buka database baru dan dilihat tabel buatan kita, isinya pasti masih kosongan
<img width="1467" height="538" alt="Screenshot 2026-04-30 at 20 43 03" src="https://github.com/user-attachments/assets/66c116d9-9cc1-487e-9d52-98d53aec769f" />
<img width="759" height="477" alt="Screenshot 2026-04-30 at 20 43 35" src="https://github.com/user-attachments/assets/487299ec-e0df-475d-9d01-cc176c9cad04" />

   
**Penjelasan Kolom** 
1. Sama aja kayak gambar tabel diatas kertas kita pasti gambar kolom
2. cara nulis kolom itu "{nama_kolom} {tipe_data} {atrribut (bisa lebih dari satu)}"
3. maksudnya begimana? coba lihat kolom `id INT(11) AUTO_INCREMENT PRIMARY KEY,`
   - "id" itu nama kolomnya,
   - INT(11) artinya kolom ini tipenya integer dengan panjang 11 (angka, panjang maksimal 11 contohnya 1, 2, 12345678911)
   - AUTO_INCREMENT ini atribut khusus, artinya kolom ini akan secara otomatis melakukan increment (penambahan / +1),
   - PRIMARY KEY ini artinya id ini sebagai kunci unik, anggep lah NIK nya di KTP mah, kan tiap orang beda beda, jadi ga boleh ada nilai yang sama di kolom ini.
4. mari kita lihat kolom lain: `item_name VARCHAR(100) NOT NULL,`
   - item_name ini nama kolom kedua
   - VARCHAR(100) ini artinya kolom ini bisa menyimpan karakter apa saja, mau teks atau angka, misal "Fuad 69", panjang maksimal nya 100 karakter
   - NOT NULL ini atribut yang artinya kolom ini wajib diisi (tidak NULL atau kosong), nilainya wajib selalu kita input
   - notis kita ga pake PRIMARY KEY lagi disini? ya karena Primary Key hanya boleh ada satu, ga boleh ada 2 kolom yang jadi kunci utama.
5. Sisa kolom lainnya bisa coba definisikan sendiri dengan cara diatas, jika sudah paham pasti mudah menentukan kolom apa yang dibutuhkan.

---

## Langkah 2: Menyambungkan database ke aplikasi web
Database nya udah mateng, coba cek file `config.php`. Database dan Aplikasi itu dua hal terpisah, mereka perlu perantara buat "ngobrol", gunanya file ini untuk menyambungkan silaturahmi keduanya.

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
<img width="1470" height="816" alt="Screenshot 2026-04-30 at 21 11 08" src="https://github.com/user-attachments/assets/49a39dc3-fa7c-447f-b3e5-e22bff3bec8c" />


---

## Langkah 4: Membuat Form Tambah (`create.php`)
Ini adalah pintu masuk data baru ke gudang.

**Langkah:**
1. Buat Form HTML. Penting: Gunakan `method="POST"`.
2. **Analogi POST:** Seperti mengirim surat di dalam amplop tertutup (aman dan bisa bawa banyak data).
3. Tangkap isi input dengan variabel PHP seperti `$_POST['item_name']`.

**Kenapa ini penting?** Mengajarkan konsep **Create** dan bagaimana PHP memproses data yang diketik oleh manusia di browser.
<img width="1470" height="847" alt="Screenshot 2026-04-30 at 21 12 09" src="https://github.com/user-attachments/assets/2b3d18bd-5927-4355-9d9d-439746f37371" />
<img width="1466" height="813" alt="Screenshot 2026-04-30 at 21 12 18" src="https://github.com/user-attachments/assets/5a69eacc-67a6-4072-bfda-4292aebfca9a" />

---

## Langkah 5: Membuat Form Ubah (`edit.php`)
Kadang kita salah input atau stok barang berubah. Di sini kita belajar cara memperbarui data.

**Langkah:**
1. Ambil ID dari URL (`$_GET['id']`). **Analogi GET:** Seperti menulis pesan di belakang kartu pos (terlihat di alamat bar browser).
2. Tampilkan data lama di dalam kotak input (`value="<?php echo $row['item_name']; ?>"`).
3. Kirim perubahan dengan perintah `UPDATE`.

**Kenapa ini penting?** Ini adalah langkah tersulit bagi pemula karena melibatkan proses mengambil data lama, menampilkannya, lalu menyimpannya kembali sebagai data baru.
<img width="1470" height="802" alt="Screenshot 2026-04-30 at 21 12 36" src="https://github.com/user-attachments/assets/bfbc12b5-a0ae-428a-8d49-12ba6601d73b" />

---

## Langkah 6: Membuat Proses Hapus (`delete.php`)
Menghapus data yang sudah tidak diperlukan.

**Langkah:**
1. Ambil ID yang mau dihapus.
2. Jalankan perintah `DELETE FROM items WHERE id = $id`.
3. **PENTING:** Harus pakai `WHERE id = ...`, kalau tidak, SEMUA isi gudang akan terhapus!

---

## Tips untuk Pemula:
1. **Semicolon (;):** titik koma di bahasa PHP itu wajib, sama aja kayak tanda titik diakhir kata, sebagai tanda kalo baris tersebut udah beres
2. **Dollar Sign ($):** Variabel (seperti `$name`) gunanya untuk nampung data, anggep aja kotak kosong, nanti isinya bisa macem macem seuai yang kita kasih misal `$name = 'abdul sigma'` artinya kotak kosong tadi diisi kata 'abdul sigma'.
3. **Case Sensitive:** Huruf besar dan kecil berpengaruh. `item_name` tidak sama dengan `Item_Name`.
4. **Error adalah Teman:** kalo error jangan nangis, apapun yang terjadi tetap bernafas, baca dengan seksama karena didalem sebuah error itu ada informasi, ada clue kita salahnya dimana. Tengok error dibawah ini:

<img width="1030" height="199" alt="Screenshot 2026-04-30 at 21 16 53" src="https://github.com/user-attachments/assets/2e90ad61-fd2e-408a-9def-4fd6bf0df337" />
* `Warning: mysqli_connect()` berarti ada masalah di fungsi saat menyambungkan ke database
* `No such file or directory in /Applications/XAMPP/xamppfiles/htdocs/bnsp-preps/config.php on line 13` disini jelas sekali file yang bermasalah itu config.php baris ke 13, ada apa di baris tersebut?
* baris 13 isinya `$conn = mysqli_connect($host, $user, $pass, $db);` oke sesuai point pertama errornya di koneksi, apa yang salah? apakah host, user, pass dan db nya sudah benar? atau apakah server mysql nya mati?
* dalem case diatas, server MySQL nya mati oleh karena itu koneksinya gagal, cukup dinyalain lagi aja, langsung nyambung.
<img width="692" height="276" alt="Screenshot 2026-04-30 at 21 20 13" src="https://github.com/user-attachments/assets/4a041629-fccf-4333-8647-658a78aebaa5" />


---

## Checklist Kelulusan BNSP:
1. **Komentar:** Setiap baris kode penting harus ada penjelasan `//`.
2. **Identasi:** Pastikan kode menjorok ke dalam agar mudah dibaca.
3. **Bootstrap:** Pastikan tampilan rapi dan tombol berwarna (biru untuk tambah, kuning untuk edit, merah untuk hapus).
