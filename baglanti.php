<?php

$host = 'localhost';
$kullanici = 'root';
$sifre = '';
$vt = 'denemem2';  

$connection = mysqli_connect($host, $kullanici, $sifre, $vt);
mysqli_set_charset($connection, 'UTF8');
if(!$connection)
    echo 'hata';
$sql = "SHOW TABLES LIKE 'yoneticiler'";
$result = mysqli_query($connection, $sql);
if(mysqli_num_rows($result) > 0)
    echo "<script>console.log('yoneticiler tablosu zaten mevcut.')</script>";
else{
    $createTableSql = "
    CREATE TABLE yoneticiler (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        isim VARCHAR(50) NOT NULL,
        soyisim VARCHAR(50),
        tel VARCHAR(50),
        email VARCHAR(50),
        sifre VARCHAR(255)
    )";

    if (mysqli_query($connection, $createTableSql)) {
        echo "<script>console.log('yoneticiler olusturuldu.')</script>";
    } else {
        echo "Tablo oluşturulurken hata oluştu: " . mysqli_error($connection);
    }
}
$sql = "SHOW TABLES LIKE 'stoklar'";
$result = mysqli_query($connection, $sql);
if(mysqli_num_rows($result) > 0)
    echo "<script>console.log('stok tablosu zaten mevcut.')</script>";
else{
    $createTableSql = "
    CREATE TABLE stoklar (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        tur VARCHAR(50),
        renk VARCHAR(50),
        birim_fiyat FLOAT(20),
        adet INT(15)
    )";

    if (mysqli_query($connection, $createTableSql)) {
        echo "<script>console.log('stoklar tablosu olusturuldu.')</script>";
    } else {
        echo "Tablo oluşturulurken hata oluştu: " . mysqli_error($connection);
    }
}

$sql = "SHOW TABLES LIKE 'calisanlar'";
$result = mysqli_query($connection, $sql);
if(mysqli_num_rows($result) > 0)
    echo "<script>console.log('calisan tablosu zaten mevcut.')</script>";
else{
    $createTableSql = "
    CREATE TABLE calisanlar (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        calisan_id VARCHAR(50),
        ad VARCHAR(50),
        soyad VARCHAR(50),
        departman VARCHAR(50),
        maas FLOAT(20)
    )";

    if (mysqli_query($connection, $createTableSql)) {
        echo "<script>console.log('calisan tablosu olusturuldu.')</script>";
    } else {
        echo "Tablo oluşturulurken hata oluştu: " . mysqli_error($connection);
    }
}

?>