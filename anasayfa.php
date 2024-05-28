<?php
    include("baglanti.php");
    $tur_hatasi = "";
    $renk_hatasi = "";
    $fiyat_hatasi = "";
    $adet_hatasi = "";
    $ad_hatasi = "";
    $soyad_hatasi = "";
    $departman_hatasi = "";
    $maas_hatasi = "";
    $cls_id_hatasi ="";
    $cls_id = "";
    $tur ="";
    $renk ="";
    $fiyat ="";
    $adet ="";
    $ad ="";
    $soyad ="";
    $departman ="";
    $maas ="";
    session_start();
    if(isset($_POST["stok-ekle"])){
        //! TÜR KONTROLÜ
        if(empty($_POST["tur"]))
            $tur_hatasi ="Tür boş geçilemez!";  
        else{
            $holder = $_POST["tur"];
            $holder2 = $_POST["renk"];
            $sql = "SELECT * FROM stoklar WHERE tur ='$holder'AND renk='$holder2'";
            $result = mysqli_query($connection,$sql);
            if(mysqli_num_rows($result) > 0)
                $tur_hatasi ="Böyle bir tür stoklarda zaten kayıtlı!!!";
            else
                $tur = $_POST["tur"];
        }
            

        //! RENK KONTROLÜ
        if(empty($_POST["renk"]))
            $renk_hatasi ="Renk boş geçilemez!";
        else
            $renk = $_POST["renk"];
        
        //! FİYAT KONTROLÜ
        if(empty($_POST["fiyat"]))
            $fiyat_hatasi ="Fiyat boş geçilemez!";
        else if(!is_float(floatval($_POST["fiyat"])))
            $fiyat_hatasi = "Lütfen geçerli bir sayı giriniz!";
        else
            $fiyat = floatval($_POST["fiyat"]);
        
        //! ADET KONTROLÜ
        if(empty($_POST["adet"]))
            $adet_hatasi ="Adet boş geçilemez!";
        else if(!is_numeric($_POST["adet"]))
            $adet_hatasi = "Lütfen geçerli bir sayı giriniz!";
        else
            $adet = intval($_POST["adet"]);
        
        //? EKLEME İŞLEMİ
        if(!empty($tur) && !empty($renk) && !empty($adet) && !empty($fiyat)){
            $sql = "INSERT INTO stoklar(tur,renk,birim_fiyat, adet) 
            VALUES('$tur','$renk','$fiyat','$adet')";
            $stok_ekleme = mysqli_query($connection,$sql);
            if($stok_ekleme){
                echo "<script>alert('Stok Başarıyla Eklendi!');</script>";
            }
            else{
                echo "<script>alert('Stok Eklenirken Hata Oldu!');</script>";
            }
        }
    }

    else if(isset($_POST["calisan-ekle"])){
        //! ID KONTROLÜ            
        if(empty($_POST["cls_id"])){

            $cls_id_hatasi ="ID boş geçilemez!";
        }
        else if(preg_match('/[^0-9]/', $_POST["cls_id"])) 
            $cls_id_hatasi ="ID numarası sadece rakamlardan oluşur!";
        else if(strlen($_POST["cls_id"]) > 11)
            $cls_id_hatasi ="ID numarası en fazla 11 haneli olmalı!";  
        else{
            $holder = $_POST["cls_id"];
            $sql = "SELECT * FROM calisanlar WHERE calisan_id ='$holder'";
            $result = mysqli_query($connection,$sql);
            if(mysqli_num_rows($result) > 0)
                $cls_id_hatasi ="Böyle bir kisi zaten kayıtlı!!!";
            else
                $cls_id = $_POST["cls_id"];
        }
            
        //! AD KONTROLÜ
        if(empty($_POST["ad"]))
            $ad_hatasi ="Ad boş geçilemez!";
        else
            $ad = $_POST["ad"];
        
        //! SOYAD KONTROLÜ
        if(empty($_POST["soyad"]))
            $soyad_hatasi ="Soyad boş geçilemez!";
        else
            $soyad = $_POST["soyad"];
        
        //! DEPARTMAN KONTROLÜ
        if(empty($_POST["departman"]))
            $departman_hatasi ="Adet boş geçilemez!";
        else
            $departman = $_POST["departman"];

        //! MAAŞ KONTROLÜ
        if(empty($_POST["maas"]))
            $maas_hatasi ="Maaş boş geçilemez!";
        else if(!is_numeric($_POST["maas"]))
            $maas_hatasi = "Lütfen geçerli bir sayı giriniz!";
        else
            $maas = floatval($_POST["maas"]);
        
        //? EKLEME İŞLEMİ
        if(!empty($cls_id) && !empty($ad) && !empty($soyad) && !empty($departman) && !empty($maas)){
            $sql = "INSERT INTO calisanlar(calisan_id,ad,soyad,departman,maas) 
            VALUES('$cls_id','$ad','$soyad','$departman','$maas')";
            $calisan_ekleme = mysqli_query($connection,$sql);
            if($calisan_ekleme){
                echo "<script>alert('Çalışan Başarıyla Eklendi!');</script>";
            }
            else{
                echo "<script>alert('Çalışan Eklenirken Hata Oldu!');</script>";
            }
        }
    }
    if($_SESSION["isim"])
    {
        $isim = $_SESSION["isim"];
        $soyisim = $_SESSION["soyisim"];
        $tel = $_SESSION["tel"];
        $email = $_SESSION["email"];
        $sifre = $_SESSION["sifre"];
    }
    else{
        echo "<script>console.log('Hatalı deneme!')</>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management</title>
    <link rel="stylesheet" href="css/self/deneme.css">
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css.map">
    
</head>
<body>
    <div class="left-con">
        <div class="container" style="height: 100%;">
            <ul> 
                <li class="list_title"><label>İşlemler</label></li>
                <li><button class="list_btn active" onclick="profile()"><i class="bi bi-person-bounding-box"></i> Profil</button></li>
                <li><button class="list_btn" onclick="ekle()"><i class="bi bi-box-arrow-in-down"></i> Stok Ekle</button></li>
                <li><button class="list_btn" onclick="stok()"><i class="bi bi-box-seam"></i> Stoklar </button></li>
                <li><button class="list_btn" onclick="calisan_ekle()"><i class="bi bi-person-plus-fill" ></i> Çalışan Ekle</button></li>
                <li><button class="list_btn" onclick="calisanlar()"><i class="bi bi-person-rolodex"></i> Çalışanlar</button></li>
                <li><a href="cikis.php" style="text-decoration:none;"><button class="list_btn" onclick="calisanlar()"><i class="bi bi-box-arrow-right"></i> Çıkış Yap</button></a></li>
            </ul>
        </div>
    </div>
    <div class="right-con">
        <div class="tables active" id="profile_sf" style="display: flex;">
            <div class="container profile" style="border: 2px solid red;">
                <div class="prfimg">
                    <img src="img/profile-icon-2.jpg" style="width: 100%; height: 100%; border-radius: 1.8rem;">
                </div>
                <div class="container infos">
                    <ul class="ul_infos"> 
                        <li class="list_title"><label>Yönetici Profil</label></li>
                        <li><button class="list_btn_inf" ><i class="bi bi-person-badge"></i> İsim:<?php echo "$isim";?> </button></li>
                        <li><button class="list_btn_inf"><i class="bi bi-person-badge"></i> Soyisim: <?php echo "$soyisim";?></button></li>
                        <li><button class="list_btn_inf" ><i class="bi bi-telephone" ></i> Telefon Numarası: <?php echo "$tel";?></button></li>
                        <li><button class="list_btn_inf"><i class="bi bi-envelope"></i> E-posta: <?php echo "$email";?></button></li>
                        <li><button class="list_btn_inf"><i class="bi bi-lock"></i> Şifre: *******</button></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tables" id="ekle_sf" style="display: none;">
            <div class="ekleme">    
                <form class="form-ekle" action="anasayfa.php" method="POST">
                    <h2 style="margin: 0;" name="tur">Stok Ekle</h2>
                    <select name="tur" id="tur" style="width: 200px;" class="<?php
                        if(!empty($tur_hatasi))
                            echo "is-invalid";
                    ?>">
                        <option value="keten" selected>Keten</option>
                        <option value="kase">Kaşe</option>
                        <option value="saten">Saten</option>
                        <option value="kot">Kot</option>
                        <option value="viskon">Viskon</option>
                        <option value="yun">Yün</option>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo $tur_hatasi ?>
                    </div>
                    <select name="renk" id="renk" style="width: 200px;" class="<?php
                        if(!empty($renk_hatasi))
                            echo "is-invalid";
                    ?>">
                        <option value="kirmizi" selected>Kırmızı</option>
                        <option value="siyah">Siyah</option>
                        <option value="beyaz">Beyaz</option>
                        <option value="mavi">Mavi</option>
                        <option value="krem">Krem</option>
                        <option value="gk">Gül Kurusu</option>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo $renk_hatasi ?>
                    </div>
                    <input type="text" placeholder="Birim Fiyatı($)" name="fiyat" class="<?php
                        if(!empty($fiyat_hatasi))
                            echo "is-invalid";
                    ?>">
                    <div class="invalid-feedback">
                        <?php echo $fiyat_hatasi ?>
                    </div>
                    <input type="text" placeholder="Adet" name="adet" class="<?php
                        if(!empty($adet_hatasi))
                            echo "is-invalid";
                    ?>">
                    <div class="invalid-feedback">
                        <?php echo $adet_hatasi ?>
                    </div>
                    <button type="submit" name="stok-ekle">Ekle</button>
                </form>
            </div>
        </div>  
        <div class="tables" id="kayit_sf" style="display: none;">
            <?php 
                $sql = "SELECT * FROM stoklar";
                $stoklar = mysqli_query($connection, $sql);
                if(mysqli_num_rows($stoklar) != 0){
                    echo "<table border=1 class='stok-table'>";
                    echo "<tr class='title'>";
                    echo "<th>Tür</th>";
                    echo "<th>Renk</th>";
                    echo "<th>Birim-fiyat($)</th>";
                    echo "<th>Adet</th>";
                    echo "<th>Sil</th>";
                    echo "</tr>";
                    while($gelen=mysqli_fetch_array($stoklar))
                    {
                        // veritabanından gelen değerlerle tablo satırları
                        //oluşturalım
                        echo "<tr><td>".$gelen['tur']."</td>";
                        echo "<td>".$gelen['renk']."</td>";
                        echo "<td>".$gelen['birim_fiyat']."</td>";
                        echo "<td>".$gelen['adet']."</td>";
                        echo "<td><a href=kayit-sil.php?id=";
                        echo $gelen['id'];
                        echo "><button>Sil</button></a></td></tr>";
                        
                    }
                    echo "</table>";
                    echo "</html>";
                    //veritabani baglantisini kapatiyoruz.
                }
                else{
                    echo "<div style='width: 100%; height: 90%; text-align: center; display: grid; align-content: center;'><h2>STOKLAR BOŞ</h2></div>";
                }
            ?>
        </div>
        <div class="tables" id="calisan_ekle_sf" style="display: none;">
            <div class="ekleme">    
                <form class="form-ekle" action="anasayfa.php" method="POST">
                    <h2 style="margin: 0;">Çalışan Ekle</h2>
                    <input type="text" placeholder="Çalışan ID" name="cls_id" class="<?php
                        if(!empty($id_hatasi))
                            echo "is-invalid";
                    ?>">
                    <div class="invalid-feedback">
                        <?php echo $cls_id_hatasi ?>
                    </div>
                    <input type="text" placeholder="İsim" name="ad" class="<?php
                        if(!empty($ad_hatasi))
                            echo "is-invalid";
                    ?>">
                    <div class="invalid-feedback">
                        <?php echo $ad_hatasi ?>
                    </div>
                    <input type="text" placeholder="Soy İsim" name="soyad" class="<?php
                        if(!empty($soyad_hatasi))
                            echo "is-invalid";
                    ?>">
                    <div class="invalid-feedback">
                        <?php echo $soyad_hatasi ?>
                    </div>
                    <input type="text" placeholder="Departman" name="departman" class="<?php
                        if(!empty($departman_hatasi))
                            echo "is-invalid";
                    ?>">
                    <div class="invalid-feedback">
                        <?php echo $departman_hatasi ?>
                    </div>
                    <input type="text" placeholder="Maaş($)" name="maas" class="<?php
                        if(!empty($maas_hatasi))
                            echo "is-invalid";
                    ?>">
                    <div class="invalid-feedback">
                        <?php echo $maas_hatasi ?>
                    </div>
                    <button type="submit" name="calisan-ekle">Ekle</button>
                </form>
            </div>
        </div>
        <div class="tables" id="calisan_sf" style="display: none;">
            <table class="table table-striped table-hover">
            <?php 
                $sql = "SELECT * FROM calisanlar";
                $calisanlar = mysqli_query($connection, $sql);
                if(mysqli_num_rows($calisanlar) != 0){
                    echo "<table border=1 class='stok-table'>";
                    echo "<tr class='title'>";
                    echo "<th>id</th>";
                    echo "<th>Ad</th>";
                    echo "<th>Soyad</th>";
                    echo "<th>Departman</th>";
                    echo "<th>Maaş($)</th>";
                    echo "<th>Sil</th>";
                    echo "</tr>";
                    while($calisanim=mysqli_fetch_array($calisanlar))
                    {
                        // veritabanından gelen değerlerle tablo satırları
                        //oluşturalım
                        echo "<tr><td>".$calisanim['calisan_id']."</td>";
                        echo "<td>".$calisanim['ad']."</td>";
                        echo "<td>".$calisanim['soyad']."</td>";
                        echo "<td>".$calisanim['departman']."</td>";
                        echo "<td>".$calisanim['maas']."</td>";
                        //sil linki oluşturalım.
                        echo "<td><a href=calisan-sil.php?id=";
                        echo $calisanim['id'];
                        echo "><button>Sil</button></a></td></tr>";
                    }
                    // tablo kodunu bitirelim.
                    echo "</table>";
                    echo "</html>";
                }
                else{
                    echo "<div style='width: 100%; height: 90%; text-align: center; display: grid; align-content: center;'><h2>HENÜZ ÇALIŞANINIZ YOK</h2></div>";
                }
            ?>
        </div>
    </div>
    <script>
        const profile_sf = document.getElementById("profile_sf");
        const calisan_sf = document.getElementById("calisan_sf");
        const stok_sf = document.getElementById("kayit_sf");
        const calisan_ekle_sf = document.getElementById("calisan_ekle_sf");
        const ekle_sf = document.getElementById("ekle_sf");
        const buttons = document.querySelectorAll('.list_btn');

        // Her bir buton için tıklama olayı ekle
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                // Şu anki aktif olan butondan active sınıfını kaldır
                document.querySelector('.list_btn.active').classList.remove('active');
                // Tıklanan butona active sınıfını ekle
                this.classList.add('active');
            });
        });

        function calisanlar(){
            ekle_sf.style.display = "none";
            profile_sf.style.display = "none";
            stok_sf.style.display = "none";
            calisan_ekle_sf.style.display = "none";
            calisan_sf.style.display = "block";
        }
        function profile(){
            ekle_sf.style.display = "none";
            stok_sf.style.display = "none";
            calisan_ekle_sf.style.display = "none";
            calisan_sf.style.display = "none";
            profile_sf.style.display = "flex";
        }
        function calisan_ekle(){
            ekle_sf.style.display = "none";
            profile_sf.style.display = "none";
            stok_sf.style.display = "none";
            calisan_sf.style.display = "none";
            calisan_ekle_sf.style.display = "block";
        }
        function stok(){
            ekle_sf.style.display = "none";
            profile_sf.style.display = "none";
            calisan_ekle_sf.style.display = "none";
            calisan_sf.style.display = "none";
            stok_sf.style.display = "block";
        }
        function ekle(){
            stok_sf.style.display = "none";
            calisan_ekle_sf.style.display = "none";
            calisan_sf.style.display = "none";
            profile_sf.style.display = "none";
            ekle_sf.style.display = "flex";
        }
    </script>
</body>
</html>