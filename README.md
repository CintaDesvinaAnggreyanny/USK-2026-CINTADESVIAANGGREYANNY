Nama: Cinta Desvina Anggreyanny
Kelas: XII Pengembangan Perangkat Lunak & Gim

                                                                Ujian Sertifikasi Kompetensi Tahun 2026
Assalamualaikum Warahmatullahi Wabarakatuh, disini saya membuat aplikasi kasir berbasis website dengan menggunakan php, html dan css. Contoh aplikasi yang saya buat adalah aplikasi kasir makanan dan minuman di Warteg 88.

A. Flowchart 
<img width="1039" height="596" alt="image" src="https://github.com/user-attachments/assets/d0e143be-a2fa-4083-aa27-b02c41e33eec" /> [Gambar A 1.1 Flowchart]


Penjelasan Alur Kerja Sistem (Flowchart)
1. Proses Autentikasi (Halaman Login) Alur dimulai saat pengguna membuka halaman Login. Pengguna diminta memasukkan username dan password, yang kemudian akan diperiksa oleh sistem ke dalam database. Jika data tidak cocok, akan muncul pesan error dan pengguna diminta login kembali. Jika data benar, sistem akan membuat "sesi" aktif dan mengecek peran pengguna. Jika pengguna adalah Karyawan, mereka akan diarahkan ke halaman Kasir, sedangkan jika pengguna adalah Admin, mereka akan masuk ke halaman Dashboard Admin.

2. Alur Transaksi Kasir (Untuk Karyawan) Pada bagian ini, Karyawan akan melayani transaksi di halaman transaksi.php. Daftar menu yang muncul diambil langsung dari database. Karyawan bisa menambah atau mengubah jumlah pesanan pembeli secara praktis (menggunakan JavaScript). Setelah pesanan selesai, Karyawan memasukkan jumlah uang yang dibayar. Jika uang kurang, sistem akan memberikan peringatan. Jika cukup, sistem akan memproses transaksi secara otomatis: mencatat nota, mencatat detail barang, dan langsung mengurangi stok menu di database. Terakhir, sistem akan menampilkan nota yang siap dicetak.

3. Alur Manajemen Data (Untuk Admin) Di sisi lain, Admin memiliki wewenang untuk mengatur daftar menu di halaman kelola_menu.php. Admin bisa melihat semua menu dan kategori yang tersedia. Di sini terdapat tiga fungsi utama: Menambah menu baru, Mengubah data menu yang sudah ada (seperti harga atau stok), atau Menghapus menu. Setiap perubahan yang dilakukan oleh Admin akan langsung tersimpan di database, sehingga data yang dilihat oleh Kasir selalu dalam kondisi yang paling baru (update).

4. Keamanan Sistem (Security Check) Sebagai tambahan, sistem ini dilengkapi dengan fitur keamanan global. Setiap kali ada halaman yang dibuka, sistem akan memastikan terlebih dahulu apakah pengguna sudah login dan apakah peran (role) mereka sudah sesuai. Hal ini dilakukan untuk mencegah akses sembarangan, misalnya agar Karyawan tidak bisa masuk ke halaman Admin atau pengguna asing tidak bisa masuk ke dalam sistem tanpa login terlebih dahulu.


B. Mockup Website
<img width="409" height="520" alt="image" src="https://github.com/user-attachments/assets/bf8c3788-0caa-4e48-a585-7fc3a072339a" /> [Gambar B 1.1 Mockup Halaman Login]
<img width="818" height="512" alt="image" src="https://github.com/user-attachments/assets/abd5eeff-2be3-403b-ad36-7142e584fe4d" /> [Gambar B 1.2 Mockup Halaman Dashboard Admin]
<img width="826" height="515" alt="image" src="https://github.com/user-attachments/assets/53de0ec1-390e-42b4-8cc3-001812002c12" /> [Gambar B 1.3 Mockup Halaman Admin – Daftar Menu]
<img width="731" height="597" alt="image" src="https://github.com/user-attachments/assets/911450f6-8ebc-4664-8b10-176b5e22aaff" /> [Gambar B 1.4 Mockup Halaman Admin – Tambah Menu Baru]
<img width="732" height="463" alt="image" src="https://github.com/user-attachments/assets/30a597d5-5a7b-4a3a-a354-f0be280afde7" /> [Gambar B 1.5 Mockup Halaman Admin – Laporan Penjualan]
<img width="731" height="453" alt="image" src="https://github.com/user-attachments/assets/3f1086cb-320e-452c-a96d-e72d9bdcfe39" /> [Gambar B 1.6 Mockup Halaman Dashboard Kasir]
<img width="756" height="512" alt="image" src="https://github.com/user-attachments/assets/eb1eccf7-91b3-47b7-8afc-aefdca80e8de" /> [Gambar B 1.7 Mockup Halaman Kasir – Transaksi Baru]
<img width="380" height="518" alt="image" src="https://github.com/user-attachments/assets/9206a4b7-88e1-4f4c-a68c-6be6bc770bea" /> [Gambar B 1.8 Mockup Halaman Kasir – Nota Pembayaran]
<img width="915" height="596" alt="image" src="https://github.com/user-attachments/assets/1e3c8f2b-de98-47db-b962-caf7906d219a" /> [Gambar B 1.9 Mockup Halaman Kasir – Riwayat Transaksi]

C. Program
<img width="336" height="378" alt="image" src="https://github.com/user-attachments/assets/edbaeec3-b118-4e35-bda3-04638672ea8a" />
<img width="312" height="202" alt="image" src="https://github.com/user-attachments/assets/c26b8625-a097-404c-b588-1d75238048ab" />
<img width="340" height="381" alt="image" src="https://github.com/user-attachments/assets/f256ac58-d00e-4b4f-b489-04a3ed3dd657" />
Gambar C 1.1 Program

<img width="701" height="465" alt="image" src="https://github.com/user-attachments/assets/efa78726-70da-4de6-bd07-b9a9d7381ffe" />
Gambar C 1.2 Database


Terimakasih, Wassalamualaikum Wr. Wb

















