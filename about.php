<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>tentang</title>

   <!-- tautan font awesome cdn -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- tautan file css kustom -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>tentang kami</h3>
   <p> <a href="home.php">beranda</a> / tentang </p>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>mengapa memilih kami?</h3>
         <p>Kami menyediakan layanan pembelian e-book secara grosir dengan harga terjangkau dan koleksi yang lengkap. Setiap buku yang kami tawarkan dipilih secara cermat untuk memenuhi kebutuhan pembaca di berbagai bidang, mulai dari pendidikan, hiburan, hingga pengembangan diri.</p>
         <a href="contact.php" class="btn">hubungi kami</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">ulasan pelanggan</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/pic-1.png" alt="">
         <p>Saya sangat puas dengan layanan dari platform ini. Pembelian e-book dalam jumlah besar sangat mudah dan efisien. Koleksi bukunya juga sangat lengkap!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Andi Saputra</h3>
      </div>

      <div class="box">
         <img src="images/pic-2.png" alt="">
         <p>Proses pembelian cepat dan banyak pilihan buku menarik. Sangat cocok untuk kebutuhan bisnis saya dalam menyediakan bahan bacaan untuk klien.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Siti Nurhaliza</h3>
      </div>

      <div class="box">
         <img src="images/pic-3.png" alt="">
         <p>Harga grosir yang ditawarkan sangat kompetitif, dan kualitas buku digitalnya sangat bagus. Saya pasti akan berlangganan di sini.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Rina Handayani</h3>
      </div>

   </div>

</section>

<section class="authors">

   <h1 class="title">penulis hebat</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/author-1.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Ahmad Fauzi</h3>
      </div>

      <div class="box">
         <img src="images/author-2.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Siti Khadijah</h3>
      </div>

      <div class="box">
         <img src="images/author-3.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Rahmat Hidayat</h3>
      </div>

   </div>

</section>

<?php include 'footer.php'; ?>

<!-- tautan file js kustom -->
<script src="js/script.js"></script>

</body>
</html>
