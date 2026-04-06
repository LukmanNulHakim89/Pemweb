const btnFibo = document.getElementById("btnFibo"); // Ambil tombol dari HTML berdasarkan id

btnFibo.addEventListener("click", () => { // Tambahkan event ketika tombol diklik
    let n = document.getElementById("jumlah").value; // Ambil nilai input dari user (jumlah deret)
    let a = 0, b = 1; // Inisialisasi dua angka awal Fibonacci
    let hasil = []; // Array untuk menyimpan hasil deret

    for (let i = 0; i < n; i++) { // Perulangan untuk menghasilkan deret Fibonacci sebanyak n
        hasil.push(a); // Masukkan nilai a ke dalam array hasil
        let temp = a + b; // Hitung angka berikutnya
       
       // Geser nilai a dan b
        a = b;
        b = temp;
    }
    document.getElementById("hasil").innerHTML = hasil.join(", "); // Tampilkan hasil ke dalam HTML
});