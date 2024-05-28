<?php
include("baglanti.php");
echo "<script>consle.log('".$_GET['id']."')</script>";
$id = $_GET['id'];

$sql = "DELETE FROM calisanlar WHERE id = $id";
$cevap = mysqli_query($connection,$sql);

if(!$cevap ){
echo '<br>Hata:' . mysqli_error($connection);
}
else
{
echo "<script>alert('Çalışan Başarıyla Silindi!');</script>";
}
header("location:anasayfa.php");

?>