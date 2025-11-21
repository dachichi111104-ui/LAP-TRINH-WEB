<?php
include_once 'function.php';
$admin = new admin();

$id = intval($_GET['id']);
$kh = $admin->LayKhachHangTheoID($id);
$msg = '';

if (!$kh) { echo "<p>Khách hàng không tồn tại.</p>"; exit; }

if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $ten = trim($_POST['hoTen']);
    $email = trim($_POST['email']);
    $sdt = trim($_POST['soDienThoai']);
    $diachi = trim($_POST['diaChi']);
    $res = $admin->CapNhatKhachHang($id, $ten, $email, $sdt, $diachi);
    $msg = $res === true ? "Cập nhật thành công." : "Lỗi: $res";
    $kh = $admin->LayKhachHangTheoID($id);
}
?>
<div class="form-container">
  <h2>Sửa thông tin khách hàng</h2>
  <?php if ($msg) echo "<p class='msg'>$msg</p>"; ?>
  
  <form method="post">
    <input type="hidden" name="action" value="edit">

    <label>Họ tên:</label>
    <input type="text" name="hoTen" value="<?= htmlspecialchars($kh['hoTen']) ?>">

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($kh['email']) ?>">

    <label>SĐT:</label>
    <input type="text" name="soDienThoai" value="<?= htmlspecialchars($kh['soDienThoai']) ?>">

    <label>Địa chỉ:</label>
    <input type="text" name="diaChi" value="<?= htmlspecialchars($kh['diaChi']) ?>">

    <button type="submit">Cập nhật</button>
  </form>

  <a href="admin.php?page=khachhang" class="btn-back">← Quay lại</a>
</div>
