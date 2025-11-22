<?php
$conn = new mysqli("localhost", "root", "", "webkhachsan");
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Lỗi kết nối database: " . $conn->connect_error);
}
?>
