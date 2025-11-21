<?php
include_once 'function.php';
$admin = new admin();

$msg = '';
$idSP = isset($_GET['idSP']) ? intval($_GET['idSP']) : 0;
$sp = $admin->LaySanPhamTheoID($idSP);
if (!$sp) {
    echo "<p>Sản phẩm không tồn tại.</p>";
    exit;
}
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $ten = trim($_POST['tenSP']);
    $gia = floatval($_POST['gia']);
    $soLuong = intval($_POST['soLuong']);
    $moTa = trim($_POST['moTa']);
    $idHang = intval($_POST['tenHang']);
    $hinh = $sp['hinhAnh']; 
    if (!$admin->KiemTraHangSanXuatTonTai($idHang)) {
        $msg = "Lỗi: ID hãng sản xuất không tồn tại.";
    } else {
        if (isset($_FILES['hinhAnh']) && $_FILES['hinhAnh']['error'] === 0) {
            $newHinh = $_FILES['hinhAnh']['name'];
            $tmp = $_FILES['hinhAnh']['tmp_name'];
            $uploadDir = "HINH/";

            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            if (move_uploaded_file($tmp, $uploadDir . $newHinh)) {
                if (file_exists($uploadDir . $sp['hinhAnh'])) unlink($uploadDir . $sp['hinhAnh']);
                $hinh = $newHinh;
            } else {
                $msg = "Lỗi: Không thể lưu file hình ảnh mới.";
            }
        }
        if ($hinh) {
            $res = $admin->CapNhatDienThoai($ten, $gia, $hinh, $soLuong, $moTa, $idHang, $idSP);
            $msg = $res === true ? "Cập nhật sản phẩm thành công." : "Lỗi: $res";
            $sp = $admin->LaySanPhamTheoID($idSP);
        }
    }
}
?>
<div class="form-container">
  <h2>Sửa sản phẩm</h2>
  <?php if ($msg) echo "<p class='msg'>$msg</p>"; ?>
  
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="edit">

    <label>Tên sản phẩm:</label>
    <input type="text" name="tenSP" value="<?= htmlspecialchars($sp['tenSP']) ?>" required>

    <label>Giá:</label>
    <input type="number" name="gia" value="<?= $sp['gia'] ?>" required>

    <label>Số lượng:</label>
    <input type="number" name="soLuong" value="<?= $sp['soLuong'] ?>" required>

    <label>Hình ảnh hiện tại:</label>
    <div>
        <img src="HINH/<?= $sp['hinhAnh'] ?>" alt="<?= htmlspecialchars($sp['tenSP']) ?>" style="max-width:150px;">
    </div>

    <label>Hình ảnh mới:</label>
    <input type="file" name="hinhAnh" accept="image/*">

    <label>Mô tả:</label>
    <textarea name="moTa" rows="4"><?= htmlspecialchars($sp['moTa']) ?></textarea>

    <label>Hãng sản xuất:</label>
    <select name="tenHang" required>
      <?php
      $dsHang = $admin->ListHangSanXuat();
      foreach ($dsHang as $h) {
          $selected = $h['idHang'] == $sp['idHang'] ? 'selected' : '';
          echo "<option value='{$h['idHang']}' $selected>{$h['tenHang']}</option>";
      }
      ?>
    </select>
    <button type="submit">Cập nhật</button>
  </form>
  <a href="admin.php?page=dienthoai" class="btn-back">← Quay lại</a>
</div>
