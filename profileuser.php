<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
include_once 'config.php';
$db = new dienthoai();

$user = $db->LayThongTinKH($_SESSION['email']);
if (!$user || !isset($user['idUser'])) {
  echo "<p style='color:red;text-align:center;'>Không tìm thấy thông tin người dùng.</p>";
  exit();
}

$msg = "";
if (isset($_POST['update_profile'])) {
  $idUser   = $user['idUser'];
  $fullname = trim($_POST['hoTen'] ?? '');
  $diachi   = trim($_POST['diaChi'] ?? '');
  $phone    = trim($_POST['soDienThoai'] ?? '');
  $password = trim($_POST['password'] ?? '');
  $confirm  = trim($_POST['confirm'] ?? '');

  if ($password !== $confirm) {
    $msg = "<p style='color:red; text-align:center; margin-top:15px;'>Mật khẩu xác nhận không khớp!</p>";
  } else {
    $hashed = !empty($password) ? md5($password) : "";
    $msg = "<p style='color:green; text-align:center; margin-top:10px;'>" .
      htmlspecialchars($db->CapNhatThongTinKH($idUser, $fullname, $diachi, $phone, $hashed)) .
      "</p>";
  }
}
?>

<div class="profile-container">
  <div class="profile-card">
    <div class="profile-header">
      <h3>Thông tin cá nhân</h3>
      <button type="submit" form="profileForm" class="save-btn">Lưu thay đổi</button>
    </div>

    <form id="profileForm" method="post" class="profile-form">
      <div class="profile-grid">
        <div class="form1-group">
          <label for="hoTen">Họ và tên</label>
          <input type="text" name="hoTen" placeholder="Nhập họ và tên" value="<?= htmlspecialchars($user['hoTen'] ?? '') ?>">
        </div>
        <div class="form1-group">
          <label for="soDienThoai">Số điện thoại</label>
          <input type="tel" name="soDienThoai" placeholder="Nhập số điện thoại" value="<?= htmlspecialchars($user['soDienThoai'] ?? '') ?>">
        </div>
        <div class="form1-group">
          <label>Email</label>
          <input type="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" readonly>
        </div>
        <div class="form1-group">
          <label for="diaChi">Địa chỉ</label>
          <input type="text" name="diaChi" placeholder="Nhập địa chỉ" value="<?= htmlspecialchars($user['diaChi'] ?? '') ?>">
        </div>
        <div class="form1-group">
          <label for="password">Mật khẩu mới</label>
          <input type="password" id="password" name="password" placeholder="Đổi mật khẩu">
        </div>
        <div class="form1-group">
          <label for="confirm">Xác nhận mật khẩu mới</label>
          <input type="password" id="confirm" name="confirm" placeholder="Nhập lại mật khẩu mới">
        </div>
      </div>
      <input type="hidden" name="update_profile" value="1">
    </form>
    <?= $msg ?>
  </div>
</div>
