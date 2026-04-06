const prosesKalkulator = (operator, ...daftarAngka) => {
    // Validasi jika angka kurang dari 2
    if (daftarAngka.length < 2) {
        return "Masukkan minimal 2 angka (pisahkan dengan koma)";
    }

    // Menggunakan .reduce untuk mengolah array dari spread operator
    return daftarAngka.reduce((total, angkaBerikutnya) => {
        switch (operator) {
            case '+': return total + angkaBerikutnya;
            case '-': return total - angkaBerikutnya;
            case '*': return total * angkaBerikutnya;
            case '/': return angkaBerikutnya === 0 ? "Error: Bagi 0" : total / angkaBerikutnya;
            case '%': return total % angkaBerikutnya;
            default: return 0;
        }
    });
};

document.getElementById('tombolHitung').addEventListener('click', () => {
    // Mengambil nilai dari input
    const teksInput = document.getElementById('inputAngka').value;
    const operatorTerpilih = document.getElementById('pilihOperator').value;
    const tampilanHasil = document.getElementById('areaHasil');

    // Mengubah string "10, 5, 2" menjadi array angka [10, 5, 2]
    const arrayAngka = teksInput.split(',')
                                .map(item => parseFloat(item.trim()))
                                .filter(item => !isNaN(item));

    const hasilAkhir = prosesKalkulator(operatorTerpilih, ...arrayAngka); // Memanggil fungsi utama dengan Spread Operator

    tampilanHasil.innerHTML = `<strong>${hasilAkhir}</strong>`;   // Menampilkan hasil ke layar
});