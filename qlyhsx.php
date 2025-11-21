<?php
include_once 'function.php';
$admin = new admin();
$msg = '';

if (isset($_GET['delete_id'])) {
    $idHang = intval($_GET['delete_id']);
    if ($admin->KiemTraHangSanXuatTonTai($idHang)) {
        $res = $admin->XoaHangSX($idHang);
        $msg = $res === true ? "<span style='color:green'>Đã xóa hãng ID: $idHang</span>" : "<span style='color:red'>Lỗi khi xóa hãng: $res</span>";
    } else {
        $msg = "<span style='color:red'>Hãng sản xuất không tồn tại.</span>";
    }
}

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$list = $admin->ListHangSanXuat($keyword);
?>
<div class="content">
    <h1>Quản lý Hãng Sản Xuất</h1>
    <?php if ($msg) echo "<p>$msg</p>"; ?>

    <form method="get" action="admin.php" class="search-form">
        <input type="hidden" name="page" value="hangsx">
        <input type="text" name="keyword" placeholder="Tìm kiếm hãng..." value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit">Tìm kiếm</button>
    </form>

    <a href="admin.php?page=themhsx" class="btn-add">+ Thêm hãng mới</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Tên hãng</th>
            <th>Thao tác</th>
        </tr>
        <?php if (!empty($list)): ?>
            <?php foreach ($list as $item): ?>
                <tr>
                    <td><?= $item['idHang'] ?></td>
                    <td><?= htmlspecialchars($item['tenHang']) ?></td>
                    <td>
                        <a href="admin.php?page=suahsx&idHang=<?= $item['idHang'] ?>" class="btn-edit">Sửa</a>
                        <a href="admin.php?page=hangsx&delete_id=<?= $item['idHang'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa hãng này?');" class="btn-delete">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3">Không có dữ liệu.</td></tr>
        <?php endif; ?>
    </table>
</div>
