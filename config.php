<?php
class dienthoai {
    public $host = "localhost";
    public $user = "root";
    public $pass = "";
    public $dbname = "webdienthoai";
    private $db;

    public function __construct() {
        $this->db = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        $this->db->set_charset("utf8");
    }

    function Register($hoten, $email, $sodienthoai, $password) {
        $emailEsc = $this->db->real_escape_string($email);
        $check = $this->db->query("SELECT * FROM USER WHERE email='$emailEsc'");
        if ($check && $check->num_rows > 0) {
            return "Email đã tồn tại!";
        }
        $hotenEsc = $this->db->real_escape_string($hoten);
        $soDT_Esc = $this->db->real_escape_string($sodienthoai);
        $passEsc = md5($password);
        $sql = "INSERT INTO USER (hoTen, email, soDienThoai, password) 
                VALUES ('$hotenEsc', '$emailEsc', '$soDT_Esc', '$passEsc')";
        if ($this->db->query($sql)) {
            return "Đăng ký thành công!";
        } else {
            return "Lỗi đăng ký: " . $this->db->error;
        }
    }

    function Login($email, $password_plain) {
        if (!isset($_SESSION));

        $emailEsc = $this->db->real_escape_string($email);
        $passEsc = md5($password_plain); 
        $sql = "SELECT * FROM USER WHERE email='$emailEsc' AND password='$passEsc' LIMIT 1";
        $result = $this->db->query($sql);
        if ($result && $result->num_rows > 0) {
            return "Đăng nhập thành công!";
        }
            return "Sai email hoặc mật khẩu!";
    }

    function LayThongTinKH($email) {
        $emailEsc = $this->db->real_escape_string($email);
        $sql = "SELECT * FROM USER WHERE email='$emailEsc'";
        $result = $this->db->query($sql);
        if ($result && $result->num_rows > 0) return $result->fetch_assoc();
            return null;
    }

    function CapNhatThongTinKH($idUser, $hoten, $diachi, $sodienThoai, $password) {
        if (empty($idUser)) return "ID người dùng không hợp lệ.";
        $idUserEsc = $this->db->real_escape_string($idUser);
        $res = $this->db->query("SELECT hoTen, diaChi, soDienThoai, password FROM USER WHERE idUser = '$idUserEsc'");
        if (!$res || $res->num_rows === 0) 
            return "Người dùng không tồn tại.";
        $row = $res->fetch_assoc();
        if (empty($hoten)) $hoten = $row['hoTen'];
        if (empty($diachi)) $diachi = $row['diaChi'];
        if (empty($sodienThoai)) $sodienThoai = $row['soDienThoai'];
        if (empty($password)) $password = $row['password'];
        if (!$this->KiemTraHopLe($password)) return "Mật khẩu chứa ký tự không hợp lệ!";
        $hotenEsc = $this->db->real_escape_string($hoten);
        $diachiEsc = $this->db->real_escape_string($diachi);
        $soDT_Esc = $this->db->real_escape_string($sodienThoai);
        $passEsc = $this->db->real_escape_string($password);
        $sql = "UPDATE USER SET hoTen = '$hotenEsc', diaChi = '$diachiEsc', soDienThoai = '$soDT_Esc', password = '$passEsc' WHERE idUser = '$idUserEsc'";
        if ($this->db->query($sql)) return "Cập nhật thông tin thành công!";
            return "Lỗi khi cập nhật: " . $this->db->error;
    }

    function ListHangSanXuat() {
        $sql = "SELECT idHang, tenHang FROM HANGSANXUAT";
        return $this->db->query($sql);
    }

    function LayTatCaDienThoai() {
        $sql = "SELECT sp.idSP, sp.tenSP, sp.gia, sp.hinhAnh, hsx.tenHang FROM SANPHAM sp LEFT JOIN HANGSANXUAT hsx ON sp.idHang = hsx.idHang ORDER BY sp.idSP DESC";
        $recordset = $this->db->query($sql);
        $sanpham = [];
        if ($recordset && $recordset->num_rows > 0) {
        while ($row = $recordset->fetch_assoc()) {
            $sanpham[] = $row;
        }
        }
            return $sanpham;
    }
    function HienThiSanPhamTheoHang($idHang) {
        $idHang = intval($idHang);
        $sql = "SELECT s.idSP, s.tenSP, s.gia, s.hinhAnh, s.soLuong, s.moTa, s.idHang, h.tenHang FROM SANPHAM s LEFT JOIN HANGSANXUAT h ON s.idHang = h.idHang WHERE s.idHang = $idHang";
        $recordset = $this->db->query($sql);
        $sanpham = [];
        if ($recordset && $recordset->num_rows > 0) {
        while ($row = $recordset->fetch_assoc()) {
            $sanpham[] = $row;
        }
        }
            return $sanpham;
    }

