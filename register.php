<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
$msg = $_SESSION['msg'] ?? "";
unset($_SESSION['msg']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký tài khoản</title>
  <link rel="stylesheet" href="style.css"> 
</head>
<body class="login-page">
  <div class="login-box">
    <div> </br> </div>
    <h2>Đăng ký tài khoản</h2>
<form method="post" action="process.php?action=register">
      <div class="form-group">
        <label for="hoTen">Họ và tên</label>
        <input type="text" id="hoTen" name="hoTen" placeholder="Nhập họ tên của bạn" required>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Nhập email" required>
      </div>

      <div class="form-group">
        <label for="password">Mật khẩu</label>
        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
      </div>

      <div class="form-group">
        <label for="confirm">Xác nhận mật khẩu</label>
        <input type="password" id="confirm" name="confirm" placeholder="Nhập lại mật khẩu" required>
      </div>

      <div class="form-group">
        <label for="soDienThoai">Số điện thoại</label>
        <input type="tel" id="soDienThoai" name="soDienThoai" placeholder="Nhập số điện thoại" required>
      </div>

  <?php if (!empty($msg)) echo $msg; ?>

      <button type="submit" name="register" class="btn-login">Đăng ký</button>
    </form>

    <div class="note">
      Đã có tài khoản? <a href="login.php" style="color:#0a74da; text-decoration:none;">Đăng nhập</a>
          <a class="btn-backk" href="index.php?page=home">← Về trang chủ</a>

    </div>
  </div>

</body>
</html>
