-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 13, 2025 lúc 09:27 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webdienthoai`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `idadmin` int(11) NOT NULL,
  `emailadmin` varchar(100) NOT NULL,
  `passwordadmin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`idadmin`, `emailadmin`, `passwordadmin`) VALUES
(1, 'lengoctrinh2712@gmail.com', 'adminlatui');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ctdonhang`
--

CREATE TABLE `ctdonhang` (
  `idDH` int(11) NOT NULL,
  `idSP` int(11) NOT NULL,
  `soLuong` int(11) DEFAULT NULL,
  `donGia` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ctdonhang`
--

INSERT INTO `ctdonhang` (`idDH`, `idSP`, `soLuong`, `donGia`) VALUES
(2, 3, 1, 13999000.00),
(3, 2, 1, 18999000.00),
(3, 3, 2, 13999000.00),
(4, 2, 1, 18999000.00),
(5, 1, 1, 28999000.00),
(6, 10, 1, 12990000.00),
(8, 4, 1, 18999000.00),
(10, 10, 3, 12990000.00),
(11, 9, 1, 39999000.00),
(12, 9, 1, 39999000.00),
(14, 8, 1, 9990000.00),
(15, 7, 1, 21999000.00),
(16, 8, 1, 9990000.00),
(17, 9, 1, 39999000.00),
(18, 8, 1, 9990000.00),
(18, 10, 1, 12990000.00),
(19, 10, 2, 12990000.00),
(22, 8, 1, 9990000.00),
(22, 9, 1, 39999000.00),
(23, 3, 1, 13999000.00),
(23, 4, 1, 18999000.00),
(24, 10, 1, 12990000.00),
(31, 9, 1, 39999000.00),
(32, 5, 1, 9990000.00),
(32, 8, 1, 9990000.00),
(32, 10, 1, 12990000.00),
(33, 8, 2, 9990000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgia`
--

CREATE TABLE `danhgia` (
  `idDG` int(11) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idSP` int(11) DEFAULT NULL,
  `soSao` int(11) DEFAULT NULL,
  `binhLuan` text DEFAULT NULL,
  `ngayDanhGia` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danhgia`
--

INSERT INTO `danhgia` (`idDG`, `idUser`, `idSP`, `soSao`, `binhLuan`, `ngayDanhGia`) VALUES
(17, 11, 9, 5, 'MÊ', '2025-11-08 05:51:12'),
(18, 11, 8, 5, 'ỔN', '2025-11-08 06:24:22'),
(19, 11, 10, 4, 'CŨNG CŨNG', '2025-11-08 06:24:30'),
(20, 10, 9, 5, 'okkkkkk', '2025-11-14 02:02:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `idDH` int(11) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `diaChiNhanHang` text NOT NULL,
  `ngayDat` datetime NOT NULL,
  `tongTien` decimal(10,2) DEFAULT NULL,
  `trangThai` varchar(50) DEFAULT NULL,
  `ghiChu` text NOT NULL,
  `pttt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`idDH`, `idUser`, `diaChiNhanHang`, `ngayDat`, `tongTien`, `trangThai`, `ghiChu`, `pttt`) VALUES
