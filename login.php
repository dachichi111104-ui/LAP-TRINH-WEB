<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ob_start();
include("config.php");
$db = new dienthoai();

if (!isset($_SESSION['email']) && isset($_COOKIE['email'])) {
  $_SESSION['email'] = $_COOKIE['email'];
  if (isset($_COOKIE['hoTen'])) $_SESSION['hoTen'] = $_COOKIE['hoTen'];
  if (isset($_COOKIE['idUser'])) $_SESSION['idUser'] = $_COOKIE['idUser'];
  $expire = time() + 60*60*24*7;
  setcookie('email', $_SESSION['email'], $expire, '/');
  if (!empty($_SESSION['hoTen'])) setcookie('hoTen', $_SESSION['hoTen'], $expire, '/');
  if (!empty($_SESSION['idUser'])) setcookie('idUser', $_SESSION['idUser'], $expire, '/');
}

$msg = "";
if (isset($_SESSION['email'])) {
  header('Location: index.php?page=home');
  exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập</title>
  <link rel="stylesheet" href="style.css"> 
</head>
<body class="login-page">
<div class="login-box">
  <h2>Đăng nhập hệ thống</h2>
<form method="post" action="process.php?action=login">
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" required value="<?php echo isset($_COOKIE['email']) ? htmlspecialchars(trim($_COOKIE['email'])) : '';?>" autocomplete="email">
    </div>
    <div class="form-group">
      <label for="password">Mật khẩu</label>
      <input type="password" name="password" id="password" required>
    </div>
    <div class="form-group">
      <label for="remember"><input type="checkbox" name="remember" id="remember" value="1"> Ghi nhớ đăng nhập</label>
    </div>
    <button type="submit" class="btn-login">Đăng nhập</button>
  </form>
  <div class="note">
    Chưa có tài khoản? <a href="register.php" style="color:#0a74da; text-decoration:none;">Đăng ký</a></br>
      <?php 
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
      ?>
      <a class="btn-backk" href="index.php?page=home">← Về trang chủ</a>
  </div>
</div>

</body>
</html>
