<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    die();
}

include("connection.php");

if (isset($_GET["message"])) {
    $message = $_GET["message"];
}

$query = "SELECT * FROM student ORDER BY nim ASC";
$result = mysqli_query($connection, $query);
if(!$result) {
    die ("Query Error: ".mysqli_errno($connection)." - ".mysqli_error($connection));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Mahasiswa</title>
<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f9fafb;
    margin: 0;
    padding: 0;
    color: #333;
}
.container {
    width: 90%;
    max-width: 900px;
    margin: 40px auto;
    background: #fff;
    padding: 25px 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
h1 {
    text-align: center;
    color: #1e293b;
}
nav {
    text-align: center;
    margin-bottom: 20px;
}
nav a {
    text-decoration: none;
    color: white;
    background-color: #2563eb;
    padding: 8px 15px;
    border-radius: 6px;
    margin: 0 5px;
    transition: 0.3s;
}
nav a:hover {
    background-color: #1d4ed8;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
th {
    background-color: #2563eb;
    color: white;
    padding: 10px;
}
td {
    padding: 10px;
    border-bottom: 1px solid #e5e7eb;
}
tr:hover {
    background-color: #f3f4f6;
}
a.edit-btn {
    color: white;
    background-color: #22c55e;
    padding: 5px 10px;
    border-radius: 5px;
    text-decoration: none;
}
a.edit-btn:hover {
    background-color: #16a34a;
}
a.delete-btn {
    color: white;
    background-color: #ef4444;
    padding: 5px 10px;
    border-radius: 5px;
    text-decoration: none;
}
a.delete-btn:hover {
    background-color: #dc2626;
}
.pesan {
    background-color: #dcfce7;
    color: #166534;
    border: 1px solid #86efac;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
}
</style>
</head>
<body>
<div class="container">
    <h1>Data Mahasiswa</h1>
    <nav>
        <a href="student_view.php">Tampil</a>
        <a href="student_add.php">Tambah</a>
        <a href="logout.php">Logout</a>
    </nav>
    <?php if (isset($message)) echo "<div class='pesan'>$message</div>"; ?>
    <table>
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Fakultas</th>
            <th>Jurusan</th>
            <th>IPK</th>
            <th>Aksi</th>
        </tr>
        <?php while($data = mysqli_fetch_assoc($result)): ?>
            <?php $formatted_date = date("d-m-Y", strtotime($data["birth_date"])); ?>
            <tr>
                <td><?= $data['nim'] ?></td>
                <td><?= $data['name'] ?></td>
                <td><?= $data['birth_city'] ?></td>
                <td><?= $formatted_date ?></td>
                <td><?= $data['faculty'] ?></td>
                <td><?= $data['department'] ?></td>
                <td><?= $data['gpa'] ?></td>
                <td>
                    <a class="edit-btn" href="student_edit.php?nim=<?= $data['nim'] ?>">Edit</a>
                    <a class="delete-btn" href="student_delete.php?nim=<?= $data['nim'] ?>" onclick="return confirm('Yakin ingin menghapus mahasiswa dengan NIM <?= $data['nim'] ?>?');">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php
mysqli_free_result($result);
mysqli_close($connection);
?>
</body>
</html>
