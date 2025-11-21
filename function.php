<?php
class admin {
    public $host = "localhost";
    public $user = "root";
    public $pass = "";
    public $dbname = "webdienthoai";
    private $dbadmin;

    public function __construct() {
        $this->dbadmin = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        $this->dbadmin->set_charset("utf8");
    }

    function LoginAdmin($email, $password) {
        $sql = "SELECT * FROM ADMIN WHERE emailadmin='$email' 
                AND passwordadmin='$password'";
        $result = $this->dbadmin->query($sql);
        if ($result->num_rows > 0) {
            if (session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['emailadmin'] = $email;
            return "Đăng nhập thành công!";
        } else {
            return "Sai email hoặc mật khẩu!";
        }
    }

    function KiemTraDangNhapAdmin () {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        return isset($_SESSION['emailadmin']);
    }

    function DangXuatAdmin() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        session_destroy();
        header("Location: loginadmin.php");
        exit();
    }

    function LayTatCaDienThoaiAdmin($keyword = '') {
        $keyword = $this->dbadmin->real_escape_string($keyword);
        $sql = "SELECT sp.idSP, sp.tenSP, sp.gia, sp.hinhAnh, sp.soLuong, sp.moTa, sp.idHang, hsx.tenHang
                FROM SANPHAM AS sp
                JOIN HANGSANXUAT AS hsx ON sp.idHang = hsx.idHang";
        if (!empty($keyword)) {
            $sql .= " WHERE sp.tenSP LIKE '%$keyword%' OR hsx.tenHang LIKE '%$keyword%'";
        }
            $sql .= " ORDER BY sp.idSP ASC";
            $res = $this->dbadmin->query($sql);
        if (!$res) {
            die('SQL error: ' . $this->dbadmin->error);
        }

        $rows = [];
        while ($r = $res->fetch_assoc()) {
            $rows[] = $r;
        }
        return $rows;
    }

    function ThemHangSX($tenHang) {
        $tenHang = trim($tenHang);
        if (empty($tenHang)) {
            return "Tên hãng không được để trống!";
        }
        // Kiểm tra trùng tên
        $sqlCheck = "SELECT COUNT(*) AS count FROM hangsanxuat WHERE LOWER(tenHang) = LOWER(?)";
        $stmtCheck = $this->dbadmin->prepare($sqlCheck);
        $stmtCheck->bind_param("s", $tenHang);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result()->fetch_assoc();
        $stmtCheck->close();
        if ($result['count'] > 0) {
            return "Hãng sản xuất '$tenHang' đã tồn tại!";
        }
        $sql = "INSERT INTO hangsanxuat (tenHang) VALUES (?)";
        $stmt = $this->dbadmin->prepare($sql);
        $stmt->bind_param("s", $tenHang);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok ? true : "Lỗi khi thêm hãng: " . $this->dbadmin->error;
    }

    function CapNhatHangSX($idHang, $tenHang) {
        $sql = "UPDATE hangsanxuat SET tenHang=? WHERE idHang=?";
        $stmt = $this->dbadmin->prepare($sql);
        $stmt->bind_param("si", $tenHang, $idHang);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok ? true : $this->dbadmin->error;
    }

    function XoaHangSX($idHang) {
        $sql = "DELETE FROM hangsanxuat WHERE idHang=?";
        $stmt = $this->dbadmin->prepare($sql);
        $stmt->bind_param("i", $idHang);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok ? true : $this->dbadmin->error;
    }

