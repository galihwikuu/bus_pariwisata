<?php

include '../config/koneksi.php';

$id = (int)$_GET['id'];

$data = mysqli_query(
    $conn,
    "SELECT * FROM galeri WHERE id = $id"
);

$foto = mysqli_fetch_assoc($data);

if($foto){

    $file = "../assets/images/galeri/" . $foto['foto'];

    if(file_exists($file)){
        unlink($file);
    }

    mysqli_query(
        $conn,
        "DELETE FROM galeri WHERE id = $id"
    );
}

header("Location: galeri.php");
exit;