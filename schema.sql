CREATE TABLE yoneticiler (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    isim VARCHAR(50) NOT NULL,
    soyisim VARCHAR(50),
    tel VARCHAR(50),
    email VARCHAR(50),
    sifre VARCHAR(255)
);

CREATE TABLE stoklar (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tur VARCHAR(50),
    renk VARCHAR(50),
    birim_fiyat FLOAT(20),
    adet INT(15)
);

CREATE TABLE calisanlar (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    calisan_id VARCHAR(50),
    ad VARCHAR(50),
    soyad VARCHAR(50),
    departman VARCHAR(50),
    maas FLOAT(20)
);