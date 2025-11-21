<?php
include_once 'function.php';
$admin = new admin();

$msg = '';
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $ten = trim($_POST['tenHang']);

 if ($ten === '') {
        $msg = "Vui lòng nhập tên hãng sản xuất.";
        $type = 'error';
    } else {
        $res = $admin->ThemHangSX($ten);

        if ($res === true) {
            $msg = "Thêm hãng sản xuất <b>$ten</b> thành công.";
            $type = 'success';
        } elseif (strpos($res, 'đã tồn tại') !== false) {
            $msg = "Hãng <b>$ten</b> đã tồn tại!";
            $type = 'error';
        } else {
            $msg = "Lỗi: $res";
            $type = 'error';
        }
    }
}
?>
<div class="form-container">
  <h2>Thêm Hãng Sản Xuất</h2>
  <?php if ($msg) echo "<p class='msg'>$msg</p>"; ?>
  
  <form method="post">
    <input type="hidden" name="action" value="add">
    
    <label>Tên hãng sản xuất:</label>
    <input type="text" name="tenHang" placeholder="Nhập tên hãng..." required>
    
    <button type="submit">Thêm</button>
  </form>
  <a href="admin.php?page=hangsx" class="btn-back">← Quay lại</a>
</div>
