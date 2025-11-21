<?php
include_once 'function.php';
$admin = new admin();

$msg = '';
$hangSX = null;

if (isset($_GET['idHang'])) {
    $id = intval($_GET['idHang']);
    $hangSX = $admin->LayHangSanXuatTheoId($id);
    if (!$hangSX) {
        $msg = "Không tìm thấy hãng sản xuất.";
    }
}

if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = intval($_POST['idHang']);
    $ten = trim($_POST['tenHang']);

    if ($ten === '') {
        $msg = "Vui lòng nhập tên hãng sản xuất.";
    } else {
        $res = $admin->CapNhatHangSX($id, $ten);
        $msg = $res === true ? "Cập nhật thành công." : "Lỗi: $res";
        if ($res === true) {
            $hangSX['tenHang'] = $ten;
        }
    }
}
?>
<div class="form-container">
    <h2>Sửa Hãng Sản Xuất</h2>
    <?php if ($msg) echo "<p class='msg'>$msg</p>"; ?>
    
    <?php if ($hangSX): ?>
        <form method="post">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="idHang" value="<?php echo $hangSX['idHang']; ?>">
            
            <label>Tên hãng sản xuất:</label>
            <input type="text" name="tenHang" value="<?php echo htmlspecialchars($hangSX['tenHang']); ?>" placeholder="Nhập tên hãng..." required>
            
            <button type="submit">Cập nhật</button>
        </form>
    <?php else: ?>
        <p>Không tìm thấy hãng sản xuất để sửa.</p>
    <?php endif; ?>
    <a href="admin.php?page=hangsx" class="btn-back">← Quay lại</a>
</div>