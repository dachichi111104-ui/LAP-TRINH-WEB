<?php
include_once 'function.php';
$admin = new admin();

$msg = '';
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $ten = trim($_POST['tenSP']);
    $gia = floatval($_POST['gia']);
    $soLuong = intval($_POST['soLuong']);
    $moTa = trim($_POST['moTa']);
    $idHang = intval($_POST['tenHang']); 
    if (!$admin->KiemTraHangSanXuatTonTai($idHang)) {
        $msg = "Lỗi: ID hãng sản xuất không tồn tại trong cơ sở dữ liệu.";
    } else {
        if (isset($_FILES['hinhAnh']) && $_FILES['hinhAnh']['error'] === 0) {
            $hinh = $_FILES['hinhAnh']['name'];
            $tmp = $_FILES['hinhAnh']['tmp_name'];
            $uploadDir = "HINH/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            if (!move_uploaded_file($tmp, $uploadDir . $hinh)) {
                $msg = "Lỗi: Không thể lưu file hình ảnh.";
                $hinh = null;
            }
        } else {
            $msg = "Lỗi: Bạn chưa chọn file hình ảnh.";
            $hinh = null;
        }
        if ($hinh) {
            $res = $admin->ThemDienThoai($ten, $gia, $hinh, $soLuong, $moTa, $idHang);
            $msg = $res === true ? "Thêm sản phẩm thành công." : "Lỗi: $res";
        }
    }
}
?>
<div class="form-container">
  <h2>Thêm sản phẩm mới</h2>
  <?php if ($msg) echo "<p class='msg'>$msg</p>"; ?>

  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="add">
    
    <label>Tên sản phẩm:</label>
    <input type="text" name="tenSP" required>
    
    <label>Giá:</label>
    <input type="number" name="gia" required>
    
    <label>Số lượng:</label>
    <input type="number" name="soLuong" required>
    
    <label>Hình ảnh:</label>
    <input type="file" name="hinhAnh" accept="image/*" required>
    
    <label>Mô tả:</label>
    <textarea name="moTa" rows="4" placeholder="Nhập mô tả sản phẩm..."></textarea>
    
    <label>Hãng sản xuất:</label>
    <select name="tenHang" required>
      <?php
      $dsHang = $admin->ListHangSanXuat();
      foreach ($dsHang as $h) {
          echo "<option value='{$h['idHang']}'>{$h['tenHang']}</option>";
      }
      ?>
    </select>
    <button type="submit">Thêm</button>
  </form>
  <a href="admin.php?page=dienthoai" class="btn-back">← Quay lại</a>
</div>
