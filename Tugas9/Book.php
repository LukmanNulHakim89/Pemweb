<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tugas 9 - PHP OOP | Class Book</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f5f5f5; }
        h2   { color: #333; border-bottom: 2px solid #4a90d9; padding-bottom: 6px; }
        .box { background: #fff; border: 1px solid #ddd; border-radius: 8px;
               padding: 16px 20px; margin-bottom: 16px; }
        .box h3  { margin: 0 0 10px; font-size: 15px; color: #555; }
        .success { color: #2e7d32; font-weight: bold; }
        .error   { color: #c62828; font-weight: bold; }
        .info    { color: #1565c0; }
        table    { border-collapse: collapse; width: 100%; }
        td, th   { padding: 6px 12px; border: 1px solid #e0e0e0; font-size: 14px; }
        th       { background: #4a90d9; color: #fff; text-align: left; }
        tr:nth-child(even) { background: #f9f9f9; }
    </style>
</head>
<body>

<?php
class Book
{
    // 3 property private
    private $code_book;
    private $name;
    private $qty;

    // Constructor memanggil private setter untuk code_book dan qty
    public function __construct($code_book, $name, $qty)
    {
        $this->setCodeBook($code_book);
        $this->name = $name;
        $this->setQty($qty);
    }

    // Setter private: validasi format code_book (2 huruf kapital + 2 angka)
    private function setCodeBook($code_book)
    {
        if (preg_match('/^[A-Z]{2}[0-9]{2}$/', $code_book)) {
            $this->code_book = $code_book;
        } else {
            echo "<span class='error'>Error: Format code_book \"$code_book\" tidak sesuai! Format harus 2 huruf kapital diikuti 2 angka (contoh: BB00)</span><br>";
        }
    }

    // Setter private: validasi qty harus integer positif
    private function setQty($qty)
    {
        if (is_int($qty) && $qty > 0) {
            $this->qty = $qty;
        } else {
            if ($qty === 0) {
                echo "<span class='error'>Error: qty tidak boleh 0. Harus bilangan integer positif!</span><br>";
            } elseif (is_int($qty) && $qty < 0) {
                echo "<span class='error'>Error: qty tidak boleh negatif ($qty). Harus bilangan integer positif!</span><br>";
            } else {
                echo "<span class='error'>Error: qty harus berupa bilangan integer!</span><br>";
            }
        }
    }

    // Getter: kembalikan nilai property
    public function getCodeBook()
    {
        return $this->code_book;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getQty()
    {
        return $this->qty;
    }
}
?>

<h2>Tugas 9.7 — Class Book (PHP OOP)</h2>

<div class="box">
    <h3>Test 1 — Data Valid (BB12, qty positif)</h3>
    <?php $book1 = new Book("BB12", "PHP OOP For Beginner", 20); ?>
    <table>
        <tr><th>Property</th><th>Nilai</th></tr>
        <tr><td>Code Book</td><td class="success"><?= $book1->getCodeBook() ?></td></tr>
        <tr><td>Name</td>     <td class="info">  <?= $book1->getName()     ?></td></tr>
        <tr><td>Qty</td>      <td class="success"><?= $book1->getQty()      ?></td></tr>
    </table>
</div>

<div class="box">
    <h3>Test 2 — code_book huruf kecil "ab12" (tidak valid)</h3>
    <?php $book2 = new Book("ab12", "Javascript For Beginner", 15); ?>
    <p class="info">
        Code Book : <?= $book2->getCodeBook() ?? '<em style="color:#999">null (gagal di-set)</em>' ?><br>
        Name      : <?= $book2->getName() ?><br>
        Qty       : <?= $book2->getQty() ?>
    </p>
</div>

<div class="box">
    <h3>Test 3 — code_book format salah "12AB" (angka di depan)</h3>
    <?php $book3 = new Book("12AB", "CSS Mastery", 8); ?>
    <p class="info">
        Code Book : <?= $book3->getCodeBook() ?? '<em style="color:#999">null (gagal di-set)</em>' ?><br>
        Name      : <?= $book3->getName() ?><br>
        Qty       : <?= $book3->getQty() ?>
    </p>
</div>

<div class="box">
    <h3>Test 4 — qty = 0 (tidak valid)</h3>
    <?php $book4 = new Book("CD34", "HTML Dasar", 0); ?>
    <p class="info">
        Code Book : <?= $book4->getCodeBook() ?? '<em style="color:#999">null</em>' ?><br>
        Name      : <?= $book4->getName() ?><br>
        Qty       : <?= $book4->getQty() ?? '<em style="color:#999">null (gagal di-set)</em>' ?>
    </p>
</div>

<div class="box">
    <h3>Test 5 — qty negatif = -5 (tidak valid)</h3>
    <?php $book5 = new Book("EF56", "Python For Beginner", -5); ?>
    <p class="info">
        Code Book : <?= $book5->getCodeBook() ?? '<em style="color:#999">null</em>' ?><br>
        Name      : <?= $book5->getName() ?><br>
        Qty       : <?= $book5->getQty() ?? '<em style="color:#999">null (gagal di-set)</em>' ?>
    </p>
</div>

<div class="box">
    <h3>Test 6 — Data Valid kedua (ZZ99)</h3>
    <?php $book6 = new Book("ZZ99", "Laravel Framework", 50); ?>
    <table>
        <tr><th>Property</th><th>Nilai</th></tr>
        <tr><td>Code Book</td><td class="success"><?= $book6->getCodeBook() ?></td></tr>
        <tr><td>Name</td>     <td class="info">  <?= $book6->getName()     ?></td></tr>
        <tr><td>Qty</td>      <td class="success"><?= $book6->getQty()      ?></td></tr>
    </table>
</div>
</body>
</html>
