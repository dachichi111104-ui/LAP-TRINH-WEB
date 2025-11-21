<?php
include_once 'function.php';
$admin = new admin();

$msg = '';
$idDH = isset($_GET['idDH']) ? intval($_GET['idDH']) : 0;
$dh = $admin->LayDonHangTheoID($idDH);
if (!$dh) {
    echo "<p>Đơn hàng không tồn tại.</p>";
    exit;
}
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $trangThai = trim($_POST['trangThai']);
    $res = $admin->CapNhatDonHang($idDH, $trangThai);
    $msg = $res === true ? "Cập nhật trạng thái thành công." : "Lỗi: $res";
    $dh = $admin->LayDonHangTheoID($idDH);
}
?>
<div class="form-container">
  <h2>Cập nhật trạng thái đơn hàng #<?= $dh['idDH'] ?></h2>
  <?php if ($msg) echo "<p class='msg'>$msg</p>"; ?>
  <form method="post">
    <input type="hidden" name="action" value="edit">
    <label>Trạng thái:</label>
    <select name="trangThai" required>
        <option value="Chờ xác nhận" <?= $dh['trangThai']=="Chờ xác nhận"?'selected':'' ?>>Chờ xác nhận</option>
        <option value="Đang giao" <?= $dh['trangThai']=="Đang giao"?'selected':'' ?>>Đang giao</option>
        <option value="Hoàn thành" <?= $dh['trangThai']=="Hoàn thành"?'selected':'' ?>>Hoàn thành</option>
        <option value="Đã hủy" <?= $dh['trangThai']=="Đã hủy"?'selected':'' ?>>Đã hủy</option>
    </select>
    <button type="submit">Cập nhật</button>
  </form>
  <a href="admin.php?page=donhang" class="btn-back">← Quay lại</a>
</div>
