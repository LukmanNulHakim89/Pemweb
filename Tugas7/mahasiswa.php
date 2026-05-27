<?php

/* DELETE */
if(isset($_GET['hapus'])){
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE npm='$_GET[hapus]'");
}

/* EDIT */
if(isset($_GET['edit'])){
    $edit = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE npm='$_GET[edit]'");
    $e = mysqli_fetch_array($edit);
}

/* INSERT / UPDATE */
if(isset($_POST['simpan'])){
    if(isset($_GET['edit'])){
        // update data
        mysqli_query($conn, "UPDATE mahasiswa SET
            nama='$_POST[nama]',
            jurusan='$_POST[jurusan]',
            alamat='$_POST[alamat]'
            WHERE npm='$_GET[edit]'
        ");
    } else {
        // tambah data
        mysqli_query($conn, "INSERT INTO mahasiswa VALUES(
            '$_POST[npm]',
            '$_POST[nama]',
            '$_POST[jurusan]',
            '$_POST[alamat]'
        )");
    }
}
?>

<h3>Data Mahasiswa</h3>

<form method="POST" class="mb-3">
    <!-- readonly saat edit -->
    <input type="text" name="npm" class="form-control mb-2"
        placeholder="NPM"
        value="<?= @$e['npm'] ?>"
        <?= isset($e)?'readonly':'' ?>>

    <input type="text" name="nama" class="form-control mb-2"
        placeholder="Nama"
        value="<?= @$e['nama'] ?>">

    <!-- selected saat edit -->
    <select name="jurusan" class="form-control mb-2">
        <option <?= (@$e['jurusan']=='Teknik Informatika')?'selected':'' ?>>Teknik Informatika</option>
        <option <?= (@$e['jurusan']=='Sistem Operasi')?'selected':'' ?>>Sistem Operasi</option>
    </select>

     <textarea name="alamat" class="form-control mb-2"><?= @$e['alamat'] ?></textarea>

    <button name="simpan" class="btn btn-primary">
        <?= isset($e)?'Update':'Simpan' ?>
    </button>
</form>

<table class="table table-bordered">
<thead class="table-dark">
<tr>
    <th>NPM</th>
    <th>Nama</th>
    <th>Aksi</th>
</tr>
</thead>

<?php
$data = mysqli_query($conn, "SELECT * FROM mahasiswa");
while($d = mysqli_fetch_array($data)){
?>
<tr>
    <td><?= $d['npm'] ?></td>
    <td><?= $d['nama'] ?></td>
    <td>
        <!-- tetap di halaman mahasiswa -->
        <a href="?hal=mahasiswa&edit=<?= $d['npm'] ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="?hal=mahasiswa&hapus=<?= $d['npm'] ?>" class="btn btn-danger btn-sm">Delete</a>
    </td>
</tr>
<?php } ?>
</table>