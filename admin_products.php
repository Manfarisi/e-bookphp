<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $penulis = $_POST['penulis'];
    $stock = $_POST['stock']; 
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    $selecet_product_name = mysqli_query($conn, "SELECT name FROM  products WHERE name = '$name'") or die('query failed');

    if (mysqli_num_rows($selecet_product_name) > 0) {
        $message[] = 'product name already added';
    } else {
        $add_product_query = mysqli_query($conn, "INSERT INTO products (name, price,penulis,stock, image) VALUES('$name','$price', '$penulis','$stock','$image')") or die('query or failed');

        if ($add_product_query) {
            if ($image_size > 2000000) {
                $message[] = 'image size is too large';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'product added successfully!';
            }
        } else {
            $message[] = 'product could not be added!';
        }
    }
}

if (isset($_POST['purchase_product'])) {
    $product_id = $_POST['product_id'];
    $purchase_quantity = $_POST['purchase_quantity'];

    // Ambil stok saat ini dari database
    $stock_query = mysqli_query($conn, "SELECT stock FROM `products` WHERE id = '$product_id'") or die('Query failed');
    $stock_data = mysqli_fetch_assoc($stock_query);
    $current_stock = $stock_data['stock'];

    if ($purchase_quantity > $current_stock) {
        $message[] = 'Stok tidak mencukupi!';
    } else {
        // Kurangi stok
        $new_stock = $current_stock - $purchase_quantity;
        $update_stock_query = mysqli_query($conn, "UPDATE `products` SET stock = '$new_stock' WHERE id = '$product_id'") or die('Query failed');

        if ($update_stock_query) {
            $message[] = 'Pembelian berhasil!';
        } else {
            $message[] = 'Pembelian gagal, coba lagi.';
        }
    }
}


if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    unlink('uploaded_img/' . $fetch_delete_image['image']);
    mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_products.php');
}

if (isset($_POST['update_product'])) {

    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_penulis = $_POST['update_penulis'];
    $update_stock = $_POST['update_stock'];
    $update_price = $_POST['update_price'];

    mysqli_query($conn, "UPDATE `products` SET name = '$update_name',penulis='$update_penulis', price = '$update_price', stock = '$update_stock' WHERE id = '$update_p_id'") or die('query failed');

    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'uploaded_img/' . $update_image;
    $update_old_image = $_POST['update_old_image'];

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'image file size is too large';
        } else {
            mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
            move_uploaded_file($update_image_tmp_name, $update_folder);
            unlink('uploaded_img/' . $update_old_image);
        }
    }

    header('location:admin_products.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>produk</title>
    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'admin_header.php'; ?>


    <!-- product CRUD section -->
    <section class="add-products">
        <h1 class="title">Perincian Produk</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Tambah Produk</h3>
            <input type="text" name="name" class="box" placeholder="masukan nama produk" required>
            <input type="text" name="penulis" class="box" placeholder="masukan nama penulis" required>
            <input type="number" min='0' name="price" class="box" placeholder="masukan harga barang" required>
            <input type="number" name="stock" class="box" placeholder="masukan jumlah stok" required min="0">
            <input type="file" name="image" accept="image/jgp, image/jpeg, image/png" class="box" required>
            <input type="submit" value="tambah produk" name="add_product" class="btn">
        </form>
    </section>
    <!-- end -->

    <!--  show products -->
    <section class="show-products">
        <div class="box-container">
            <?php
            $selecet_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            if (mysqli_num_rows($selecet_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($selecet_products)) {
            ?>
                    <div class="box">
                        <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                        <div class="name"><?php echo $fetch_products['name']; ?></div>
                        <div class="name"><?php echo $fetch_products['penulis']; ?></div>
                        <div class="name"><?php echo $fetch_products['stock']; ?></div>
                        <div class="price">Rp<?php echo number_format($fetch_products['price'], 0, ',', '.'); ?>,-</div>
                        <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">Update</a>
                        <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('hapus produk ini?')">Hapus</a>
                    </div>
            <?php
                }
            } else {
                echo "<p class='empty'>belum ada produk</p>";
            }
            ?>
        </div>
    </section>
    <!--  show products end -->

    <!-- edit produk -->
    <section class="edit-product-form">

        <?php
        if (isset($_GET['update'])) {
            $update_id = $_GET['update'];
            $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
            if (mysqli_num_rows($update_query) > 0) {
                while ($fetch_update = mysqli_fetch_assoc($update_query)) {
        ?>


                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
                        <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
                        <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
                        <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="masukan nama produk">
                        <input type="text" name="update_penulis" value="<?php echo $fetch_update['penulis']; ?>" class="box" required placeholder="masukan nama penulis">
                        <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="masukan harga produk">
                        <input type="number" name="update_stock" class="box" placeholder="masukan jumlah stok" required min="0">
                        <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
                        <input type="submit" value="update" name="update_product" class="btn">
                        <input type="reset" value="cancel" id="close-update" class="option-btn">
                    </form>
        <?php
                }
            }
        } else {
            echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
        }
        ?>
    </section>
    <!-- edit produk end -->



    <script src="js/admin_script.js"></script>
</body>

</html>