<?php
session_start();
include_once 'config.php';
$db = new dienthoai();

$page = $_GET['page'] ?? 'home';

?><!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>PHONESTORE</title>
  <link rel="stylesheet" href="style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <header class="header">
    <div class="container">
      <div class="logo">
        <a href="index.php"><img src="HINH/phone.PNG" alt="PHONESTORE Logo"></a>
        <a href="index.php" style="text-decoration: none;"> <span style="color: #000; font-size: 1rem;"><strong>PHONESTORE</strong></span> </a>
      </div>

      <nav class="navbar">
        <a href="index.php?page=home">Trang chủ</a>
        <a href="index.php?page=thuonghieu">Thương hiệu</a>
      </nav>

      <div class="search-box">
        <form class="admin-form" method="get" action="index.php">
            <input type="hidden" name="page" value="search">
          <input type="text" name="q" placeholder="Tìm kiếm...">
          <i class='bx bx-search'></i>
        </form>
      </div>

      <div class="icons">
      <?php
        $soLuongGioHang = $db->DemSoLuongGioHang();
      ?>
      <?php if (isset($_SESSION['hoTen'])): ?>
        <div class="welcome-message">Xin chào, <?=htmlspecialchars($_SESSION['hoTen'])?>!</div>
      <?php endif; ?>
        <a class="button" href="index.php?page=users"><i class='bx bx-user'></i></a>
        <a class="button cart-wrapper" href="index.php?page=cart"><i class='bx bx-cart'></i>

      <?php if ($soLuongGioHang > 0): ?>
        <span class="cart-badge"><?= $soLuongGioHang ?></span>
      <?php endif; ?>
        </a>
        <a class="button" href="process.php?action=logout"><i class='bx bx-log-out'></i></a>
      </div>
    </div>
  </header>
  <main class="content2">
  <?php
switch ($page) {
  case 'home':
    include 'index_home.php';
    break;
  case 'thuonghieu':
    include 'thuonghieu.php';
    break;
  case 'product':
    include 'product_detail.php';
    break;
  case 'cart':
    include 'cart_view.php';
    break;
  case 'checkout':
    include 'checkout_view.php';
    break;
  case 'success':
    include 'success_view.php';
    break;
  case 'users':
    include 'users.php'; 
    break;
  case 'search':
    include 'search.php';
    break;
  default:
    include 'index_home.php';
}
  ?>
  </main>
    <footer class="footer">
      <div class="contact-info">
        <br>
        <h3>Liên hệ với chúng tôi</h3>
        <img src="HINH/lienhe.png" alt="số điện thoại" class="icon1"> 1900 1234
        <br>
        <img src="HINH/mail.png" alt="email" class="icon1"> support@phonestore.vn
        <br>
        <img src="HINH/vitri.png" alt="địa chỉ" class="icon1"> 123 Đường ABC, Quận 1, TP.HCM
      </div>

      <div class="last">&copy; 2025 PHONESTORE. All rights reserved.</div>
    </footer>
</body>
</html>

<style>
.cart-wrapper {
    position: relative;
}

.cart-badge {
    position: absolute;
    top: -6px;
    right: -8px;
    background: #e4003a;
    color: #fff;
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 50%;
    font-weight: bold;
    line-height: 1;
}
</style>