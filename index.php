<?php
//todo: include("baglanti.php");
include("baglanti.php");

session_start(); 

if(isset($_SESSION['tel'])) {
    header("Location: anasayfa.php");
    exit; 
}
$isim_hatasi = "";
$soyisim_hatasi = "";
$tel_hatasi = "";
$email_hatasi = "";
$sifre_hatasi = "";
if(isset($_POST["kyt-btn"])){
    //* isim girişi kontrolü
    if(empty($_POST["isim"]))
        $isim_hatasi ="İsim boş geçilemez!";
    
    else
        $isim = $_POST["isim"];

    //* soyisim girişi kontrolü
    if(empty($_POST["soyisim"]))
        $soyisim_hatasi ="Soyisim boş geçilemez!";
    else
        $soyisim = $_POST["soyisim"];

    //* telefon girişi kontrolü
    if(empty($_POST["tel_no"]))
        $tel_hatasi ="Telefon numarası boş geçilemez!";
    else if(preg_match('/[^0-9]/', $_POST["tel_no"])) 
        $tel_hatasi ="Telefon numarası sadece rakamlardan oluşur!";
    else if(strlen($_POST["tel_no"]) != 11)
        $tel_hatasi ="Telefon numarası 11 haneli olmalı!";
    else if(strcmp($_POST["tel_no"][0], "0") != 0)
        $tel_hatasi ="Telefon numarası ilk hanesi sıfır olmalı!";
    else{
        $holder = $_POST["tel_no"];
        $sql = "SELECT * FROM yoneticiler WHERE tel = '$holder'";
        $result = mysqli_query($connection, $sql);
        if(mysqli_num_rows($result) > 0)
            $tel_hatasi = "Böyle bir kullanıcı zaten var!";
        else
            $tel_no = $_POST["tel_no"];
    }

    //* eposta girişi kontrolü
    if(empty($_POST["email"]))
        $email_hatasi ="E-posta boş geçilemez!";
    
    else
        $email = $_POST["email"];

    //* şifre girişi kontrolü
    if(empty($_POST["sifre"]))
        $sifre_hatasi ="Şifre boş geçilemez!";
    
    else
        $sifre = password_hash($_POST['sifre'], PASSWORD_BCRYPT);

    if(!empty($isim) && !empty($soyisim) && !empty($tel_no) && !empty($email) && !empty($sifre)){
        $sql ="INSERT INTO yoneticiler(isim,soyisim,
        tel, email, sifre) 
        VALUES('$isim','$soyisim','$tel_no','$email','$sifre')";

        $ekleme = mysqli_query($connection, $sql);
        if($ekleme){
            echo "<script>console.log('yonetici ekleme basarili.')</script>";
            
            $control = "SELECT * FROM yoneticiler WHERE isim = '$isim'";
            $gonder = mysqli_query($connection, $control);
            if($gonder){
                $yoneticiler = mysqli_num_rows($gonder);
                if($yoneticiler > 0){
                    $yoneticim = mysqli_fetch_assoc($gonder);
                    echo "<script>console.log('session.')</script>";
                    $_SESSION["isim"] = $yoneticim["isim"];
                    $_SESSION["soyisim"] = $yoneticim["soyisim"];
                    $_SESSION["tel"] = $yoneticim["tel"];
                    $_SESSION["email"] = $yoneticim["email"];
                    $_SESSION["sifre"] = $yoneticim["sifre"];
                    header("location:anasayfa.php");
                }
                else
                    echo "<script>console.log('yoneticiler hatasi.')</script>";
            }
            else
                echo "<script>console.log('kayit giris sorgu basarisiz.')</script>";
        }
        else
            echo "<script>console.log('yonetici ekleme basarisiz.')</script>";
    } 
    
}
else if(isset($_POST["grs-btn"])){
    $grs_tel_hatasi = "";
    $grs_sifre_hatasi = "";
    //* şifre girişi kontrolü
    if(empty($_POST["grs-sifre"]))
        $grs_sifre_hatasi ="Şifre boş geçilemez!";
    else
        $sifre = $_POST['grs-sifre'];

    //* tel girişi kontrolü
    if(empty($_POST["grs-tel"]))
        $grs_tel_hatasi ="Telefon numarası boş geçilemez!";
    else if(preg_match('/[^0-9]/', $_POST["grs-tel"])) 
        $grs_tel_hatasi ="Telefon numarası sadece rakamlardan oluşur!";
    else if(strlen($_POST["grs-tel"]) != 11)
        $grs_tel_hatasi ="Telefon numarası 11 haneli olmalı!";
    else if(strcmp($_POST["grs-tel"][0], "0") != 0)
        $grs_tel_hatasi ="Telefon numarası ilk hanesi sıfır olmalı!";
    else
        $tel = $_POST["grs-tel"];

    if(!empty($tel) && !empty($sifre)){
        $sql ="SELECT * FROM yoneticiler WHERE tel = '$tel'";
        $result =  mysqli_query($connection, $sql);
        if(mysqli_num_rows($result) > 0){
            $kisi = mysqli_fetch_assoc($result);
            $kisi_sifre = $kisi["sifre"];
            if(password_verify($sifre, $kisi_sifre)){

                $_SESSION["isim"] = $kisi["isim"];
                $_SESSION["soyisim"] = $kisi["soyisim"];
                $_SESSION["tel"] = $kisi["tel"];
                $_SESSION["email"] = $kisi["email"];
                $_SESSION["sifre"] = $kisi["sifre"];
                header("location:anasayfa.php");
            }
            else
                $grs_sifre_hatasi = "Hatalı Şifre!";
        }
        else
            $grs_tel_hatasi = "Hatalı Telefon Numrası";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="authot" content="Ahmet Yusuf Birdir">
    <link href="img/indir.jpeg" rel="icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>New</title>
    <style>
        @import url("css/all.css");
        
    </style>
</head>
<body>
    <header class="backImg text-center text-white">
        <div class="container">
            <div class="tanitim-baslik mt-3"><h2><a href="https://github.com/ahmetyusufbirdir03/Web-PHP-Proje" style="text-decoration: none; color: wheat;">Git Hub Link</h2></a></div>
            <div class="tanitim-baslik mt-3">Hoşgeldiniz</div>
            <div class="tanitim-alt-baslik ">GİRİŞ VEYA KAYIT İÇİN TIKLAYINIZ</div>
            <a href="#signup" class="btn btn-lg p-lg-4 ">KAYIT OL</a>
            <a href="#signin" class="btn btn-lg p-lg-4 ">GİRİŞ YAP</a>
        </div>
    </header>
    <header class="backImg text-center text-white" >
        <div class="container mt-5">
            <div  id="signup">
                <form action="index.php#signup" method="POST" class="form">
                    <h2 class="form-title "><i class="bi bi-person-plus-fill text-dark"></i> Kayıt Ol</h2>
                    <input type="text" name="isim" placeholder="İsim" class="input form-control<?php
                        if(!empty($isim_hatasi))
                            echo " is-invalid";
                    ?>">
                    <div class="invalid-feedback">
                        <?php echo $isim_hatasi ?>
                      </div>
                    <input type="text" name="soyisim" placeholder="Soyisim" class="input form-control<?php
                        if(!empty($soyisim_hatasi))
                            echo " is-invalid";
                    ?>">
                    <div class="invalid-feedback">
                        <?php echo $soyisim_hatasi ?> 
                    </div>
                    <input type="email" name="email" placeholder="E-posta" class="input form-control<?php
                        if(!empty($email_hatasi))
                            echo " is-invalid";
                    ?>">
                    <div class="invalid-feedback">
                        <?php echo $email_hatasi ?>
                      </div>
                    <input type="tel" name="tel_no" placeholder="Telefon Numarası" class="input form-control<?php
                        if(!empty($tel_hatasi))
                            echo " is-invalid";
                    ?>">
                    <div class="invalid-feedback">
                        <?php echo $tel_hatasi ?>
                      </div>
                    <input type="password" name="sifre" placeholder="Şifre" class="input form-control<?php
                        if(!empty($sifre_hatasi))
                            echo " is-invalid";
                    ?>">
                    <div class="invalid-feedback">
                        <?php echo $sifre_hatasi ;
                        if(!empty($sifre_hatasi))?>
                      </div><br>
                    <button class="btn btn-lg text-uppercase " type="submit" name="kyt-btn"><i class="bi bi-plus-circle-fill"></i> Kayıt Ol</button>
                </form>
            </div>
        </div>
    </header>
    <header class="backImg text-center text-white">
        <div class="container mt-5">
            <div  id="signin">
                <form action="index.php#signin" method="POST" class="form">
                    <h2 class="form-title"><i class="bi bi-door-open-fill text-dark"></i>Giriş</h2>
                    <input type="text" name="grs-tel" placeholder="Telefon Numarası" class="input form-control<?php
                        if(!empty($grs_tel_hatasi))
                            echo " is-invalid";
                    ?>">
                    <div class="invalid-feedback">
                        <?php echo $grs_tel_hatasi ?>
                      </div>
                      <input type="password" name="grs-sifre" placeholder="Şifre" class="input form-control<?php
                        if(!empty($grs_sifre_hatasi))
                            echo " is-invalid";
                    ?>">
                    <div class="invalid-feedback">
                        <?php echo $grs_sifre_hatasi ?>
                      </div><br>
                    <button class="btn btn-lg text-uppercase " type="submit" name="grs-btn"><i class="bi bi-plus-circle-fill"></i> Giriş Yap</button>
                </form>
            </div>
        </div>
    </header>
    <script src="js/bootstrap/bootstrap.bundle.min.js.map"></>
    <script src="js/self/self.js"></script>
</body>
</html>