(2, 7, 'hcm', '2025-11-06 01:25:27', 13999000.00, 'Chờ xác nhận', '', 'cod'),
(3, 7, 'hcm', '2025-11-06 01:39:26', 46997000.00, 'Chờ xác nhận', '', 'card'),
(4, 7, 'hcm', '2025-11-06 07:33:47', 18999000.00, 'Đang giao', '', 'cod'),
(5, 10, '77/3d Song Hành Hóc Môn', '2025-11-06 10:06:11', 28999000.00, 'Đang giao', 'Màu xám titan', 'card'),
(6, 10, '77/3d Song Hành Hóc Môn', '2025-11-06 21:56:42', 12990000.00, 'Chờ xác nhận', '', 'card'),
(8, 10, 'hcm', '2025-11-07 18:48:28', 18999000.00, 'Chờ xác nhận', '', 'cod'),
(10, 10, 'hcm', '2025-11-08 03:29:33', 38970000.00, 'Chờ xác nhận', '', 'cod'),
(11, 10, 'hcm', '2025-11-08 04:05:22', 39999000.00, 'Chờ xác nhận', '', 'cod'),
(12, 10, '415 Trường Chinh', '2025-11-08 04:06:10', 39999000.00, 'Chờ xác nhận', '', 'cod'),
(14, 11, '77/3d Song Hành Hóc Môn', '2025-11-08 04:12:54', 9990000.00, 'Chờ xác nhận', '', 'cod'),
(15, 11, '77/3d Song Hành Hóc Môn', '2025-11-08 04:16:33', 21999000.00, 'Chờ xác nhận', '', 'cod'),
(16, 11, '415 Trường Chinh', '2025-11-08 04:26:07', 9990000.00, 'Chờ xác nhận', '', 'cod'),
(17, 11, '415 Trường Chinh', '2025-11-08 04:27:12', 39999000.00, 'Hoàn thành', '', 'cod'),
(18, 11, '516 tc', '2025-11-08 06:07:10', 22980000.00, 'Hoàn thành', '', 'cod'),
(19, 11, '516 tc', '2025-11-08 16:11:10', 25980000.00, 'Chờ xác nhận', '', 'cod'),
(22, 10, '\\', '2025-11-10 20:11:12', 49989000.00, 'Chờ xác nhận', '', 'card'),
(23, 10, '77/3d Song Hành Hóc Môn', '2025-11-11 03:53:05', 32998000.00, 'Chờ xác nhận', '', 'cod'),
(24, 10, '77/3d Song Hành Hóc Môn', '2025-11-11 04:10:48', 12990000.00, 'Đã hủy', '', 'cod'),
(31, 10, '77/3d Song Hành Hóc Môn', '2025-11-11 07:14:16', 39999000.00, 'Hoàn thành', '', 'cod'),
(32, 10, '', '2025-11-14 03:03:14', 32970000.00, 'Hoàn thành', '', 'cod'),
(33, 10, '', '2025-11-14 03:05:01', 19980000.00, 'Chờ xác nhận', '', 'cod');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `idUser` int(11) NOT NULL,
  `idSP` int(11) NOT NULL,
  `soLuong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`idUser`, `idSP`, `soLuong`) VALUES
(7, 1, 1),
(9, 3, 1),
(11, 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hangsanxuat`
--

CREATE TABLE `hangsanxuat` (
  `idHang` int(11) NOT NULL,
  `tenHang` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hangsanxuat`
--

INSERT INTO `hangsanxuat` (`idHang`, `tenHang`) VALUES
(1, 'Apple'),
(2, 'Xiaomi'),
(3, 'Samsung'),
(4, 'Oppo'),
(5, 'Vivo');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `idSP` int(11) NOT NULL,
  `idHang` int(11) NOT NULL,
  `tenSP` varchar(225) DEFAULT NULL,
  `gia` decimal(10,2) DEFAULT NULL,
  `soLuong` int(11) DEFAULT NULL,
  `hinhAnh` varchar(225) DEFAULT NULL,
  `moTa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`idSP`, `idHang`, `tenSP`, `gia`, `soLuong`, `hinhAnh`, `moTa`) VALUES