    function ListHangSanXuat($keyword = '') {
        if ($keyword != '') {
            $like = '%' . $this->dbadmin->real_escape_string($keyword) . '%';
            $sql = "SELECT idHang, tenHang FROM hangsanxuat WHERE tenHang LIKE '$like'";
        } else {
            $sql = "SELECT idHang, tenHang FROM hangsanxuat";
        }
        $recordset = $this->dbadmin->query($sql);

        $rows = [];
        if ($recordset && $recordset->num_rows > 0) {
            while ($row = $recordset->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    function KiemTraHangSanXuatTonTai($idHang) {
        $sql = "SELECT COUNT(*) as count FROM HangSanXuat WHERE idHang = ?";
        $stmt = $this->dbadmin->prepare($sql);
        $stmt->bind_param("i", $idHang);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'] > 0;
    }

    function ThemDienThoai($tenSP, $gia, $hinhAnh, $soLuong, $moTa, $idHang) {
        $tenSP = trim($tenSP);
        $moTa = trim($moTa);
        $idHang = intval($idHang);

        // Kiểm tra trùng tên sản phẩm trong cùng hãng
        $checkSP = $this->dbadmin->prepare("SELECT COUNT(*) AS count FROM SANPHAM WHERE LOWER(tenSP) = LOWER(?) AND idHang = ?");
        $checkSP->bind_param("si", $tenSP, $idHang);
        $checkSP->execute();
        $res = $checkSP->get_result()->fetch_assoc();
        $checkSP->close();

        if ($res['count'] > 0) {
            return "Sản phẩm '$tenSP' đã tồn tại trong hãng này!";
        }

        $sql = "INSERT INTO SANPHAM (tenSP, gia, hinhAnh, soLuong, moTa, idHang) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->dbadmin->prepare($sql);
        $stmt->bind_param("sdsisi", $tenSP, $gia, $hinhAnh, $soLuong, $moTa, $idHang);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok ? true : $this->dbadmin->error;
    }


    function CapNhatDienThoai($tenSP, $gia, $hinhAnh, $soLuong, $moTa, $idHang, $idSP) {
        $sql = "UPDATE SANPHAM SET tenSP=?, gia=?, hinhAnh=?, soLuong=?, moTa=?, idHang=? WHERE idSP=?";
        $stmt = $this->dbadmin->prepare($sql);
        $stmt->bind_param("sdsisii", $tenSP, $gia, $hinhAnh, $soLuong, $moTa, $idHang, $idSP);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok ? true : $this->dbadmin->error;
    }

    function XoaDienThoai($idSP) {
        $sql = "DELETE FROM SANPHAM WHERE idSP=?";
        $stmt = $this->dbadmin->prepare($sql);
        $stmt->bind_param("i", $idSP);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok ? true : $this->dbadmin->error;
    }

    function LaySanPhamTheoID($idSP) {
        $sql = "SELECT * FROM SANPHAM WHERE idSP=?";
        $stmt = $this->dbadmin->prepare($sql);
        $stmt->bind_param("i", $idSP);
        $stmt->execute();
        $res = $stmt->get_result();
        $sp = $res->fetch_assoc();
        $stmt->close();
        return $sp;
    }

    function LayHangSanXuatTheoID($idHang) {
        $sql = "SELECT * FROM HANGSANXUAT WHERE idHang=?";
        $stmt = $this->dbadmin->prepare($sql);
        $stmt->bind_param("i", $idHang);
        $stmt->execute();
        $res = $stmt->get_result();
        $hang = $res->fetch_assoc();
        $stmt->close();
        return $hang;
    }

    function LayTatCaKhachHang($keyword = '') {
        $sql = "SELECT * FROM user";
        if (!empty($keyword)) {
            $kw = $this->dbadmin->real_escape_string($keyword);
            $sql .= " WHERE hoTen LIKE '%$kw%' OR email LIKE '%$kw%'";
        }
        $res = $this->dbadmin->query($sql);
        $rows = [];
        if ($res && $res->num_rows > 0) {
            while ($r = $res->fetch_assoc()) $rows[] = $r;
        }
        return $rows;
    }

    function LayKhachHangTheoID($id) {
        $id = intval($id);
        $sql = "SELECT * FROM user WHERE idUser = $id";
        $res = $this->dbadmin->query($sql);
        return ($res && $res->num_rows > 0) ? $res->fetch_assoc() : null;
    }

    function ThemKhachHang($ten, $email, $pass, $sdt, $diachi) {
        $ten = $this->dbadmin->real_escape_string($ten);
        $email = $this->dbadmin->real_escape_string($email);
        $sdt = $this->dbadmin->real_escape_string($sdt);
        $diachi = $this->dbadmin->real_escape_string($diachi);
        $sql = "INSERT INTO user(hoTen,email,password,soDienThoai,diaChi)
                VALUES('$ten','$email','$pass','$sdt','$diachi')";
        $ok = $this->dbadmin->query($sql);
        return $ok ? true : $this->dbadmin->error;
    }

    function CapNhatKhachHang($id, $ten, $email, $sdt, $diachi) {
        $id = intval($id);
        $ten = $this->dbadmin->real_escape_string($ten);
        $email = $this->dbadmin->real_escape_string($email);
        $sdt = $this->dbadmin->real_escape_string($sdt);
        $diachi = $this->dbadmin->real_escape_string($diachi);
        $sql = "UPDATE user SET hoTen='$ten', email='$email', soDienThoai='$sdt', diaChi='$diachi' WHERE idUser=$id";
        $ok = $this->dbadmin->query($sql);
        return $ok ? true : $this->dbadmin->error;
    }

    function XoaKhachHang($id) {
        $id = intval($id);
        $sql = "DELETE FROM user WHERE idUser=$id";
        $ok = $this->dbadmin->query($sql);
        return $ok ? true : $this->dbadmin->error;
    }

    function LayTatCaDonHang() {
        $sql = "SELECT donhang.*, user.hoTen FROM donhang JOIN user ON donhang.idUser = user.idUser ORDER BY idDH DESC";
        $res = $this->dbadmin->query($sql);
        $rows = [];
        if ($res && $res->num_rows > 0) {
            while ($r = $res->fetch_assoc()) $rows[] = $r;
        }
        return $rows;
    }

    function LayDonHangTheoID($idDH) {
        $idDH = intval($idDH);
        $sql = "SELECT * FROM donhang WHERE idDH = $idDH";
        $res = $this->dbadmin->query($sql);
        return ($res && $res->num_rows > 0) ? $res->fetch_assoc() : null;
    }

    function CapNhatDonHang($idDH, $trangThai) {
        $idDH = intval($idDH);
        $trangThai = $this->dbadmin->real_escape_string($trangThai);
        $sql = "UPDATE donhang SET trangThai='$trangThai' WHERE idDH=$idDH";
        $ok = $this->dbadmin->query($sql);
        return $ok ? true : $this->dbadmin->error;
    }

    function XoaDonHang($id) {
        $id = intval($id);
        $sql = "DELETE FROM donhang WHERE idDH=$id";
        $ok = $this->dbadmin->query($sql);
        return $ok ? true : $this->dbadmin->error;
    }

    function LayChiTietDonHang($idDH) {
        $idDH = intval($idDH);
        $sql = "SELECT sp.tenSP, ctd.soLuong, ctd.donGia, sp.hinhAnh
                FROM ctdonhang ctd
                JOIN sanpham sp ON ctd.idSP = sp.idSP
                WHERE ctd.idDH = $idDH";
        $res = $this->dbadmin->query($sql);
        $rows = [];
        if ($res && $res->num_rows > 0) {
            while ($r = $res->fetch_assoc()) $rows[] = $r;
        }
        return $rows;
    }

    function ThongKeDoanhThu($month = null, $year = null) {
        if (!$month) $month = date('m');
        if (!$year) $year = date('Y');

        $sql = "SELECT DATE(ngayDat) AS ngay, COUNT(idDH) AS tongDon, IFNULL(SUM(tongTien), 0) AS doanhThu
                FROM donhang WHERE MONTH(ngayDat) = $month AND YEAR(ngayDat) = $year AND trangThai <> 'Đã hủy'
                GROUP BY DATE(ngayDat) ORDER BY ngayDat ASC";

        $result = $this->dbadmin->query($sql);
        $rows = [];
        if ($result && $result->num_rows > 0) {
            while ($r = $result->fetch_assoc()) {
                $rows[] = $r;
            }
        }
        return $rows;
    }

    function DonHangCountByStatus() {
        $sql = "SELECT trangThai, COUNT(*) AS soLuong FROM donhang GROUP BY trangThai";
        $result = $this->dbadmin->query($sql);
        $out = [];
        if ($result && $result->num_rows > 0) {
            while ($r = $result->fetch_assoc()) {
                $out[$r['trangThai']] = intval($r['soLuong']);
            }
        }
        return $out;
    }
    }
?>