    function DemSoSanPhamTheoHang($idHang) {
        $sql = "SELECT COUNT(*) AS tong FROM SANPHAM WHERE idHang = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idHang);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result['tong'];
    }

    function TimKiemSanPham($keyword) {
        $kw = "%" . $keyword . "%";
        $sql = "SELECT sp.*, hsx.tenHang FROM SANPHAM sp JOIN HANGSANXUAT hsx ON sp.idHang = hsx.idHang 
            WHERE sp.tenSP LIKE ? 
            OR sp.moTa LIKE ? 
            OR hsx.tenHang LIKE ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $kw, $kw, $kw);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
        $data[] = $row;
        }
        $stmt->close();
        return $data;
    }

    function KiemTraDangNhap() {
        if (!isset($_SESSION)) session_start();
            return isset($_SESSION['email']);
    }

    function LayChiTietSanPham($idSP) {
        $idSP = intval($idSP);
        $sql = "SELECT s.idSP, s.tenSP, s.gia, s.hinhAnh, s.moTa, s.soLuong, h.tenHang, h.idHang 
                FROM SANPHAM s LEFT JOIN HANGSANXUAT h ON s.idHang = h.idHang WHERE s.idSP = $idSP";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }

    function ThemVaoGioHang($idSP, $tenSP = null, $gia = null, $hinhAnh = null) {
        if (!isset($_SESSION)) session_start();
        $idSP = intval($idSP);
        if (empty($_SESSION['email'])) {
            if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
            foreach ($_SESSION['cart'] as &$cartItem) {
                if ($cartItem['idSP'] == $idSP) { $cartItem['soLuong'] += 1; $_SESSION['cart'] = array_values($_SESSION['cart']); return; }
            }
            $_SESSION['cart'][] = ['idSP'=>$idSP,'tenSP'=>$tenSP,'gia'=>$gia,'hinhAnh'=>$hinhAnh,'soLuong'=>1];
            return;
        }
        $email = $this->db->real_escape_string($_SESSION['email']);
        $resUser = $this->db->query("SELECT idUser FROM USER WHERE email = '$email' LIMIT 1");
        if (!$resUser || $resUser->num_rows === 0) return;
        $idUser = intval($resUser->fetch_assoc()['idUser']);
        $check = $this->db->query("SELECT soLuong FROM giohang WHERE idUser = $idUser AND idSP = $idSP");
        if ($check && $check->num_rows > 0) {
            $r = $check->fetch_assoc();
            $newQty = intval($r['soLuong']) + 1;
            $this->db->query("UPDATE giohang SET soLuong = $newQty WHERE idUser = $idUser AND idSP = $idSP");
        } else {
            $this->db->query("INSERT INTO giohang (idUser, idSP, soLuong) VALUES ($idUser, $idSP, 1)");
        }
    }

    function LayGioHang(): mixed {
        if (!isset($_SESSION)) session_start();
        if (!empty($_SESSION['email'])) {
            $email = $this->db->real_escape_string($_SESSION['email']);
            $resUser = $this->db->query("SELECT idUser FROM USER WHERE email = '$email' LIMIT 1");
            if ($resUser && $resUser->num_rows > 0) {
                $idUser = intval($resUser->fetch_assoc()['idUser']);
                $sql = "SELECT gh.idSP, gh.soLuong, sp.tenSP, sp.gia, sp.hinhAnh FROM giohang gh JOIN SANPHAM sp ON gh.idSP = sp.idSP WHERE gh.idUser = $idUser";
                $rs = $this->db->query($sql);
                $cart = [];
                if ($rs && $rs->num_rows > 0) while ($row = $rs->fetch_assoc()) $cart[] = $row;
                    return $cart;
            }
        }
        return $_SESSION['cart'] ?? [];
    }

    function XoaKhoiGioHang($idSP) {
        if (!isset($_SESSION)) session_start();
        $idSP = intval($idSP);
        if (!empty($_SESSION['email'])) {
            $email = $this->db->real_escape_string($_SESSION['email']);
            $resUser = $this->db->query("SELECT idUser FROM USER WHERE email = '$email' LIMIT 1");
            if ($resUser && $resUser->num_rows > 0) { $idUser = intval($resUser->fetch_assoc()['idUser']); $this->db->query("DELETE FROM giohang WHERE idUser = $idUser AND idSP = $idSP"); return; }
        }
        if (!isset($_SESSION['cart'])) return; foreach ($_SESSION['cart'] as $index => $item) { if ($item['idSP'] == $idSP) { unset($_SESSION['cart'][$index]); $_SESSION['cart'] = array_values($_SESSION['cart']); return; } }
    }

    function TinhTongTienGioHang() {
        if (!isset($_SESSION)) session_start();
        if (!empty($_SESSION['email'])) {
            $email = $this->db->real_escape_string($_SESSION['email']);
            $resUser = $this->db->query("SELECT idUser FROM USER WHERE email = '$email' LIMIT 1");
            if ($resUser && $resUser->num_rows > 0) {
                $idUser = intval($resUser->fetch_assoc()['idUser']);
                $sql = "SELECT SUM(sp.gia * gh.soLuong) AS tong FROM giohang gh JOIN SANPHAM sp ON gh.idSP = sp.idSP WHERE gh.idUser = $idUser";
                $res = $this->db->query($sql);
                $row = $res ? $res->fetch_assoc() : null;
                return $row ? intval($row['tong']) : 0;
            }
        }
        $total = 0; if (!isset($_SESSION['cart'])) return 0; foreach ($_SESSION['cart'] as $item) $total += $item['gia'] * $item['soLuong']; return $total;
    }

    function KiemTraSoLuongGioHang() {
        $gioHang = $this->LayGioHang();
        if (empty($gioHang)) {
            return true; 
        }
        $loi = [];
        foreach ($gioHang as $item) {
            $idSP = intval($item['idSP']);
            $soLuongMua = intval($item['soLuong']);
            $sqlTonKho = "SELECT soLuong FROM sanpham WHERE idSP = $idSP";
            $resTon = $this->db->query($sqlTonKho);
            if (!$resTon || $resTon->num_rows === 0) {
                $loi[] = ['idSP' => $idSP, 'tenSP' => $item['tenSP'], 'tonKho' => 0, 'mua' => $soLuongMua, 'loi' => 'Sản phẩm không tồn tại'];
                continue;
            }
            $tonKho = intval($resTon->fetch_assoc()['soLuong']);
            if ($soLuongMua > $tonKho) {
                $loi[] = ['idSP' => $idSP, 'tenSP' => $item['tenSP'], 'tonKho' => $tonKho, 'mua' => $soLuongMua, 'loi' => 'Không đủ hàng'];
            }
        }
        return empty($loi) ? true : $loi;
    }
    function DemSoLuongGioHang() {
        if (!isset($_SESSION)) session_start();
        if (!empty($_SESSION['email'])) {
            $email = $this->db->real_escape_string($_SESSION['email']);
            $resUser = $this->db->query("SELECT idUser FROM USER WHERE email = '$email' LIMIT 1");
            if ($resUser && $resUser->num_rows > 0) { $idUser = intval($resUser->fetch_assoc()['idUser']); $res = $this->db->query("SELECT COUNT(*) AS sl FROM giohang WHERE idUser = $idUser"); $row = $res ? $res->fetch_assoc() : ['sl'=>0]; return intval($row['sl']); }
        }
        if (!isset($_SESSION['cart'])) 
            return 0; 
            return count($_SESSION['cart']);
    }

    function ClearGioHang() {
        if (!isset($_SESSION)) session_start();
        if (!empty($_SESSION['email'])) {
            $email = $this->db->real_escape_string($_SESSION['email']); 
            $resUser = $this->db->query("SELECT idUser FROM USER WHERE email = '$email' LIMIT 1"); 
            if ($resUser && $resUser->num_rows > 0) { 
                $idUser = intval($resUser->fetch_assoc()['idUser']); 
                $this->db->query("DELETE FROM giohang WHERE idUser = $idUser"); 
                return; } }
        unset($_SESSION['cart']);
    }

    function LayHangSanXuatTheoID($idHang) {
        $idHang = intval($idHang);
        $sql = "SELECT idHang, tenHang FROM HANGSANXUAT WHERE idHang = $idHang";
        $recordset = $this->db->query($sql);
        if ($recordset && $recordset->num_rows > 0) return $recordset->fetch_assoc();
            return null;
    }

    // Cập nhật số lượng trong giỏ hàng
    function CapNhatSoLuong($idSP, $change) {
        if (!isset($_SESSION)) session_start();
        $idSP = intval($idSP); $change = intval($change);
        if (!empty($_SESSION['email'])) {
            $email = $this->db->real_escape_string($_SESSION['email']);
            $resUser = $this->db->query("SELECT idUser FROM USER WHERE email = '$email' LIMIT 1");
            if ($resUser && $resUser->num_rows > 0) {
                $idUser = intval($resUser->fetch_assoc()['idUser']);
                $res = $this->db->query("SELECT soLuong FROM giohang WHERE idUser = $idUser AND idSP = $idSP");
                if ($res && $res->num_rows > 0) {
                    $row = $res->fetch_assoc();
                    $newQty = intval($row['soLuong']) + $change;
                    if ($newQty > 0) $this->db->query("UPDATE giohang SET soLuong = $newQty 
                    WHERE idUser = $idUser AND idSP = $idSP"); 
                    else $this->db->query("DELETE FROM giohang WHERE idUser = $idUser AND idSP = $idSP");
                }
            }
            return;
        }
        if (!isset($_SESSION['cart'])) return;
        foreach ($_SESSION['cart'] as $index => &$item) {
            if ($item['idSP'] == $idSP) {
                $item['soLuong'] += $change;
                if ($item['soLuong'] <= 0) { unset($_SESSION['cart'][$index]); 
                    $_SESSION['cart'] = array_values($_SESSION['cart']); }
                return;
            }
        }
    }
    
    function LayDonHangUser($idUser, $status = null) {
        $idUser = intval($idUser);
        $orders = [];
        $sql = "SELECT * FROM donhang WHERE idUser = $idUser";

        if (!empty($status) && $status !== 'Tất cả') {
            $statusEsc = $this->db->real_escape_string($status);
            $sql .= " AND trangThai = '$statusEsc'";
            }

        $sql .= " ORDER BY ngayDat DESC";
        $rs = $this->db->query($sql);

        if ($rs && $rs->num_rows > 0) {
            while ($row = $rs->fetch_assoc()) {
            $orders[] = $row;
            }
        }
        return $orders;
    }

    function LayTatCaDonHangUser($idUser, $status = null) {
        return $this->LayDonHangUser($idUser, $status);
    }

    function LayChiTietDonHang($idDH) {
        $idDH = intval($idDH);
        $items = [];
        $sql = "SELECT ctd.*, sp.tenSP, sp.hinhAnh FROM ctdonhang ctd JOIN sanpham sp ON ctd.idSP = sp.idSP WHERE ctd.idDH = $idDH";
        $rs = $this->db->query($sql);
        if ($rs && $rs->num_rows > 0) {
            while ($row = $rs->fetch_assoc()) $items[] = $row;
        }
        return $items;
    }

    function HuyDonHang($idDH, $idUser) {
        $idDH = intval($idDH);
        $idUser = intval($idUser);

        $this->db->begin_transaction();
        try {
            $check = $this->db->query("SELECT * FROM donhang WHERE idDH = $idDH AND idUser = $idUser AND trangThai = 'Chờ xác nhận'");
            if ($check && $check->num_rows > 0) {
                $ctdonhang = $this->db->query("SELECT idSP, soLuong FROM ctdonhang WHERE idDH = $idDH");
                while ($item = $ctdonhang->fetch_assoc()) {
                    $sql = "UPDATE sanpham SET soLuong = soLuong + {$item['soLuong']} WHERE idSP = {$item['idSP']}";
                    $this->db->query($sql);
                }

                $this->db->query("UPDATE donhang SET trangThai = 'Đã hủy' WHERE idDH = $idDH");

                $this->db->commit();
                return true;
            }
            return false;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    function TaoDonHang($idUser, $diaChi, $ghiChu, $tongTien, $pttt) {
        $idUser = intval($idUser);
        $diaChiEsc = $this->db->real_escape_string($diaChi);
        $ghiChuEsc = $this->db->real_escape_string($ghiChu);
        $tongTien = floatval($tongTien);
        $ptttEsc = $this->db->real_escape_string($pttt);
        
        $sql = "INSERT INTO donhang (idUser, diaChiNhanHang, ghiChu, ngayDat, tongTien, trangThai, pttt) 
                VALUES ($idUser, '$diaChiEsc', '$ghiChuEsc', NOW(), $tongTien, 'Chờ xác nhận', '$ptttEsc')";
        if ($this->db->query($sql)) {
            return $this->db->insert_id;
        }
        return false;
    }

    function ThemChiTietDonHang($idDH, $idSP, $soLuong, $donGia) {
        $idDH = intval($idDH);
        $idSP = intval($idSP);
        $soLuong = intval($soLuong);
        $donGia = floatval($donGia);

        $sql = "INSERT INTO ctdonhang (idDH, idSP, soLuong, donGia) VALUES ($idDH, $idSP, $soLuong, $donGia)";
        return $this->db->query($sql);
    }

    function LayThongTinDonHang($idDH) {
        $idDH = intval($idDH);
        $sql = "SELECT dh.*, u.hoTen, u.soDienThoai, u.email 
                FROM donhang dh 
                JOIN USER u ON dh.idUser = u.idUser 
                WHERE dh.idDH = $idDH";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }

    function KiemTraQuyenTruyCapDonHang($idDH, $idUser) {
        $idDH = intval($idDH);
        $idUser = intval($idUser);
        $sql = "SELECT COUNT(*) as count FROM donhang WHERE idDH = $idDH AND idUser = $idUser";
        $result = $this->db->query($sql);
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }

    // Cập nhật số lượng sản phẩm trong DB sau khi đặt hàng
    function CapNhatSoLuongSP($idSP, $soLuong) {
        $idSP = intval($idSP);
        $soLuong = intval($soLuong);
        
        $sql = "SELECT soLuong FROM sanpham WHERE idSP = $idSP";
        $result = $this->db->query($sql);
        if (!$result || $result->num_rows === 0) return false;
        
        $current = $result->fetch_assoc()['soLuong'];
        $newQty = $current - $soLuong;
        
        if ($newQty < 0) return false;
        
        $sql = "UPDATE sanpham SET soLuong = $newQty WHERE idSP = $idSP";
        return $this->db->query($sql);
    }

    function XoaGioHangSauKhiThanhToan($idUser) {
        $idUser = intval($idUser);
        $sql = "DELETE FROM giohang WHERE idUser = $idUser";
        return $this->db->query($sql);
    }
    function LayDanhGiaTheoSanPham($idSP) {
        $sql = "SELECT * FROM danhgia WHERE idSP = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idSP);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function ThemDanhGia($idUser, $idDG, $idSP, $soSao, $binhLuan) {
        $idUser = intval($idUser);
        $idDG = intval($idDG);
        $idSP = intval($idSP);
        $soSao = intval($soSao);
        $binhLuan = $this->db->real_escape_string($binhLuan);
        $sql = "INSERT INTO danhgia (idUser, idDG, idSP, soSao, binhLuan) 
                VALUES ($idUser, $idDG, $idSP, $soSao, '$binhLuan')";
        return $this->db->query($sql);
    }

    function LuuDanhGia($idUser, $idSP, $soSao, $noiDung) {
        $idUser = intval($idUser);
        $idSP = intval($idSP);
        $soSao = intval($soSao);
        $noiDung = $this->db->real_escape_string($noiDung);

        // Kiểm tra đánh giá cũ
        $check = $this->db->query("SELECT * FROM danhgia WHERE idUser=$idUser AND idSP=$idSP");
        if ($check && $check->num_rows > 0) {
            $row = $check->fetch_assoc();
            $ngay = strtotime($row['ngayDanhGia']);
            // Còn trong 7 ngày thì update
            if (time() - $ngay <= 7 * 24 * 60 * 60) {
                $sql = "UPDATE danhgia 
                        SET soSao=$soSao, binhLuan='$noiDung', ngayDanhGia=NOW() 
                        WHERE idUser=$idUser AND idSP=$idSP";
                return $this->db->query($sql);
            } else {
                return false;
            }
        } else {
            $sql = "INSERT INTO danhgia (idUser, idSP, soSao, binhLuan, ngayDanhGia)
                    VALUES ($idUser, $idSP, $soSao, '$noiDung', NOW())";
            return $this->db->query($sql);
        }
    }
}
?>