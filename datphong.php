<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

// =====================================
// XỬ LÝ LOGIC SERVER TRONG CHÍNH FILE
// =====================================
$thong_bao = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Nhận dữ liệu từ form
    $ten = trim($_POST['ten'] ?? '');
    $sodienthoai = trim($_POST['sodienthoai'] ?? '');
    $ngaydat = trim($_POST['ngaydat'] ?? '');
    $sophong = trim($_POST['sophong'] ?? '');
    $songuoi = trim($_POST['songuoi'] ?? '');
    $dichvu_arr = $_POST['dichvu'] ?? [];

    // Ghép dịch vụ thành chuỗi
    $dichvu = implode(", ", $dichvu_arr);

    // =============================
    // Validate đơn giản
    // =============================
    if ($ten === '') $errors[] = "Vui lòng nhập họ tên.";
    if ($sodienthoai === '') $errors[] = "Vui lòng nhập số điện thoại.";
    if ($ngaydat === '') $errors[] = "Vui lòng chọn ngày đặt.";
    if ($sophong === '' || $sophong <= 0) $errors[] = "Số phòng không hợp lệ.";
    if ($songuoi === '' || $songuoi <= 0) $errors[] = "Số người không hợp lệ.";

    // Nếu không lỗi → lưu vào database
    if (empty($errors)) {

        // Kết nối DB
        $conn = new mysqli("localhost", "root", "", "webkhachsan");
        $conn->set_charset("utf8");

        if ($conn->connect_error) {
            die("Lỗi kết nối database: " . $conn->connect_error);
        }

        // Trạng thái mặc định: 0 = chờ xác nhận
        $choxacnhan = 0;

        $sql = "INSERT INTO datphong (ten, sodienthoai, ngaydat, sophong, dichvu, songuoi, choxacnhan) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
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
                $thong_bao = "Đặt phòng thành công! Đang chờ nhân viên xác nhận.";
            } else {
                $errors[] = "Không thể lưu dữ liệu!";
            }

            $stmt->close();
        } else {
            $errors[] = "Lỗi truy vấn SQL, kiểm tra lại cấu trúc bảng.";
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đặt Phòng</title>

<style>
    body {
        font-family: Arial, sans-serif;
        background: #f5f5f5;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 800px;
        margin: 40px auto;
        padding: 25px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.15);
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
    }
    .form-group {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    label {
        font-weight: bold;
        margin-bottom: 5px;
    }
    input, select {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }
    .services-box label {
        display: inline-block;
        margin-right: 10px;
        font-weight: normal;
    }
    .btn {
        display: block;
        margin: 20px auto 0;
        padding: 10px 30px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        font-weight: bold;
    }
    .btn:hover {
        opacity: 0.9;
    }
    .alert-success {
        padding: 10px;
        background: #d4edda;
        color: #155724;
        border-radius: 6px;
        margin-bottom: 15px;
    }
    .alert-error {
        padding: 10px;
        background: #f8d7da;
        color: #721c24;
        border-radius: 6px;
        margin-bottom: 15px;
    }
</style>
</head>

<body>
<div class="container">

    <h2>ĐẶT PHÒNG KHÁCH SẠN</h2>

    <!-- HIỂN THỊ THÔNG BÁO -->
    <?php if ($thong_bao): ?>
        <div class="alert-success"><?= $thong_bao ?></div>
    <?php endif; ?>

    <!-- HIỂN THỊ LỖI -->
    <?php if (!empty($errors)): ?>
        <div class="alert-error">
            <?php foreach ($errors as $e): ?>
                <div>• <?= $e ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST">

        <div class="form-row">
            <div class="form-group">
                <label>Họ tên người đặt</label>
                <input type="text" name="ten" required>
            </div>

            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" name="sodienthoai" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Ngày đặt</label>
                <input type="date" name="ngaydat" required>
            </div>

            <div class="form-group">
                <label>Số phòng</label>
                <input type="number" name="sophong" min="1" required>
            </div>
        </div>

        <div class="form-group">
            <label>Số người</label>
            <input type="number" name="songuoi" min="1" required>
        </div>

        <div class="form-group">
            <label>Dịch vụ đi kèm:</label>
            <div class="services-box">
                <label><input type="checkbox" name="dichvu[]" value="Ăn sáng"> Ăn sáng</label>
                <label><input type="checkbox" name="dichvu[]" value="Đưa đón sân bay"> Đưa đón sân bay</label>
                <label><input type="checkbox" name="dichvu[]" value="Spa"> Spa</label>
                <label><input type="checkbox" name="dichvu[]" value="Giặt ủi"> Giặt ủi</label>
            </div>
        </div>

        <button type="submit" class="btn">Đặt phòng</button>

    </form>
</div>
</body>
</html>
