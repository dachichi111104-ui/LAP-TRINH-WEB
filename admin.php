<?php
require_once 'function.php';
$admin = new admin();
if (!$admin->KiemTraDangNhapAdmin()) {
    header("Location: loginadmin.php");
    exit();
}

$page = isset($_GET['page']) ? $_GET['page'] : 'trangchu';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Trang quản trị hệ thống</title>
  <link rel="stylesheet" href="style1.css">
</head>
<body>
  <div class="admin-container">
    <aside class="sidebar">
      <nav>
        <ul>
          <li><a href="admin.php?page=trangchu" class="<?= $page=='trangchu'?'active':'' ?>">Trang chủ</a></li>
          <li><a href="admin.php?page=hangsx" class="<?= $page=='hangsx'?'active':'' ?>">Quản lý Hãng sản xuất</a></li>
          <li><a href="admin.php?page=dienthoai" class="<?= $page=='dienthoai'?'active':'' ?>">Quản lý Điện thoại</a></li>
          <li><a href="admin.php?page=donhang" class="<?= $page=='donhang'?'active':'' ?>">Quản lý Đơn hàng</a></li>
          <li><a href="admin.php?page=khachhang" class="<?= $page=='khachhang'?'active':'' ?>"> Quản lý Khách hàng</a></li>
        </ul>
      </nav>
      <div class="logout"><a href="adminlogout.php">Đăng xuất</a></div>
    </aside>

    <main class="main-content">
      <header class="admin-header">
        <h1>Hệ thống quản trị</h1>
        <p>Xin chào, Admin!</p>
      </header>

      <section class="page-content">
        <?php
          switch ($page) {
            case 'hangsx': include 'qlyhsx.php'; break;
            case 'themhsx': include 'themhsx.php'; break;
            case 'suahsx': include 'suahsx.php'; break;
            case 'dienthoai': include 'qlydienthoai.php'; break;
            case 'themsp': include 'themsp.php'; break;
            case 'suasp': include 'suasp.php'; break;
            case 'donhang': include 'qlydonhang.php'; break;
            case 'suadonhang' : include 'suadonhang.php'; break;
            case 'chitietdonhang' : include 'chitietdonhang.php'; break;
            case 'khachhang': include 'qlykh.php'; break;
            case 'themkh' : include 'themkh.php'; break;
            case 'suakh' : include 'suakh.php'; break;
            default:
      ?>
            <h2>Chào mừng đến Trang quản trị!</h2>
      <?php
            break;
      }
        ?>
      </section>

      <footer class="admin-footer">
        <p>© 2025 - Hệ thống quản trị bán điện thoại</p>
      </footer>
    </main>
  </div>
</body>
</html>
