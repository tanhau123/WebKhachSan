<?php
session_start();
require "connect.php";

$errors = [];
$thong_bao = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $ten = trim($_POST['ten']);
    $sodienthoai = trim($_POST['sodienthoai']);
    $ngaydat = trim($_POST['ngaydat']);
    $sophong = trim($_POST['sophong']);
    $songuoi = trim($_POST['songuoi']);
    $dichvu_arr = $_POST['dichvu'] ?? [];

    $dichvu = implode(", ", $dichvu_arr);

    if ($ten == "") $errors[] = "Vui lòng nhập tên.";
    if ($sodienthoai == "") $errors[] = "Vui lòng nhập số điện thoại.";
    if ($ngaydat == "") $errors[] = "Vui lòng chọn ngày đặt.";
    if ($sophong <= 0) $errors[] = "Số phòng không hợp lệ.";
    if ($songuoi <= 0) $errors[] = "Số người không hợp lệ.";

    if (empty($errors)) {

        $choxacnhan = 0;

        $sql = "INSERT INTO datphong (ten, sodienthoai, ngaydat, sophong, dichvu, songuoi, choxacnhan)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssissi", 
            $ten, 
            $sodienthoai, 
            $ngaydat, 
            $sophong, 
            $dichvu, 
            $songuoi, 
            $choxacnhan
        );

        if ($stmt->execute()) {
            $_SESSION['thong_bao'] = "Đặt phòng thành công!";
        } else {
            $_SESSION['errors'] = ["Lỗi SQL! Không lưu được dữ liệu."];
        }

        $stmt->close();
        $conn->close();

    } else {
        $_SESSION['errors'] = $errors;
    }

    header("Location: datphong.php");
    exit;
}
?>
