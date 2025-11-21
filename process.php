<?php
session_start();
include_once 'config.php';
$db = new dienthoai();

$action = $_REQUEST['action'] ?? null;

// REGISTER
if ($action === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $hoten = trim($_POST['hoTen'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['confirm'] ?? '');
    $soDienThoai = trim($_POST['soDienThoai'] ?? '');

    if ($password === '' || $email === '') {
        $_SESSION['msg'] = 'Vui lòng nhập đầy đủ thông tin.';
        header("Location: register.php"); exit;
    }
    if ($password !== $confirm) {
        $_SESSION['msg'] = 'Mật khẩu xác nhận không khớp.';
        header("Location: register.php"); exit;
    }

    $result = $db->Register($hoten, $email, $soDienThoai, $password);
    if ($result === "Đăng ký thành công!") {
        $_SESSION['msg'] = "Đăng ký thành công. Vui lòng đăng nhập.";
        header("Location: login.php"); exit;
    } else {
        $_SESSION['msg'] = $result;
        header("Location: register.php"); exit;
    }
}

// LOGIN  
if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $Email = trim($_POST['email'] ?? '');
    $PasswordRaw = trim($_POST['password'] ?? '');
    $result = $db->Login($Email, $PasswordRaw);
    if ($result === "Đăng nhập thành công!") {
        $_SESSION['email'] = $Email;
        $user = $db->LayThongTinKH($Email);
        if ($user) {
            $_SESSION['hoTen'] = $user['hoTen'];
            $_SESSION['idUser'] = $user['idUser'];
        }

        if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $db->ThemVaoGioHang(
            $item['idSP'],
            $item['tenSP'],
            $item['gia'],
            $item['hinhAnh'],
            $item['soLuong']
        );
    }
    unset($_SESSION['cart']);
}
        if (!empty($_POST['remember'])) {
            setcookie('email', $Email, time()+60*60*24*7, '/');
        }
        header("Location: index.php?page=home"); exit;
    } else {
        $_SESSION['msg'] = $result;
        header("Location: login.php"); exit;
    }
}

// LOGOUT  
if ($action === 'logout') {
    session_unset();
    session_destroy();
    header("Location: index.php?page=home"); exit;
}

// ADD TO CART  
if ($action === 'add_to_cart' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $idSP = intval($_POST['idSP'] ?? 0);

    if ($idSP > 0) {
        $product = $db->LayChiTietSanPham($idSP);
        if ($product) {
            $db->ThemVaoGioHang(
                $product['idSP'], 
                $product['tenSP'], 
                $product['gia'], 
                $product['hinhAnh'], 
                1
            );
        }
    }

    header("Location: index.php?page=home");
    exit;
}

// REMOVE ITEM  
if ($action === 'remove_from_cart' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $idSP = intval($_POST['idSP'] ?? 0);
    if ($idSP) $db->XoaKhoiGioHang($idSP);

    header("Location: index.php?page=cart"); exit;
}

// CLEAR CART  
if ($action === 'clear_cart') {
    $db->ClearGioHang();
    header("Location: index.php?page=cart"); exit;
}

// UPDATE CART  
if ($action === 'update_cart' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $idSP = intval($_POST['idSP'] ?? 0);
    $change = intval($_POST['change'] ?? 0);

    if ($idSP && $change !== 0) {
        $db->CapNhatSoLuong($idSP, $change);
    }

    header("Location: index.php?page=cart"); exit;
}

// CHECKOUT  
if ($action === 'checkout' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_SESSION['email'])) {
        $_SESSION['msg'] = "Bạn cần đăng nhập để đặt hàng.";
        header("Location: index.php?page=login"); exit;
    }
    $diachi = trim($_POST['diachi'] ?? '');
    $ghichu = trim($_POST['ghichu'] ?? '');
    $pttt = $_POST['pttt'] ?? 'cod';
    $tongTien = $db->TinhTongTienGioHang();
    $phiShip = ($tongTien >= 500000) ? 0 : 30000;
    $tongCong = $tongTien + $phiShip;
    $userRow = $db->LayThongTinKH($_SESSION['email']);
    $idUser = intval($userRow['idUser'] ?? 0);
    if ($idUser <= 0) {
        $_SESSION['msg'] = "Tài khoản không hợp lệ.";
        header("Location: index.php?page=login"); exit;
    }
    $idDH = $db->TaoDonHang($idUser, $diachi, $ghichu, $tongCong, $pttt);
    if ($idDH) {
        $cart_items = $db->LayGioHang();
        foreach ($cart_items as $item) {
            $db->ThemChiTietDonHang($idDH, $item['idSP'], $item['soLuong'], $item['gia']);
            $db->CapNhatSoLuongSP($item['idSP'], $item['soLuong']);
        }
        $db->ClearGioHang();
        $_SESSION['tongTien'] = $tongCong;
        $_SESSION['idDH'] = $idDH;
        header("Location: index.php?page=success"); exit;
    } else {
        $_SESSION['msg'] = "Tạo đơn hàng thất bại.";
        header("Location: index.php?page=checkout"); exit;
    }
}

// CANCEL ORDER  
if ($action === 'cancel_order' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_SESSION['email'])) {
        $_SESSION['msg'] = 'Vui lòng đăng nhập.';
        header("Location: index.php?page=login"); exit;
    }
    $idUser = $db->LayThongTinKH($_SESSION['email'])['idUser'] ?? 0;
    $idDH = intval($_POST['idDH'] ?? 0);
    if ($idUser && $idDH) {
        if ($db->HuyDonHang($idDH, $idUser)) {
            $_SESSION['msg'] = 'Hủy đơn thành công.';
        } else {
            $_SESSION['msg'] = 'Không thể hủy đơn.';
        }
        header("Location: index.php?page=users&tab=orders"); exit;
    }
    $_SESSION['msg'] = 'Dữ liệu không hợp lệ.';
    header("Location: index.php?page=users&tab=orders"); exit;
}

// SAVE REVIEW  
if ($action === 'save_review' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_SESSION['email'])) {
        $_SESSION['msg'] = 'Bạn cần đăng nhập.';
        header("Location: index.php?page=login"); exit;
    }
    $idUser = $db->LayThongTinKH($_SESSION['email'])['idUser'] ?? 0;
    $idSP = intval($_POST['idSP'] ?? 0);
    $idDH = intval($_POST['idDH'] ?? 0);
    $soSao = intval($_POST['soSao'] ?? 5);
    $noiDung = trim($_POST['noiDung'] ?? '');
    if ($idUser && $idSP && $idDH) {
        if ($db->LuuDanhGia($idUser, $idSP, $soSao, $noiDung)) {
            $_SESSION['msg'] = "Đánh giá thành công!";
        } else {
            $_SESSION['msg'] = "Không thể lưu đánh giá.";
        }
        header("Location: index.php?page=users&tab=review&idDH=$idDH");
        exit;
    }
    $_SESSION['msg'] = "Dữ liệu không hợp lệ.";
    header("Location: index.php?page=users&tab=review&idDH=$idDH");
    exit;
}

header("Location: index.php?page=home");
exit;
?>
