<?php

/*DELETE*/
if(isset($_GET['hapus'])){
    mysqli_query($conn, "DELETE FROM krs WHERE id='$_GET[hapus]'");
}

/*EDIT*/
if(isset($_GET['edit'])){
    $edit = mysqli_query($conn, "SELECT * FROM krs WHERE id='$_GET[edit]'");
    $e = mysqli_fetch_array($edit);
}

/*INSERT / UPDATE*/
if(isset($_POST['simpan'])){
    if(isset($_GET['edit'])){
        // update relasi
        mysqli_query($conn, "UPDATE krs SET
            mahasiswa_npm='$_POST[npm]',
            matakuliah_kodemk='$_POST[kodemk]'
            WHERE id='$_GET[edit]'
        ");
    } else {
        // insert relasi
        mysqli_query($conn, "INSERT INTO krs(mahasiswa_npm, matakuliah_kodemk)
        VALUES('$_POST[npm]','$_POST[kodemk]')");
    }
}
?>

<style>
.table-custom {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.table-custom th {
    text-align: left;
    padding: 10px;
    border-bottom: 2px solid #000;
}

.table-custom td {
    padding: 10px;
}

/* zebra row */
.table-custom tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* highlight merah */
.text-red {
    color: #d9534f;
    font-weight: 500;
}
</style>

<h3>Input KRS</h3>

<form method="POST" class="mb-3">

    <!-- dropdown mahasiswa -->
    <select name="npm" class="form-control mb-2">
        <?php
        $mhs = mysqli_query($conn, "SELECT * FROM mahasiswa");
        while($m = mysqli_fetch_array($mhs)){
            // selected saat edit
            $s = (@$e['mahasiswa_npm']==$m['npm'])?'selected':'';
            echo "<option value='$m[npm]' $s>$m[nama]</option>";
        }
        ?>
    </select>

    <!-- dropdown matakuliah -->
    <select name="kodemk" class="form-control mb-2">
        <?php
        $mk = mysqli_query($conn, "SELECT * FROM matakuliah");
        while($k = mysqli_fetch_array($mk)){
            $s = (@$e['matakuliah_kodemk']==$k['kodemk'])?'selected':'';
            echo "<option value='$k[kodemk]' $s>$k[nama]</option>";
        }
        ?>
    </select>

    <button name="simpan" class="btn btn-primary">
        <?= isset($e)?'Update':'Simpan' ?>
    </button>

</form>

<h3>Data KRS</h3>

<table class="table-custom">
<tr>
    <th>No</th>
    <th>Nama Lengkap</th>
    <th>Mata Kuliah</th>
    <th>Keterangan</th>
    <th>Aksi</th>
</tr>

<?php
$no = 1;

/* JOIN 3 tabel */
$query = mysqli_query($conn, "
    SELECT k.id, m.nama AS nama_mhs, mk.nama AS nama_mk, mk.jumlah_sks
    FROM krs k
    JOIN mahasiswa m ON k.mahasiswa_npm = m.npm
    JOIN matakuliah mk ON k.matakuliah_kodemk = mk.kodemk
");

while($d = mysqli_fetch_array($query)){
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $d['nama_mhs'] ?></td>
    <td><?= $d['nama_mk'] ?></td>
    <td>
        <!-- format sesuai soal + highlight -->
        <span class="text-red"><?= $d['nama_mhs'] ?></span>
        Mengambil Mata Kuliah 
        <span class="text-red"><?= $d['nama_mk'] ?></span>
        (<?= $d['jumlah_sks'] ?> SKS)
    </td>
    <td>
        <!-- aksi tetap di halaman krs -->
        <a href="?hal=krs&edit=<?= $d['id'] ?>">Edit</a> |
        <a href="?hal=krs&hapus=<?= $d['id'] ?>" onclick="return confirm('Yakin?')">Delete</a>
    </td>
</tr>
<?php } ?>
</table>