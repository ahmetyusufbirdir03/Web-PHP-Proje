<?php
include("baglanti.php");
$id = $_GET['id'];

$sql = "DELETE FROM stoklar WHERE id = $id";
//sorguyu veritabanina gönderiyoruz.
$cevap = mysqli_query($connection,$sql);

if(!$cevap ){
echo '<br>Hata:' . mysqli_error($connection);
}
else
{
echo "Kayıt Silindi!</br>";
echo " <a href='anasayfa.php'> geri dön</a>\n";
}
header("location:anasayfa.php");

?>