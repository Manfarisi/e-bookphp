<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_stock = $_POST['product_stock'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query gagal');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'Produk sudah ada di keranjang!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, stock, quantity, image) VALUES('$user_id', '$product_name', '$product_price','$product_stock', '$product_quantity', '$product_image')") or die('query gagal');
      $message[] = 'Produk berhasil ditambahkan ke keranjang!';
   }

}

?>

<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Beranda</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>Buku Pilihan Langsung ke Pintu Anda.</h3>
      <p>Temukan koleksi eBook terbaik yang dapat Anda unduh kapan saja. Kami menyediakan berbagai genre untuk memenuhi kebutuhan membaca Anda.</p>
      <a href="about.php" class="white-btn">Selengkapnya</a>
   </div>

</section>

<section class="products">

   <h1 class="title">Produk Terbaru</h1>

   <div class="box-container">

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query gagal');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name">Nama: <?php echo $fetch_products['name']; ?></div>
      <div class="name">Stok: <?php echo $fetch_products['stock']; ?></div>
      <div class="price">Harga: Rp<?php echo number_format($fetch_products['price'], 0, ',', '.'); ?></div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo number_format($fetch_products['price'], 0, ',', '.'); ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <input type="submit" value="Tambah ke Keranjang" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">Belum ada produk yang ditambahkan!</p>';
      }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">Lihat Lainnya</a>
   </div>

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>Tentang Kami</h3>
         <p>Kami adalah toko buku elektronik yang menyediakan berbagai pilihan eBook dengan harga terjangkau. Dengan layanan kami, Anda dapat dengan mudah membeli dan membaca buku favorit tanpa harus meninggalkan rumah.</p>
         <a href="about.php" class="btn">Baca Selengkapnya</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>Ada Pertanyaan?</h3>
      <p>Jika Anda memiliki pertanyaan tentang eBook atau proses pembelian, tim kami siap membantu Anda. Hubungi kami kapan saja untuk informasi lebih lanjut.</p>
      <a href="contact.php" class="white-btn">Hubungi Kami</a>
   </div>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
