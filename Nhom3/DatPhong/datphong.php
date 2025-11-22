<?php
session_start();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đặt Phòng</title>
<link rel="stylesheet" href="datphong.css">
</head>

<body>

<div class="container">
    <h2>ĐẶT PHÒNG KHÁCH SẠN</h2>

    <!-- THÔNG BÁO -->
    <?php if(isset($_SESSION['thong_bao'])): ?>
        <div class="alert-success"><?php echo $_SESSION['thong_bao']; unset($_SESSION['thong_bao']); ?></div>
    <?php endif; ?>

    <!-- LỖI -->
    <?php if(isset($_SESSION['errors'])): ?>
        <div class="alert-error">
            <?php 
            foreach($_SESSION['errors'] as $e) echo "<div>• $e</div>";
            unset($_SESSION['errors']);
            ?>
        </div>
    <?php endif; ?>

    <form action="server_datphong.php" method="POST">

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
