<?php
require_once 'function.php';
$admin = new admin();
$msg = '';
if (isset($_POST['emailadmin']) && isset($_POST['passwordadmin'])) {
    $Email = $_POST['emailadmin'];
    $MatKhau = $_POST['passwordadmin'];
    $result = $admin->LoginAdmin($Email, $MatKhau);
    if ($result === "Đăng nhập thành công!") {
        header('Location: admin.php');
        exit();
    } else {
        $msg = $result;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Đăng nhập Admin</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">
  <div class="login-box">
    <h2>Đăng nhập quản trị</h2>
    <?php if ($msg): ?><p style="color:red; text-align:center;">
      <?php echo htmlspecialchars($msg); ?></p><?php endif; ?>
    <form method="post" action="">
      <div class="form-group">
        <label for="emailadmin">Tài khoản</label>
        <input type="email" id="emailadmin" name="emailadmin" required>
      </div>
      <div class="form-group">
        <label for="passwordadmin">Mật khẩu</label>
        <input type="password" id="passwordadmin" name="passwordadmin" required>
      </div>
      <button class="btn-login" type="submit">Đăng nhập</button>
    </form>
  </div>
</body>
</html>