(1, 1, 'iPhone 15 Pro Max', 28999000.00, 29, 'iphone15promax.jpg', 'Flagship mạnh mẽ nhất của Apple, chip A17 Pro, camera 48MP.'),
(2, 1, 'iPhone 14', 18999000.00, 30, 'iphone14_.jpg', 'Hiệu năng mạnh mẽ, camera sắc nét, hỗ trợ iOS 18.'),
(3, 1, 'iPhone 13 Mini', 13999000.00, 15, 'iphone13mini.jpg', 'Nhỏ gọn, tiện lợi, pin bền.'),
(4, 2, 'Xiaomi 14 Ultra', 18999000.00, 26, 'xiaomi14ultra.jpg', 'Camera Leica, hiệu năng Snapdragon 8 Gen 3.'),
(5, 2, 'Redmi Note 13 Pro+', 9990000.00, 40, 'redminote13proplus.jpg', 'Giá rẻ, cấu hình mạnh, pin khủng.'),
(6, 3, 'Samsung Galaxy S24 Ultra', 27999000.00, 20, 's24ultra.jpg', 'Bút S-Pen, màn hình 120Hz, camera 200MP.'),
(7, 3, 'Samsung Galaxy Z Flip5', 21999000.00, 18, 'zflip5.jpg', 'Thiết kế gập thời thượng, hiệu năng cao.'),
(8, 3, 'Samsung Galaxy A55', 9990000.00, 31, 'a55.jpg', 'Thiết kế sang trọng, pin lớn, hiệu năng ổn định.'),
(9, 1, 'iPhone 17', 39999000.00, 13, 'iphone17.jpg', 'Thiết kế viền siêu mỏng, chip A19 Bionic mới nhất, camera AI tự động tối ưu ánh sáng và hiệu ứng chân dung.'),
(10, 4, 'Oppo Reno10 Pro', 12990000.00, 15, 'OppoReno10Pro.jpg', 'Camera tele 32 MP chân dung, chip Snapdragon 778G, màn AMOLED 120 Hz 6.7 inch. Pin 4600 mAh, sạc SUPERVOOC 80 W, thân máy mỏng 7.9 mm');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `hoTen` varchar(100) DEFAULT NULL,
  `diaChi` varchar(255) DEFAULT NULL,
  `soDienThoai` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`idUser`, `email`, `password`, `hoTen`, `diaChi`, `soDienThoai`) VALUES
(2, 'tradaocamsa272000@gmail.com', '12345678', 'hân', 'hcm', '0909090909'),
(3, '2431540114@vaa.edu.vn', '12345', 'trinh', '', ''),
(4, 'lengocminhhan2000@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '0909090909'),
(7, '1234@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', 'trúc', 'hcm', '0928147346'),
(8, '12@gmail.com', '202cb962ac59075b964b07152d234b70', 'hân', NULL, '0909546478'),
(9, '1@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'nghi', NULL, '0928147346'),
(10, 'nghi0702@gmail.com', '2d5cca32543262f75dcadff0e3095737', 'gia nghi', '', '077698779'),
(11, '12345@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', 'trinh', '516 tc', '0928147346');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idadmin`);

--
-- Chỉ mục cho bảng `ctdonhang`
--
ALTER TABLE `ctdonhang`
  ADD PRIMARY KEY (`idDH`,`idSP`),
  ADD KEY `idDH` (`idDH`),
  ADD KEY `idSP` (`idSP`);

--
-- Chỉ mục cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD PRIMARY KEY (`idDG`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idSP` (`idSP`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`idDH`),
  ADD KEY `idUser` (`idUser`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`idUser`,`idSP`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idSP` (`idSP`);

--
-- Chỉ mục cho bảng `hangsanxuat`
--
ALTER TABLE `hangsanxuat`
  ADD PRIMARY KEY (`idHang`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`idSP`),
  ADD KEY `idHang` (`idHang`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `idadmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  MODIFY `idDG` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `donhang`
--
ALTER TABLE `donhang`
  MODIFY `idDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `hangsanxuat`
--
ALTER TABLE `hangsanxuat`
  MODIFY `idHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `idSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `ctdonhang`
--
ALTER TABLE `ctdonhang`
  ADD CONSTRAINT `ctdonhang_ibfk_1` FOREIGN KEY (`idDH`) REFERENCES `donhang` (`idDH`),
  ADD CONSTRAINT `ctdonhang_ibfk_2` FOREIGN KEY (`idSP`) REFERENCES `sanpham` (`idSP`);

--
-- Các ràng buộc cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD CONSTRAINT `danhgia_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`),
  ADD CONSTRAINT `danhgia_ibfk_2` FOREIGN KEY (`idSP`) REFERENCES `sanpham` (`idSP`);

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`),
  ADD CONSTRAINT `giohang_ibfk_2` FOREIGN KEY (`idSP`) REFERENCES `sanpham` (`idSP`);

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`idHang`) REFERENCES `hangsanxuat` (`idHang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
