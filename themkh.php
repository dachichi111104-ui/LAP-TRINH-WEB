<?php
include_once 'function.php';
$admin = new admin();
$msg = '';

if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $ten = trim($_POST['hoTen']);
    $email = trim($_POST['email']);
    $pass = md5($_POST['password']);
    $sdt = trim($_POST['soDienThoai']);
    $diachi = trim($_POST['diaChi']);

    $res = $admin->ThemKhachHang($ten, $email, $pass, $sdt, $diachi);
    $msg = $res === true ? "Thêm khách hàng thành công." : "Lỗi: $res";
}
?>
<div class="form-container">
  <h2>Thêm khách hàng</h2>
  <?php if ($msg) echo "<p class='msg'>$msg</p>"; ?>
  
  <form method="post">
    <input type="hidden" name="action" value="add">
    <label>Họ tên:</label>
    <input type="text" name="hoTen" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Mật khẩu:</label>
    <input type="password" name="password" required>

    <label>SĐT:</label>
    <input type="text" name="soDienThoai">

    <label>Địa chỉ:</label>
    <input type="text" name="diaChi">

    <button type="submit">Thêm</button>
  </form>
  <a href="admin.php?page=khachhang" class="btn-back">← Quay lại</a>
</div>
