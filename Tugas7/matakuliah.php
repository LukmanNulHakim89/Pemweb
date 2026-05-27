<?php

/* DELETE */
if(isset($_GET['hapus'])){
    mysqli_query($conn, "DELETE FROM matakuliah WHERE kodemk='$_GET[hapus]'");
}

/* EDIT */
if(isset($_GET['edit'])){
    $edit = mysqli_query($conn, "SELECT * FROM matakuliah WHERE kodemk='$_GET[edit]'");
    $e = mysqli_fetch_array($edit);
}

/* INSERT / UPDATE */
if(isset($_POST['simpan'])){
    if(isset($_GET['edit'])){
        // update
        mysqli_query($conn, "UPDATE matakuliah SET
            nama='$_POST[nama]',
            jumlah_sks='$_POST[sks]'
            WHERE kodemk='$_GET[edit]'
        ");
    } else {
        // insert
        mysqli_query($conn, "INSERT INTO matakuliah VALUES(
            '$_POST[kodemk]',
            '$_POST[nama]',
            '$_POST[sks]'
        )");
    }
}
?>

<h3>Data Matakuliah</h3>

<form method="POST" class="mb-3">
    <!-- readonly saat edit -->
    <input type="text" name="kodemk" class="form-control mb-2" placeholder="Kode Mata Kuliah"
        value="<?= @$e['kodemk'] ?>" <?= isset($e)?'readonly':'' ?>>

    <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Mata Kuliah"
        value="<?= @$e['nama'] ?>">

    <input type="number" name="sks" class="form-control mb-2" placeholder="Jumlah SKS"
        value="<?= @$e['jumlah_sks'] ?>">

    <button name="simpan" class="btn btn-primary">
        <?= isset($e)?'Update':'Simpan' ?>
    </button>
</form>

<table class="table table-bordered">
<thead class="table-dark">
<tr>
    <th>Kode</th>
    <th>Nama</th>
    <th>Aksi</th>
</tr>
</thead>

<?php
$data = mysqli_query($conn, "SELECT * FROM matakuliah");
while($d = mysqli_fetch_array($data)){
?>
<tr>
    <td><?= $d['kodemk'] ?></td>
    <td><?= $d['nama'] ?></td>
    <td>
        <a href="?hal=matakuliah&edit=<?= $d['kodemk'] ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="?hal=matakuliah&hapus=<?= $d['kodemk'] ?>" class="btn btn-danger btn-sm">Delete</a>
    </td>
</tr>
<?php } ?>
</table>